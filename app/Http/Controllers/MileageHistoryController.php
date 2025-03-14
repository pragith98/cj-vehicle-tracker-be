<?php

/*
 * @copyright (c) 2025 Pragith Lakshan Thilakarathna
 * All rights reserved. 
 * This code is proprietary to CJNextGenSys. 
 * Unauthorized use, reproduction, modification, distribution, or sale 
 * without the explicit written permission of CJNextGenSys is strictly prohibited.
 * For inquiries, please contact: [info@cjnextgensys.com]
*/

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Requests\MileageHistory\PaginatedMileageHistoryRequest;
use App\Http\Requests\MileageHistory\StoreMileageHistoryRequest;
use App\Http\Resources\MileageHistoryPaginatedCollection;
use App\Http\Resources\MileageHistoryResource;
use App\Repositories\Interfaces\MileageHistoryRepositoryInterface;
use Exception;

/** 
 * @OA\Server(
 *     url=L5_SWAGGER_CONST_HOST
 * )
 */
class MileageHistoryController extends Controller
{
    protected $repository;

    public function __construct(MileageHistoryRepositoryInterface $mileageHistoryRepositoryInterface)
    {
        $this->repository = $mileageHistoryRepositoryInterface;
    }

    /**
     * @OA\Get(
     *     path="/mileage-histories",
     *     summary="Get mileage histories",
     *     tags={"Mileage Histories"},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/MileageHistoryResource")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Mileage history not found"
     *     )
     * )
     */
    public function index()
    {
        try {
            $mileageHistories = $this->repository->getAll();
            return MileageHistoryResource::collection($mileageHistories);
        } catch (Exception $e) { 
            return ApiResponse::error($e->getMessage(), 404);
        }
    }

    /**
     * @OA\Get(
     *     path="/mileage-histories/get-paginated",
     *     summary="Get paginated mileage histories",
     *     tags={"Mileage Histories"},
     *     @OA\Parameter(
     *         name="limit",
     *         in="query",
     *         required=true,
     *         @OA\Schema(type="integer", format="int64", example=20)
     *     ),
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         required=true,
     *         @OA\Schema(type="integer", format="int64", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/MileageHistoryPaginatedCollection")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Mileage history not found"
     *     )
     * )
     */
    public function getPaginated(PaginatedMileageHistoryRequest $request)
    {
        try {
            $mileageHistories = $this->repository->getPaginated($request);
            return new MileageHistoryPaginatedCollection($mileageHistories);
        } catch (Exception $e) { 
            return ApiResponse::error($e->getMessage(), 404);
        }
    }

    /**
     * @OA\Post(
     *     path="/mileage-histories",
     *     summary="Create a new mileage history",
     *     tags={"Mileage Histories"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/StoreMileageHistoryRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Mileage history created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/MileageHistoryResource")
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Invalid input"
     *     )
     * )
     */
    public function store(StoreMileageHistoryRequest $request)
    {
        try {
            $mileageHistory = $this->repository->create($request);
            return new MileageHistoryResource($mileageHistory);
        } catch (Exception $e) { 
            return ApiResponse::error($e->getMessage(), 500);
        }
    }

    /**
     * @OA\Delete(
     *     path="/mileage-histories/{vehicleId}/{createdAt}",
     *     summary="Delete a mileage history",
     *     tags={"Mileage Histories"},
     *     @OA\Parameter(
     *         name="vehicleId",
     *         in="path",
     *         required=true,
     *         description="ID of the vehicle",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="createdAt",
     *         in="path",
     *         required=true,
     *         description="Created date time of mileage history",
     *         @OA\Schema(type="string", format="date")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Mileage history deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Mileage history not found"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid input"
     *     )
     * )
     */
    public function destroy(
        string $vehicleId,
        string $createdAt 
    ) {
        $vehicleId = (int) $vehicleId;
        try {
            $this->repository->delete($vehicleId, 
                                      $createdAt);
            return response()->json(['success' => true], 200);
        } catch (Exception $e) {
            return ApiResponse::error($e->getMessage(), 404);
        }
    }
}