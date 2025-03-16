<?php

/*
 * @copyright (c) 2025 Pragith Lakshan Thilakarathna
 * All rights reserved. 
 * This code is proprietary to CJNextGenSys. 
 * Unauthorized use, reproduction, modification, distribution, or sale 
 * without the explicit written permission of CJNextGenSys is strictly prohibited.
 * For inquiries, please contact: [info@cjnextgensys.com]
*/

namespace App\Http\Requests\VehicleOwner;

use App\Enums\Salutation;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

/**
 * @OA\Schema(
 *     schema="UpdateVehicleOwnerRequest",
 *     type="object",
 *     title="Vehicle Owner Update Request",
 *     required={"NIC", "telephoneNo", "salutation", "name"},
 *     @OA\Property(property="NIC", type="string", example="772345598V"),
 *     @OA\Property(property="telephoneNo", type="string", example="0711212121"),
 *     @OA\Property(property="salutation", type="string", example="MR"),
 *     @OA\Property(property="name", type="string", example="Nishantha")
 * )
 */
class UpdateVehicleOwnerRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'NIC' => [
                'required', 
                'max:15',
                Rule::unique('vehicle_owners', 'NIC')->ignore($this->id)
            ],
            'telephoneNo' => ['required', 'size:10'],
            'salutation' => [
                'required', 
                'max:10', 
                Rule::in(Salutation::getValues())
            ],
            'name' => ['required', 'max:255']
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        // Get validation errors as a flat array
        $errors = $validator->errors()->all();

        throw new HttpResponseException(response()->json(['errors' => $errors], 422));
    }
}