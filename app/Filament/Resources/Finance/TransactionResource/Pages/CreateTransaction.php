<?php

namespace App\Filament\Resources\Finance\TransactionResource\Pages;

use App\Constant\Finance\AccountType;
use App\Constant\Finance\FinanceType;
use App\Filament\Resources\Finance\TransactionResource;
use App\Models\Finance\Account;
use App\Models\Finance\Transaction;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Log;
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
