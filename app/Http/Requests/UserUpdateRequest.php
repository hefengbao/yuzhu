<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        // https://learnku.com/docs/laravel/9.x/validation/12219#314932
        // PUT|PATCH       admin/users/{user} ................. admin.users.update › Admin\UserController@update
        // $this->route('user') 中的 user 指代的是 admin/users/{user} 中的 user
        $user = User::findOrFail($this->route('user'));

        return [
            'name' => 'required|max:255',
            'email' => ['required',
                Rule::unique('users')->ignore($user),
            ],
            'avatar' => ['nullable', 'file', 'image']
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '用户名不能为空',
            'email.unique' => '邮箱不能重复',
        ];
    }
}
