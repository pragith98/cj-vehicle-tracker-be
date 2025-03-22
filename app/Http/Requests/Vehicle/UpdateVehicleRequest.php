<?php

/*
 * @copyright (c) 2025 Pragith Lakshan Thilakarathna
 * All rights reserved. 
 * This code is proprietary to CJNextGenSys. 
 * Unauthorized use, reproduction, modification, distribution, or sale 
 * without the explicit written permission of CJNextGenSys is strictly prohibited.
 * For inquiries, please contact: [info@cjnextgensys.com]
*/

namespace App\Http\Requests\Vehicle;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

/**
 * @OA\Schema(
 *     schema="UpdateVehicleRequest",
 *     type="object",
 *     title="Vehicle Update Request",
 *     required={"mileageTrackerId", "vehicleNo", "chassisNo", "currentMileage"},
 *     @OA\Property(property="mileageTrackerId", type="string", example="1"),
 *     @OA\Property(property="vehicleNo", type="string", example="WPAC3434"),
 *     @OA\Property(property="chassisNo", type="string", example="7788-334433"),
 *     @OA\Property(property="currentMileage", type="interger", example="300")
 * )
 */
class UpdateVehicleRequest extends FormRequest
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
            'mileageTrackerId' => [
                'required', 
                'integer',
                Rule::exists('mileage_trackers', 'id'),
                Rule::unique('vehicles', 'mileage_tracker_id')->ignore($this->id)
            ],
            'vehicleNo' => [
                'required', 
                'max:20', 
                Rule::unique('vehicles', 'vehicle_no')->ignore($this->id)
            ],
            'chassisNo' => [
                'required', 
                'max:100', 
                Rule::unique('vehicles', 'chassis_no')->ignore($this->id)
            ],
            'currentMileage' => ['required', 'integer']
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        // Get validation errors as a flat array
        $errors = $validator->errors()->all();

        throw new HttpResponseException(response()->json(['errors' => $errors], 422));
    }
}