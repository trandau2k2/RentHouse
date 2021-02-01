<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'email' =>'required|email',
            'password'=> 'required'
        ];
    }
    public function messages()
    {
        return [
            'email.required'=>'Truong nay khong duoc de trong',
            'password.required'=>'Truong nay khong duoc de trong',
            'email.email'=>'Khong dung dinh danng',
        ];
    }
}
