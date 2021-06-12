<?php

namespace App\Http\Requests;

use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Foundation\Http\FormRequest;

class PurchaseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "client_token"  => "required|exists:devices",
            "reciept"       => "required",
            "os_username"   => "required",
            "os_password"   => "required",
        ];
    }

    public function messages() 
    {
        return [
            "client_token.required"  => "client_token parametresi gönderimi zorunludur.",
            "client_token.exists"    => "client_token sistemde kayıtlı değildir.",
            "reciept.required"       => "reciept paramteresi gönderimi zorunludur",
            "os_username.required"   => "operating-system kontrolü için username alanı zorunludur.",
            "os_password.required"   => "operating-system kontrolü için password alanı zorunludur.",
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();

        throw new HttpResponseException(
            response()->json(['errors' => $errors], JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
        );
    }
    
}
