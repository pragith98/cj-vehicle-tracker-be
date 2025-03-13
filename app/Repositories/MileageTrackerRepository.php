<?php

/*
 * @copyright (c) 2025 Pragith Lakshan Thilakarathna
 * All rights reserved. 
 * This code is proprietary to CJNextGenSys. 
 * Unauthorized use, reproduction, modification, distribution, or sale 
 * without the explicit written permission of CJNextGenSys is strictly prohibited.
 * For inquiries, please contact: [info@cjnextgensys.com]
*/

namespace App\Repositories;

use App\Http\Requests\MileageTracker\PaginatedMileageTrackerRequest;
use App\Http\Requests\MileageTracker\StoreMileageTrackerRequest;
use App\Http\Requests\MileageTracker\UpdateMileageTrackerRequest;
use App\Models\MileageTracker;
use App\Repositories\Interfaces\MileageTrackerRepositoryInterface;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;

class MileageTrackerRepository implements MileageTrackerRepositoryInterface
{
    protected $mileageTracker;

    public function __construct(MileageTracker $mileageTracker)
    {
        $this->mileageTracker = $mileageTracker;
    }

    public function getAll(): Collection
    {
        try {
            return $this->mileageTracker->all();
        } catch (ModelNotFoundException $e) {
            throw new Exception("Mileage trackers not found.", 404);
        }
    }

    public function getPaginated(PaginatedMileageTrackerRequest $request): array
    {
        $limit = $request->getLimit();
        $page = $request->getPage();

        try {
            $paginated = $this->mileageTracker->paginate($limit, ['*'], 'page', $page);
            return [
                'data' => $paginated->items(),
                'total' => $paginated->total()
            ];
        } catch (ModelNotFoundException $e) {
            throw new Exception("Mileage trackers not found.", 404);
        }
    }

    public function getById(int $id): MileageTracker
    {
        try {
            return $this->mileageTracker->findOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new Exception("Mileage tracker with ID {$id} not found.", 404);
        }
    }

    public function create(StoreMileageTrackerRequest $request): MileageTracker
    {
        try {
            $validatedData = $request->validated();

            $data = [
                'serial_no' => $validatedData['serialNo']
            ];

            return $this->mileageTracker->create($data);
        } catch (Exception $e) {
            throw new Exception("Failed to create mileage tracker.", 500);
        }
    }

    public function update(
        int $id,
        UpdateMileageTrackerRequest $request
    ): MileageTracker {
        try {
            $mileageTracker = $this->mileageTracker->findOrFail($id);

            $validatedData = $request->validated();

            $data = [
                'serial_no' => $validatedData['serialNo']
            ];

            $mileageTracker->update($data);
            return $mileageTracker;
        } catch (ModelNotFoundException $e) {
            throw new Exception("Mileage tracker with ID {$id} not found.", 404);
        } catch (Exception $e) {
            throw new Exception("Failed to update mileage tracker.", 500);
        }
    }

    public function delete(int $id): bool
    {
        try {
            $mileageTracker = $this->mileageTracker->findOrFail($id);
            $mileageTracker->delete();

            return true;
        } catch (ModelNotFoundException $e) {
            throw new Exception("Mileage tracker with ID {$id} not found.", 404);
        } catch (Exception $e) {
            throw new Exception("Failed to delete mileage tracker.", 500);
        }
    }
}