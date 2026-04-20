<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class ProjectRequest extends FormRequest
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
                'title' => 'required',
                'image' => 'required',
                'description' => 'required',
            ];
        } else {
            return [
                'title' => 'required',
                'description' => 'required',
            ];
        }
    }

    public function messages()
    {
        return [
            'title.required' => 'Title is required',
            'image.required' => 'Image is required',
            'description.required' => 'Description is required',
        ];
    }
}
