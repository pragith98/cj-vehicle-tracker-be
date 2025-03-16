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

use App\Http\Requests\MileageHistory\PaginatedMileageHistoryRequest;
use App\Http\Requests\MileageHistory\StoreMileageHistoryRequest;
use App\Models\MileageHistory;
use App\Repositories\Interfaces\MileageHistoryRepositoryInterface;
use App\Repositories\Interfaces\VehicleRepositoryInterface;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class MileageHistoryRepository implements MileageHistoryRepositoryInterface
{
    protected $mileageHistory;
    protected $vehicleRepository;

    public function __construct(
        MileageHistory $mileageHistory,
        VehicleRepositoryInterface $vehicleRepository
    ) {
        $this->mileageHistory = $mileageHistory;
        $this->vehicleRepository = $vehicleRepository;
    }

    public function getAll(): Collection
    {
        try {
            return $this->mileageHistory->all();
        } catch (ModelNotFoundException $e) {
            throw new Exception("Mileage history not found.", 404);
        }
    }

    public function getPaginated(PaginatedMileageHistoryRequest $request): array
    {
        $limit = $request->getLimit();
        $page = $request->getPage();

        try {
            $paginated = $this->mileageHistory->paginate($limit, ['*'], 'page', $page);
            return [
                'data' => $paginated->items(),
                'total' => $paginated->total()
            ];
        } catch (ModelNotFoundException $e) {
            throw new Exception("Mileage history not found.", 404);
        }
    }

    public function create(StoreMileageHistoryRequest $request): MileageHistory
    {
        try {
            $validatedData = $request->validated();

            return DB::transaction(function () use ($validatedData) {
                $data = [
                    'vehicle_id' => $validatedData['vehicleId'],
                    'mileage' => $validatedData['mileage']
                ];

                $mileageHistory = $this->mileageHistory->create($data);

                // Update vehicle mileage
                $this->vehicleRepository->updateMileage($validatedData['vehicleId'],
                                                        $validatedData['mileage']);
                return $mileageHistory;
            });
        } catch (Exception $e) {
            throw new Exception("Failed to create mileage history.", 500);
        }
    }

    public function delete(
        int $vehicleId,
        string $createdAt
    ): bool {
        try {
            $createdAtCarbon = Carbon::createFromFormat('Y-m-d H:i:s', $createdAt);

            // Use a range query to account for any microseconds
            $affectedRows = DB::table('mileage_histories')
                ->where('vehicle_id', $vehicleId)
                ->whereBetween('created_at', [
                    $createdAtCarbon->format('Y-m-d H:i:s'),
                    $createdAtCarbon->addSecond()->format('Y-m-d H:i:s')
                ])
                ->delete();

            if ($affectedRows > 0) {
                return true;
            } else {
                throw new Exception("Mileage history not found.", 404);
            }
        } catch (ModelNotFoundException $e) {
            throw new Exception("Mileage history not found.", 404);
        } catch (Exception $e) {
            throw new Exception("Failed to delete mileage history.", 500);
        }
    }
}