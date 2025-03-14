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

use App\Http\Requests\VehicleOwnership\PaginatedVehicleOwnershipRequest;
use App\Http\Requests\VehicleOwnership\StoreVehicleOwnershipRequest;
use App\Http\Requests\VehicleOwnership\UpdateVehicleOwnershipRequest;
use App\Models\VehicleOwnership;
use App\Repositories\Interfaces\VehicleOwnershipRepositoryInterface;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class VehicleOwnershipRepository implements VehicleOwnershipRepositoryInterface
{
    protected $vehicleOwnership;

    public function __construct(VehicleOwnership $vehicleOwnership)
    {
        $this->vehicleOwnership = $vehicleOwnership;
    }

    public function getAll(): Collection
    {
        try {
            return $this->vehicleOwnership->all();
        } catch (ModelNotFoundException $e) {
            throw new Exception("Vehicle ownerships not found.", 404);
        }
    }

    public function getPaginated(PaginatedVehicleOwnershipRequest $request): array
    {
        $limit = $request->getLimit();
        $page = $request->getPage();

        try {
            $paginated = $this->vehicleOwnership->paginate($limit, ['*'], 'page', $page);
            return [
                'data' => $paginated->items(),
                'total' => $paginated->total()
            ];
        } catch (ModelNotFoundException $e) {
            throw new Exception("Vehicle ownerships not found.", 404);
        }
    }

    public function getOne(
        int $vehicleId,
        int $ownerId,
        string $startDate
    ): VehicleOwnership {
        try {
            return $this->vehicleOwnership->where([
                'vehicle_id' => $vehicleId,
                'vehicle_owner_id' => $ownerId,
                'start_date' => $startDate
            ])->firstOrFail();
        } catch (ModelNotFoundException $e) {
            throw new Exception("Vehicle ownership not found.", 404);
        }
    }

    public function create(StoreVehicleOwnershipRequest $request): VehicleOwnership
    {
        try {
            $validatedData = $request->validated();

            $data = [
                'vehicle_id' => $validatedData['vehicleId'],
                'vehicle_owner_id' => $validatedData['vehicleOwnerId'],
                'start_date' => $validatedData['startDate']
            ];

            return $this->vehicleOwnership->create($data);
        } catch (Exception $e) {
            throw new Exception("Failed to create vehicle ownership.", 500);
        }
    }

    public function update(
        int $vehicleId,
        int $ownerId,
        string $startDate,
        UpdateVehicleOwnershipRequest $request
    ): VehicleOwnership {
        try {
            $vehicleOwnership = $this->vehicleOwnership->where([
                'vehicle_id' => $vehicleId,
                'vehicle_owner_id' => $ownerId,
                'start_date' => $startDate
            ])->firstOrFail();

            $validatedData = $request->validated();

            $data = [
                'vehicle_id' => $validatedData['vehicleId'],
                'vehicle_owner_id' => $validatedData['vehicleOwnerId'],
                'start_date' => $validatedData['startDate'],
                'end_date' => $validatedData['endDate']
            ];

            $vehicleOwnership->update($data);
            return $vehicleOwnership;
        } catch (ModelNotFoundException $e) {
            throw new Exception("Vehicle ownership not found.", 404);
        } catch (Exception $e) {
            throw new Exception("Failed to update vehicle ownership.", 500);
        }
    }

    public function delete(
        int $vehicleId,
        int $ownerId,
        string $startDate
    ): bool {
        try {
            $affectedRows = DB::table('vehicle_ownerships')
                ->where('vehicle_id', $vehicleId)
                ->where('vehicle_owner_id', $ownerId)
                ->where('start_date', $startDate)
                ->delete();

            if ($affectedRows > 0) {
                return true;
            } else {
                throw new Exception("Vehicle ownership not found.", 404);
            }
        } catch (ModelNotFoundException $e) {
            throw new Exception("Vehicle ownership not found.", 404);
        } catch (Exception $e) {
            throw new Exception("Failed to delete vehicle ownership.", 500);
        }
    }
}