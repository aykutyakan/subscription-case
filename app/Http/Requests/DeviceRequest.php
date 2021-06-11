<?php

namespace App\Http\Requests;

use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Foundation\Http\FormRequest;

class DeviceRequest extends FormRequest
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
            "uid" => "required",
            "app_id" => "required",
            "language"=> "required",
            "operating_system"=> "required",
        ];
    }

    public function messages()
    {
        return [
            "uid.required" => "Device ID zorunludur",
            "app_id.reuired"=> "Uygulama ID zorunludur",
            "language.required"=> "Dil seçimi zorunludur.",
            "operating_system"=> "İşletim Sistemi zorunludur.",
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
