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

use App\Http\Requests\MileageHistory\PaginatedMileageHistoryRequest;
use App\Http\Requests\MileageHistory\StoreMileageHistoryRequest;
use App\Models\MileageHistory;
use Illuminate\Support\Collection;

interface MileageHistoryRepositoryInterface
{
    public function getAll(): Collection;

    public function getPaginated(PaginatedMileageHistoryRequest $request): array;

    public function create(StoreMileageHistoryRequest $request): MileageHistory;

    public function delete(
        int $vehicleId,
        string $createdAt
    ): bool;
}