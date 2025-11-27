<?php

namespace App\Http\Requests;

use Gate;
use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
{
    public function authorize()
    {
//        return Gate::allows('*');
        return true;
    }

    public function rules()
    {
        return [
            'order_customer.*.name' => [
                'bail',
                'required'
            ],
            'order_customer.*.phone' => [
                'bail',
                'required'
            ],
            'order_customer.*.address' => [
                'bail',
                'required'
            ],
        ];
    }
}
