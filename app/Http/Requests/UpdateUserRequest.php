<?php

namespace App\Http\Requests;

use App\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest {
    public $allowed_fields = [
        'name',
        'email',
        'website',
        'github',
        'weibo',
        'city',
        'company',
        'introduction'
    ];

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            'name' => 'required|max:255',
            'email' => ['required',
                Rule::unique('users')->ignore($this->user()->id),
            ],
        ];
    }

    public function messages() {
        return [
            'email.unique' => '邮箱不能重复',
        ];
    }

    public function update(User $user) {
        $data = array_filter($this->only($this->allowed_fields));
        // 头像
        if ($file = $this->file('avatar')) {
            $upload_status = app('App\One\Handler\ImageUploadHandler')->uploadAvatar($file);
            $data['avatar'] = $upload_status['filename'];
        }
        // 微信支付二维码
        if ($file = $this->file('wechatpay')) {
            $upload_status = app('App\One\Handler\ImageUploadHandler')->uploadImage($file);
            $data['wechatpay'] = $upload_status['filename'];
        }

        // 微信二维码
        if ($file = $this->file('wechat')) {
            $upload_status = app('App\One\Handler\ImageUploadHandler')->uploadImage($file);
            $data['wechat'] = $upload_status['filename'];
        }

        // 支付宝二维码
        if ($file = $this->file('alipay')) {
            $upload_status = app('App\One\Handler\ImageUploadHandler')->uploadImage($file);
            $data['alipay'] = $upload_status['filename'];
        }
        $user->update($data);
        return $user;
    }
}
