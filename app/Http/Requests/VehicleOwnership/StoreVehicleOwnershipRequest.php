<?php

/*
 * @copyright (c) 2025 Pragith Lakshan Thilakarathna
 * All rights reserved. 
 * This code is proprietary to CJNextGenSys. 
 * Unauthorized use, reproduction, modification, distribution, or sale 
 * without the explicit written permission of CJNextGenSys is strictly prohibited.
 * For inquiries, please contact: [info@cjnextgensys.com]
*/

namespace App\Http\Requests\VehicleOwnership;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

/**
 * @OA\Schema(
 *     schema="StoreVehicleOwnershipRequest",
 *     type="object",
 *     title="Vehicle Ownership Create Request",
 *     required={"vehicleId", "vehicleOwnerId", "startDate"},
 *     @OA\Property(property="vehicleId", type="integer", example="1"),
 *     @OA\Property(property="vehicleOwnerId", type="integer", example="3"),
 *     @OA\Property(property="startDate", type="string", example="2024-12-01")
 * )
 */
class StoreVehicleOwnershipRequest extends FormRequest
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
                Rule::exists('vehicles', 'id'),
            ],
            'vehicleOwnerId' => [
                'required', 
                'integer',
                Rule::exists('vehicle_owners', 'id'),
            ],
            'startDate' => ['required', 'date']
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        // Get validation errors as a flat array
        $errors = $validator->errors()->all();

        throw new HttpResponseException(response()->json(['errors' => $errors], 422));
    }
}