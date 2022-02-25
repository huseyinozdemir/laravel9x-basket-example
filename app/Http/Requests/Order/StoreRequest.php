<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return True;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'customer_id' => [
                'required',
                Rule::exists('customers', 'id')
            ],
            'items.*.product_id' => [
                'required',
                Rule::exists('products', 'id')
            ],
            'items.*.quantity' => [
                'required',
                'integer',
            ],
            'items.*.unit_price' => [
                'required',
                'numeric',
            ],
            
        ];
    }
}
