<?php

/*
 * @copyright (c) 2025 Pragith Lakshan Thilakarathna
 * All rights reserved. 
 * This code is proprietary to CJNextGenSys. 
 * Unauthorized use, reproduction, modification, distribution, or sale 
 * without the explicit written permission of CJNextGenSys is strictly prohibited.
 * For inquiries, please contact: [info@cjnextgensys.com]
*/

namespace App\Http\Requests\MileageHistory;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\Rule;

/**
 * @OA\Schema(
 *     schema="StoreMileageHistoryRequest",
 *     type="object",
 *     title="Mileage History Create Request",
 *     required={"vehicleId", "mileage"},
 *     @OA\Property(property="vehicleId", type="integer", example="1"),
 *     @OA\Property(property="mileage", type="double", example="10"),
 * )
 */
class StoreMileageHistoryRequest extends FormRequest
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
            'vehicleId' => [
                'required', 
                'integer', 
                Rule::exists('vehicles', 'id')
            ],
            'mileage' => ['required', 'numeric', 'min:0']
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        // Get validation errors as a flat array
        $errors = $validator->errors()->all();

        throw new HttpResponseException(response()->json(['errors' => $errors], 422));
    }
}