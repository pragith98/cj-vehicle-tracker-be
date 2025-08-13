<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="VehicleOwnerVehicleResource",
 *     type="object",
 *     title="Vehicle Owner Vehicle Resource",
 *     @OA\Property(property="vehicleId", type="integer", example="1"),
 *     @OA\Property(property="vehicleOwnerId", type="integer", example="3"),
 *     @OA\Property(property="startDate", type="string", example="2024-12-01"),
 *     @OA\Property(property="endDate", type="string", example="2024-12-01"),
 *     @OA\Property(
 *          property="vehicle", 
 *          ref="#/components/schemas/VehicleResource"
 *     )
 * )
 */
class VehicleOwnerVehicleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'vehicleId' => $this->vehicle_id,
            'vehicleOwnerId' => $this->vehicle_owner_id,
            'startDate' => $this->start_date,
            'endDate' => $this->end_date,
            'vehicle' => new VehicleResource($this->vehicle)
        ];
    }
}