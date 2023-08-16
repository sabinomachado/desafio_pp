<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaymentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'payment_method' => [
                'required'
            ],
            'name' => [
                'required', 
                'min:3',
                'max:255'
            ],
            'email' => [
                'required',
                'email'
            ],
            'cpfCnpj' => [
                'required',
                'min:11'
            ],
            'phone' => [
                'required'
            ],
            'holderName' => [
                'required_if:payment_method,CREDIT_CARD'
            ],
            'card_number' => [
                'required_if:payment_method,CREDIT_CARD'
            ],
            'card_expiry' => [
                'required_if:payment_method,CREDIT_CARD'
            ],
            'cvv' => [
                'required_if:payment_method,CREDIT_CARD'
            ],
            'name_titular' => [
                'required_if:payment_method,CREDIT_CARD'
            ],
            'email_titular' => [
                'required_if:payment_method,CREDIT_CARD'
            ],
            'cpfCnpj_titular' => [
                'required_if:payment_method,CREDIT_CARD'
            ],
            'phone_titular' => [
                'required_if:payment_method,CREDIT_CARD'
            ],
            'cep_titular' => [
                'required_if:payment_method,CREDIT_CARD'
            ],
            'residencia_titular' => [
                'required_if:payment_method,CREDIT_CARD'
            ],
            ['residencia_titular.required_if' => 'Campo obrigatório']
        ];
    }
}
