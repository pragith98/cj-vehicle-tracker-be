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

use App\Http\Requests\VehicleOwner\UpdateVehicleOwnerRequest;
use App\Http\Requests\VehicleOwner\PaginatedVehicleOwnerRequest;
use App\Http\Requests\VehicleOwner\StoreVehicleOwnerRequest;
use App\Http\Resources\DeletabilityResource;
use App\Models\VehicleOwner;
use Illuminate\Support\Collection;

interface VehicleOwnerRepositoryInterface
{
    public function getAll(): Collection;

    public function getPaginated(PaginatedVehicleOwnerRequest $request): array;

    public function getById(int $id): VehicleOwner;

    public function create(StoreVehicleOwnerRequest $request): VehicleOwner;

    public function update(
        int $id,
        UpdateVehicleOwnerRequest $request
    ): VehicleOwner;

    public function isDeletable(int $id): DeletabilityResource;

    public function delete(int $id): bool;

    public function getVehicles(int $id): array;
}