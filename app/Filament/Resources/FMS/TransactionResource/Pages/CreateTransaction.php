<?php

namespace App\Filament\Resources\FMS\TransactionResource\Pages;

use App\Constant\FMS\AccountType;
use App\Constant\FMS\FinanceType;
use App\Filament\Resources\FMS\TransactionResource;
use App\Models\FMS\Account;
use App\Models\FMS\Transaction;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Str;

class CreateTransaction extends CreateRecord
{
    protected static string $resource = TransactionResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['uuid'] = Str::uuid();
        $data['user_id'] = auth()->id();
        $data['currency_id'] = auth()->user()->financeSettings->currency_id ?? 1;

        return $data;
    }

    protected function afterCreate(): void
    {
        /** @var Transaction $transaction */
        $transaction = $this->record;

        $account = Account::find($transaction->account_id);

        if ($account) {
            if ($transaction->type == FinanceType::Income) {
                $account->increment('balance', $transaction->amount);
            }
            if ($transaction->type == FinanceType::Expense) {
                if ($account->type == AccountType::Credit) {
                    $account->increment('balance', $transaction->amount);
                } else {
                    $data = max($account->balance - $transaction->amount, 0);

                    $account->update(['balance' => $data]);
                }
            }
        }
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
