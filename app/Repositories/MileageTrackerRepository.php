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

use App\Enums\MileageTrackerStatus;
use App\Http\Requests\MileageTracker\PaginatedMileageTrackerRequest;
use App\Http\Requests\MileageTracker\StoreMileageTrackerRequest;
use App\Http\Requests\MileageTracker\UpdateMileageTrackerRequest;
use App\Http\Resources\DeletabilityResource;
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
        $validatedRequest = $request->validated();
        $serialNo = $validatedRequest['serialNo'] ?? null;
        $status = $validatedRequest['status'] ?? null;
        $limit = $request->getLimit();
        $page = $request->getPage();

        try {
            $query = $this->mileageTracker->query();

            if ($serialNo) {
                $query->where('serial_no', 'like', '%' . $serialNo . '%');
            }

            if ($status) {
                $query->where('status', 'like', '%' . $status . '%');
            }

            $paginated = $query->paginate($limit, ['*'], 'page', $page);
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

            $mileageTracker = $this->mileageTracker->create($data);
            return $this->getById($mileageTracker->id);
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

    public function isDeletable(int $id): DeletabilityResource
    {
        $isDeletable = true;
        $messages = [];
        try {
            $vehicle = $this->mileageTracker->with('currentVehicle')->findOrFail($id);
            if($vehicle->currentVehicle) {
                $messages[] = "There is a vehicle assigned";
                $isDeletable = false;
            }

            return new DeletabilityResource(
                $isDeletable,
                $messages
            );
        } catch (ModelNotFoundException $e) {
            throw new Exception("Mileage tracker with ID {$id} not found.", 404);
        }
    }

    public function generateKey(int $id): MileageTracker {
        try {
            $mileageTracker = $this->mileageTracker->findOrFail($id);

             // Generate a new key pair
             $config = [
                "digest_alg" => "sha512",
                "private_key_bits" => 2048,
                "private_key_type" => OPENSSL_KEYTYPE_RSA,
            ];

            // Create the key pair
            $keyPair = openssl_pkey_new($config);
            if (!$keyPair) {
                throw new Exception("Failed to create key pair.", 500);
            }

            // Extract the private key
            $privateKey = '';
            if (!openssl_pkey_export($keyPair, $privateKey)) {
                throw new Exception("Failed to export private key.", 500);
            }

            // Extract the public key
            $publicKeyDetails = openssl_pkey_get_details($keyPair);
            if (!$publicKeyDetails) {
                throw new Exception("Failed to get public key details.", 500);
            }
            $publicKey = $publicKeyDetails['key'];

            $mileageTracker->public_key = $publicKey;

            $mileageTracker->save();

            // Attach the private key to the model (not saving it to the database)
            $mileageTracker->private_key = $privateKey;

            return $mileageTracker;
        } catch (ModelNotFoundException $e) {
            throw new Exception("Mileage tracker with ID {$id} not found.", 404);
        } catch (Exception $e) {
            throw new Exception("Failed to update mileage tracker key.", 500);
        }
    }

    public function updateStatus(
        int $id,
        MileageTrackerStatus $status
    ): void {
        try {
            $mileageTracker = $this->mileageTracker->findOrFail($id);
            $mileageTracker->status = $status;

            $mileageTracker->save();
        } catch (Exception $e) {
            throw $e;
        }
    }
}