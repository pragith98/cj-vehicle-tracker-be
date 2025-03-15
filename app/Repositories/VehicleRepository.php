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

use App\Http\Requests\Vehicle\PaginatedVehicleRequest;
use App\Http\Requests\Vehicle\StoreVehicleRequest;
use App\Http\Requests\Vehicle\UpdateVehicleRequest;
use App\Http\Resources\DeletabilityResource;
use App\Models\Vehicle;
use App\Repositories\Interfaces\VehicleRepositoryInterface;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;

class VehicleRepository implements VehicleRepositoryInterface
{
    protected $vehicle;

    public function __construct(Vehicle $vehicle)
    {
        $this->vehicle = $vehicle;
    }

    public function getAll(): Collection
    {
        try {
            return $this->vehicle->all();
        } catch (ModelNotFoundException $e) {
            throw new Exception("Vehicles not found.", 404);
        }
    }

    public function getPaginated(PaginatedVehicleRequest $request): array
    {
        $limit = $request->getLimit();
        $page = $request->getPage();

        try {
            $paginated = $this->vehicle->paginate($limit, ['*'], 'page', $page);
            return [
                'data' => $paginated->items(),
                'total' => $paginated->total()
            ];
        } catch (ModelNotFoundException $e) {
            throw new Exception("Vehicles not found.", 404);
        }
    }

    public function getById(int $id): Vehicle
    {
        try {
            return $this->vehicle->with('currentOwnership')->findOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new Exception("Vehicle with ID {$id} not found.", 404);
        }
    }

    public function create(StoreVehicleRequest $request): Vehicle
    {
        try {
            $validatedData = $request->validated();

            $data = [
                'mileage_tracker_id' => $validatedData['mileageTrackerId'],
                'vehicle_no' => $validatedData['vehicleNo'],
                'chassis_no' => $validatedData['chassisNo'],
                'current_mileage' => $validatedData['currentMileage']
            ];

            return $this->vehicle->create($data);
        } catch (Exception $e) {
            throw new Exception("Failed to create vehicle.", 500);
        }
    }

    public function update(
        int $id,
        UpdateVehicleRequest $request
    ): Vehicle {
        try {
            $vehicle = $this->vehicle->findOrFail($id);

            $validatedData = $request->validated();

            $data = [
                'mileage_tracker_id' => $validatedData['mileageTrackerId'],
                'vehicle_no' => $validatedData['vehicleNo'],
                'chassis_no' => $validatedData['chassisNo'],
                'current_mileage' => $validatedData['currentMileage']
            ];

            $vehicle->update($data);
            return $vehicle;
        } catch (ModelNotFoundException $e) {
            throw new Exception("Vehicle with ID {$id} not found.", 404);
        } catch (Exception $e) {
            throw new Exception("Failed to update vehicle.", 500);
        }
    }

    public function delete(int $id): bool
    {
        try {
            $vehicle = $this->vehicle->findOrFail($id);
            $vehicle->delete();

            return true;
        } catch (ModelNotFoundException $e) {
            throw new Exception("Vehicle with ID {$id} not found.", 404);
        } catch (Exception $e) {
            throw new Exception("Failed to delete vehicle.", 500);
        }
    }

    public function isDeletable(int $id): DeletabilityResource
    {
        $isDeletable = true;
        $messages = [];
        try {
            $ownerships = $this->vehicle->with('ownerships')->findOrFail($id);
            $ownershipCounts = $ownerships->ownerships->count();

            if($ownershipCounts > 0) {
                $messages[] = "There is/are {$ownershipCounts} current/previous ownership assigned";
                $isDeletable = false;
            }

            return new DeletabilityResource(
                $isDeletable,
                $messages
            );
        } catch (ModelNotFoundException $e) {
            throw new Exception("Vehicle with ID {$id} not found.", 404);
        }
    }

    public function updateMileage(
        int $id,
        int $mileage
    ): void {
        try {
            $vehicle = $this->vehicle->find($id);
            if (!$vehicle) {
                throw new Exception("Vehicle not found.", 404);
            }

            $newMileage = $vehicle->current_mileage + $mileage;

            $vehicle->current_mileage = $newMileage;
            $vehicle->save();
        } catch (Exception $e) {
            throw $e;
        }
    }
}