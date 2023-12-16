<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
        switch ($this->method()) {
            // CREATE
            case 'POST':
            case 'PATCH':

                return [
                    'name' => 'required|unique:categories',
                    'slug' => 'required|unique:categories',
                ];

            default:

                return [];

        }
    }

    public function messages()
    {
        return [
            'name.required' => '名称不能为空',
            'name.unique' => '名称不能重复',
            'slug.required' => '别名不能为空',
            'slug.unique' => '别名不能重复',
        ];
    }
}
