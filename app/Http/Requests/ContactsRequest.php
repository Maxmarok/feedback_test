<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactsRequest extends FormRequest
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
            'name' => 'required|string|min:3,max:200',
            'email' => 'required_without:phone|email|min:6,max:200',
            'phone' => 'required_without:email|numeric|min:11,max:200',
        ];
    }

    protected function prepareForValidation()
    {
        if($this->request->has('phone')){
            $this->merge(['phone' => intval($this->request->get('phone'))]);
        }
    }
}
