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
            return $this->vehicleOwner->all();
        } catch (ModelNotFoundException $e) {
            throw new Exception("Vehicle owners not found.", 404);
        }
    }

    public function getPaginated(PaginatedVehicleOwnerRequest $request): array
    {
        $limit = $request->getLimit();
        $page = $request->getPage();

        try {
            $paginated = $this->vehicleOwner->paginate($limit, ['*'], 'page', $page);
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
            return $this->vehicleOwner->findOrFail($id);
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

            return $this->vehicleOwner->create($data);
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
            return $vehicleOwner;
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
}