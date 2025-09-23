<?php

namespace App\Http\Requests\CMS;

use Illuminate\Foundation\Http\FormRequest;

class TagRequest extends FormRequest
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
            case 'POST':
            case 'PATCH':

                return [
                    'name' => 'required|unique:tags',
                    'slug' => 'nullable|unique:tags',
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
            'slug.unique' => '别名不能重复',
        ];
    }
}
