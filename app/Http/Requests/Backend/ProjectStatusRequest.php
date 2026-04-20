<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class ProjectStatusRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        if ($_REQUEST['_method'] == "POST") {
            return [
                'status' => 'required',
            ];
        } else {
            return [
                'status' => 'required',
            ];
        }
    }

    public function messages()
    {
        return [
            'status.required' => 'Status is required',
        ];
    }
}
