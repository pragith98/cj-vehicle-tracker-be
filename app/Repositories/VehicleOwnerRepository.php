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

use App\Http\Requests\VehicleOwner\UpdateVehicleOwnerRequest;
use App\Http\Requests\VehicleOwner\PaginatedVehicleOwnerRequest;
use App\Http\Requests\VehicleOwner\StoreVehicleOwnerRequest;
use App\Http\Resources\DeletabilityResource;
use App\Models\VehicleOwner;
use App\Repositories\Interfaces\VehicleOwnerRepositoryInterface;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;

class VehicleOwnerRepository implements VehicleOwnerRepositoryInterface
{
    protected $vehicleOwner;

    public function __construct(VehicleOwner $vehicleOwner)
    {
        $this->vehicleOwner = $vehicleOwner;
    }

    public function getAll(): Collection
    {
        try {
            return $this->vehicleOwner->with('currentOwnerships')->get();
        } catch (ModelNotFoundException $e) {
            throw new Exception("Vehicle owners not found.", 404);
        }
    }

    public function getPaginated(PaginatedVehicleOwnerRequest $request): array
    {
        $validatedRequest = $request->validated();
        $name = $validatedRequest['name'] ?? null;
        $telephoneNo = $validatedRequest['telephoneNo'] ?? null;
        $NIC = $validatedRequest['NIC'] ?? null;
        $limit = $request->getLimit();
        $page = $request->getPage();

        try {
            $query = $this->vehicleOwner->query();

            if ($name) {
                $query->where('name', 'like', '%' . $name . '%');
            }

            if ($telephoneNo) {
                $query->where('telephone_no', 'like', '%' . $telephoneNo . '%');
            }

            if ($NIC) {
                $query->where('NIC', 'like', '%' . $NIC . '%');
            }

            $paginated = $query->with('currentOwnerships')
                ->paginate($limit, ['*'], 'page', $page);
            return [
                'data' => $paginated->items(),
                'total' => $paginated->total()
            ];
        } catch (ModelNotFoundException $e) {
            throw new Exception("Vehicle owners not found.", 404);
        }
    }

    public function getById(int $id): VehicleOwner
    {
        try {
            return $this->vehicleOwner->with('currentOwnerships')->findOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new Exception("Vehicle owner with ID {$id} not found.", 404);
        }
    }

    public function create(StoreVehicleOwnerRequest $request): VehicleOwner
    {
        try {
            $validatedData = $request->validated();

            $data = [
                'NIC' => $validatedData['NIC'],
                'telephone_no' => $validatedData['telephoneNo'],
                'salutation' => $validatedData['salutation'],
                'name' => $validatedData['name']
            ];

            $vehicleOwner = $this->vehicleOwner->create($data);
            return $this->getById($vehicleOwner->id);
        } catch (Exception $e) {
            throw new Exception("Failed to create vehicle owner.", 500);
        }
    }

    public function update(
        int $id,
        UpdateVehicleOwnerRequest $request
    ): VehicleOwner {
        try {
            $vehicleOwner = $this->vehicleOwner->findOrFail($id);

            $validatedData = $request->validated();

            $data = [
                'NIC' => $validatedData['NIC'],
                'telephone_no' => $validatedData['telephoneNo'],
                'salutation' => $validatedData['salutation'],
                'name' => $validatedData['name']
            ];

            $vehicleOwner->update($data);
            return $this->getById($id);
        } catch (ModelNotFoundException $e) {
            throw new Exception("Vehicle owner with ID {$id} not found.", 404);
        } catch (Exception $e) {
            throw new Exception("Failed to update vehicle owner.", 500);
        }
    }

    public function delete(int $id): bool
    {
        try {
            $vehicleOwner = $this->vehicleOwner->findOrFail($id);
            $vehicleOwner->delete();

            return true;
        } catch (ModelNotFoundException $e) {
            throw new Exception("Vehicle owner with ID {$id} not found.", 404);
        } catch (Exception $e) {
            throw new Exception("Failed to delete vehicle owner.", 500);
        }
    }

    public function isDeletable(int $id): DeletabilityResource
    {
        $isDeletable = true;
        $messages = [];
        try {
            $ownerships = $this->vehicleOwner->with('ownerships')->findOrFail($id);
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
            throw new Exception("Vehicle owner with ID {$id} not found.", 404);
        }
    }
}