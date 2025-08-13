<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="VehicleOwnerVehicleCollection",
 *     type="object",
 *     title="Vehicle Owner Vehicle Collection",
 *     @OA\Property(
 *         property="data",
 *         type="object",
 *         @OA\Property(
 *             property="currentOwnerships",
 *             type="array",
 *             @OA\Items(ref="#/components/schemas/VehicleOwnerVehicleResource")
 *         ),
 *         @OA\Property(
 *             property="pastOwnerships",
 *             type="array",
 *             @OA\Items(ref="#/components/schemas/VehicleOwnerVehicleResource")
 *         )
 *     )
 * )
 */
class VehicleOwnerVehicleCollection extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'data' => parent::toArray($request)
        ];
    }

    public function with(Request $request)
    {
        return [
            'success' => true
        ];
    }
}