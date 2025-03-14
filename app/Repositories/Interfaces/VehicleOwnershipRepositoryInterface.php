<?php

/*
 * @copyright (c) 2025 Pragith Lakshan Thilakarathna
 * All rights reserved. 
 * This code is proprietary to CJNextGenSys. 
 * Unauthorized use, reproduction, modification, distribution, or sale 
 * without the explicit written permission of CJNextGenSys is strictly prohibited.
 * For inquiries, please contact: [info@cjnextgensys.com]
*/

namespace App\Repositories\Interfaces;

use App\Http\Requests\VehicleOwnership\PaginatedVehicleOwnershipRequest;
use App\Http\Requests\VehicleOwnership\StoreVehicleOwnershipRequest;
use App\Http\Requests\VehicleOwnership\UpdateVehicleOwnershipRequest;
use App\Models\VehicleOwnership;
use Illuminate\Support\Collection;

interface VehicleOwnershipRepositoryInterface
{
    public function getAll(): Collection;

    public function getPaginated(PaginatedVehicleOwnershipRequest $request): array;

    public function getOne(
        int $vehicleId,
        int $ownerId,
        string $startDate 
    ): VehicleOwnership;

    public function create(StoreVehicleOwnershipRequest $request): VehicleOwnership;

    public function update(
        int $vehicleId,
        int $ownerId,
        string $startDate ,
        UpdateVehicleOwnershipRequest $request
    ): VehicleOwnership;

    public function delete(
        int $vehicleId,
        int $ownerId,
        string $startDate
    ): bool;
}