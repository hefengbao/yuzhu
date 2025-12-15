<?php

namespace App\Http\Requests\FMS;

use App\Models\FMS\Group;
use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TransactionRequest extends FormRequest
{
    protected $stopOnFirstFailure = true;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        /** @var User $user */
        $user = auth()->user();

        return match ($this->method()) {
            'POST', 'PATCH' => [
                'account_id' => [
                    'required',
                    Rule::exists('fms_accounts', 'id')
                        ->where(function (Builder $builder) use ($user) {
                            $builder->where('user_id', $user->id);
                        })],
                'type' => 'required|in:income,expense',
                'date' => 'required|date_format:Y-m-d',
                'category_id' => [
                    'required',
                    Rule::exists('fms_categories', 'id')//TODO
                        ->where(function (Builder $builder) use ($user) {
                            $builder->whereIn(
                                'group_id',
                                Group::where('type', $this->request->get('type'))
                                    ->where('user_id', $user->id)
                                    ->pluck('id')
                                    ->toArray()
                            );
                        })],
                'amount' => 'required|numeric',
            ],
            default => [],
        };
    }
}
