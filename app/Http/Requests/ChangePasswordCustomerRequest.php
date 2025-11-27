<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordCustomerRequest extends FormRequest
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
            'name'=>'string|required|max:30',
            'email'=>'string|required|',
            'phone'=>'required',
            'password' => 'confirmed',
        ];
    }
    public function messages()
    {
        return [
            'required'=>':attribute không được để trống',
            'min' => ':attribute tối thiểu phải có 6 ký tự',
            'max' => ':attribute tối đa chỉ 50 ký tự',
            'confirmed' => ':attribute lặp lại chưa đúng',
        ];
    }
    public function attributes()
    {
        return [
            'name' => 'Họ Và Tên',
            'email' => 'Email',
            'password' => 'Mật Khẩu',
            'customer_password' => 'Mật khẩu',
            'phone' => 'Số điện thoại',
        ];
    }
}
