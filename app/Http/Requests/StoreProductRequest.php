<?php

namespace App\Http\Requests;

use App\Models\Product;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreProductRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('product_create');
    }

    public function rules()
    {
        $validateRules = [
            'name' => [
                'bail',
                'required',
                'string',
            ],
            'sku' => [
                'bail',
                'required',
                'string',
            ],
            'slug' => [
                'bail',
                'string',
                'nullable',
            ],
            'quantity' => [
                'bail',
                'required',
                'string',
            ],
            'short_description' => [
                'required',
            ],
            'photo' => [
                'bail',
                'required',
            ],
            'price' => [
                'bail',
                'required',
            ],
            'discount' => [
                'bail',
                'string',
                'nullable',
            ],
            'discount_price' => [
                'bail',
                'string',
                'nullable',
            ],
            'status' => [
                'bail',
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'featured_product' => [
                'bail',
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'new_arrival' => [
                'bail',
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'on_sale' => [
                'bail',
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'categories.*' => [
                'bail',
                'required',
                'integer',
            ],
            'categories' => [
                'array',
            ],
            'tags.*' => [
                'integer',
            ],
            'tags' => [
                'array',
            ],
            'colors.*' => [
                'integer',
            ],
            'colors' => [
                'array',
            ],
            'sizes.*' => [
                'integer',
            ],
            'sizes' => [
                'array',
            ],
            'brand' => [
                'bail',
                'required',
                'integer',
            ],
            'galleries' => [
                'nullable',
                'string',
            ],
        ];

        if (isset($this->is_variation) && $this->is_variation == 1) {
            $validateRules = array_merge($validateRules, [
                'variations.*' => [
                    'bail',
                    'array',
                    'required'
                ]
            ]);
        }
        return $validateRules;
    }
}
