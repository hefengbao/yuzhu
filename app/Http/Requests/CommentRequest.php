<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommentRequest extends FormRequest
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
        return [
            'comment_author' => 'required|max:50',
            'comment_author_email' => 'required',
            'comment_content' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'comment_author.required' => '名字不能为空',
            'comment_author_email.require' => '邮箱不能为空',
            'comment_content.required' => '内容不能为空',
        ];
    }
}
