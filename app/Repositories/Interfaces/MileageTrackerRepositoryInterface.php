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

use App\Enums\MileageTrackerStatus;
use App\Http\Requests\MileageTracker\PaginatedMileageTrackerRequest;
use App\Http\Requests\MileageTracker\StoreMileageTrackerRequest;
use App\Http\Requests\MileageTracker\UpdateMileageTrackerRequest;
use App\Http\Resources\DeletabilityResource;
use App\Models\MileageTracker;
use Illuminate\Support\Collection;

interface MileageTrackerRepositoryInterface
{
    public function getAll(): Collection;

    public function getPaginated(PaginatedMileageTrackerRequest $request): array;

    public function getById(int $id): MileageTracker;

    public function create(StoreMileageTrackerRequest $request): MileageTracker;

    public function update(
        int $id,
        UpdateMileageTrackerRequest $request
    ): MileageTracker;

    public function delete(int $id): bool;

    public function isDeletable(int $id): DeletabilityResource;

    public function generateKey(int $id): MileageTracker;

    public function updateStatus(
        int $id,
        MileageTrackerStatus $status
    ): void;
}