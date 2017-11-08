<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreatePostRequest extends FormRequest
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
            //
            'post_title'=> 'required|max:100',
            'post_slug'=>'required|unique:posts|max:100',
            'post_content'=>'required'
        ];
    }

    public function messages()
    {
        return [
            'post_title.required' => '标题不能为空',
            'post_title.max'=>'标题不能超过 100 字',
            'post_slug.require'=>'链接不能为空',
            'post_slug.unique'=>'链接名称已存在，请重新填写',
            'post_slug.max'=>'链接不能超过 100 字',
            'post_content.required' => '内容不能为空'
        ];
    }
}
