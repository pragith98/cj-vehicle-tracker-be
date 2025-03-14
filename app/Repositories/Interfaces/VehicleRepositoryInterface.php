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

use App\Http\Requests\Vehicle\PaginatedVehicleRequest;
use App\Http\Requests\Vehicle\StoreVehicleRequest;
use App\Http\Requests\Vehicle\UpdateVehicleRequest;
use App\Models\Vehicle;
use Illuminate\Support\Collection;

interface VehicleRepositoryInterface
{
    public function getAll(): Collection;

    public function getPaginated(PaginatedVehicleRequest $request): array;

    public function getById(int $id): Vehicle;

    public function create(StoreVehicleRequest $request): Vehicle;

    public function update(
        int $id,
        UpdateVehicleRequest $request
    ): Vehicle;

    public function delete(int $id): bool;
}