<?php

namespace App\Http\Requests;

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
            // CREATE
            case 'POST':
                {
                    return [
                        'tag_name' => 'required|unique'
                    ];
                }
            // UPDATE
            case 'PUT':
            case 'PATCH':
                {
                    return [

                    ];
                }
            case 'GET':
            case 'DELETE':
            default:
                {
                    return [];
                };
        }
    }

    public function messages()
    {
        switch ($this->method()) {
            // CREATE
            case 'POST':
                {
                    return [

                    ];
                }
            // UPDATE
            case 'PUT':
            case 'PATCH':
                {
                    return [

                    ];
                }
            case 'GET':
            case 'DELETE':
            default:
                {
                    return [];
                }
        }
    }
}
