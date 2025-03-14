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
use App\Http\Requests\Vehicle\PaginatedVehicleRequest;
use App\Http\Requests\Vehicle\StoreVehicleRequest;
use App\Http\Requests\Vehicle\UpdateVehicleRequest;
use App\Http\Resources\VehiclePaginatedCollection;
use App\Http\Resources\VehicleResource;
use App\Repositories\Interfaces\VehicleRepositoryInterface;
use Exception;

/** 
 * @OA\Server(
 *     url=L5_SWAGGER_CONST_HOST
 * )
 */
class VehicleController extends Controller
{
    protected $repository;

    public function __construct(VehicleRepositoryInterface $vehicleRepository)
    {
        $this->repository = $vehicleRepository;
    }

    /**
     * @OA\Get(
     *     path="/vehicles",
     *     summary="Get vehicles",
     *     tags={"Vehicles"},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/VehicleResource")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Vehicles not found"
     *     )
     * )
     */
    public function index()
    {
        try {
            $vehicles = $this->repository->getAll();
            return VehicleResource::collection($vehicles);
        } catch (Exception $e) { 
            return ApiResponse::error($e->getMessage(), 404);
        }
    }

    /**
     * @OA\Get(
     *     path="/vehicles/get-paginated",
     *     summary="Get paginated vehicles",
     *     tags={"Vehicles"},
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
     *         @OA\JsonContent(ref="#/components/schemas/VehiclePaginatedCollection")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Vehicles not found"
     *     )
     * )
     */
    public function getPaginated(PaginatedVehicleRequest $request)
    {
        try {
            $vehicles = $this->repository->getPaginated($request);
            return new VehiclePaginatedCollection($vehicles);
        } catch (Exception $e) { 
            return ApiResponse::error($e->getMessage(), 404);
        }
    }

    /**
     * @OA\Post(
     *     path="/vehicles",
     *     summary="Create a new vehicle",
     *     tags={"Vehicles"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/StoreVehicleRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Vehicle created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/VehicleResource")
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Invalid input"
     *     )
     * )
     */
    public function store(StoreVehicleRequest $request)
    {
        try {
            $vehicle = $this->repository->create($request);
            return new VehicleResource($vehicle);
        } catch (Exception $e) { 
            return ApiResponse::error($e->getMessage(), 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/vehicles/{id}",
     *     summary="Get vehicle",
     *     tags={"Vehicles"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the vehicle to retrieve",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             ref="#/components/schemas/VehicleResource"
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Vehicle not found"
     *     )
     * )
     */
    public function show(string $id)
    {
        $id = (int) $id;
        try {
            $vehicle = $this->repository->getById($id);
            return new VehicleResource($vehicle);
        } catch (Exception $e) {
            return ApiResponse::error($e->getMessage(), 404);
        }
    }

    /**
     * @OA\Put(
     *     path="/vehicles/{id}",
     *     summary="Update a vehicle",
     *     tags={"Vehicles"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the vehicle to update",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/UpdateVehicleRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Vehicle updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/VehicleResource")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Vehicle not found"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid input"
     *     )
     * )
     */
    public function update(
        UpdateVehicleRequest $request, 
        string $id
    ) {
        $id = (int) $id;
        try {
            $vehicle = $this->repository->update($id, 
                                                 $request);
            return new VehicleResource($vehicle);
        } catch (Exception $e) {
            return ApiResponse::error($e->getMessage(), 404);
        }
    }

    /**
     * @OA\Delete(
     *     path="/vehicles/{id}",
     *     summary="Delete a vehicle",
     *     tags={"Vehicles"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the vehicle to delete",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Vehicle deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Vehicle not found"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid input"
     *     )
     * )
     */
    public function destroy(string $id)
    {
        $id = (int) $id;
        try {
            $this->repository->delete($id);
            return response()->json(['success' => true], 200);
        } catch (Exception $e) {
            return ApiResponse::error($e->getMessage(), 404);
        }
    }
}