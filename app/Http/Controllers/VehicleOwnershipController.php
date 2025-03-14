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
use App\Http\Requests\VehicleOwnership\PaginatedVehicleOwnershipRequest;
use App\Http\Requests\VehicleOwnership\StoreVehicleOwnershipRequest;
use App\Http\Requests\VehicleOwnership\UpdateVehicleOwnershipRequest;
use App\Http\Resources\VehicleOwnershipPaginatedCollection;
use App\Http\Resources\VehicleOwnershipResource;
use App\Repositories\Interfaces\VehicleOwnershipRepositoryInterface;
use Exception;

/** 
 * @OA\Server(
 *     url=L5_SWAGGER_CONST_HOST
 * )
 */
class VehicleOwnershipController extends Controller
{
    protected $repository;

    public function __construct(VehicleOwnershipRepositoryInterface $vehicleOwnershipRepository)
    {
        $this->repository = $vehicleOwnershipRepository;
    }

    /**
     * @OA\Get(
     *     path="/vehicle-ownerships",
     *     summary="Get vehicle ownerships",
     *     tags={"Vehicle Ownerships"},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/VehicleOwnershipResource")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Vehicle ownerships not found"
     *     )
     * )
     */
    public function index()
    {
        try {
            $vehicleOwnerships = $this->repository->getAll();
            return VehicleOwnershipResource::collection($vehicleOwnerships);
        } catch (Exception $e) { 
            return ApiResponse::error($e->getMessage(), 404);
        }
    }

    /**
     * @OA\Get(
     *     path="/vehicle-ownerships/get-paginated",
     *     summary="Get paginated vehicle ownerships",
     *     tags={"Vehicle Ownerships"},
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
     *         @OA\JsonContent(ref="#/components/schemas/VehicleOwnershipPaginatedCollection")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Vehicle ownership not found"
     *     )
     * )
     */
    public function getPaginated(PaginatedVehicleOwnershipRequest $request)
    {
        try {
            $vehicleOwnerships = $this->repository->getPaginated($request);
            return new VehicleOwnershipPaginatedCollection($vehicleOwnerships);
        } catch (Exception $e) { 
            return ApiResponse::error($e->getMessage(), 404);
        }
    }

    /**
     * @OA\Post(
     *     path="/vehicle-ownerships",
     *     summary="Create a new vehicle ownership",
     *     tags={"Vehicle Ownerships"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/StoreVehicleOwnershipRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Vehicle ownership created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/VehicleOwnershipResource")
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Invalid input"
     *     )
     * )
     */
    public function store(StoreVehicleOwnershipRequest $request)
    {
        try {
            $vehicleOwnership = $this->repository->create($request);
            return new VehicleOwnershipResource($vehicleOwnership);
        } catch (Exception $e) { 
            return ApiResponse::error($e->getMessage(), 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/vehicle-ownerships/{vehicleId}/{ownerId}/{startDate}",
     *     summary="Get vehicle ownership",
     *     tags={"Vehicle Ownerships"},
     *     @OA\Parameter(
     *         name="vehicleId",
     *         in="path",
     *         required=true,
     *         description="ID of the vehicle",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="ownerId",
     *         in="path",
     *         required=true,
     *         description="ID of the owner",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="startDate",
     *         in="path",
     *         required=true,
     *         description="Start date of ownership",
     *         @OA\Schema(type="string", format="date")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             ref="#/components/schemas/VehicleOwnershipResource"
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Vehicle ownership not found"
     *     )
     * )
     */
    public function show(
        string $vehicleId,
        string $ownerId,
        string $startDate 
    ) {
        $vehicleId = (int) $vehicleId;
        $ownerId = (int) $ownerId;
        try {
            $vehicleOwner = $this->repository->getOne($vehicleId, 
                                                      $ownerId, 
                                                      $startDate);
            return new VehicleOwnershipResource($vehicleOwner);
        } catch (Exception $e) {
            return ApiResponse::error($e->getMessage(), 404);
        }
    }

    /**
     * @OA\Put(
     *     path="/vehicle-ownerships/{vehicleId}/{ownerId}/{startDate}",
     *     summary="Update a vehicle ownership",
     *     tags={"Vehicle Ownerships"},
     *     @OA\Parameter(
     *         name="vehicleId",
     *         in="path",
     *         required=true,
     *         description="ID of the vehicle",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="ownerId",
     *         in="path",
     *         required=true,
     *         description="ID of the owner",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="startDate",
     *         in="path",
     *         required=true,
     *         description="Start date of ownership",
     *         @OA\Schema(type="string", format="date")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/UpdateVehicleOwnershipRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Vehicle owner updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/VehicleOwnershipResource")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Vehicle ownership not found"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid input"
     *     )
     * )
     */
    public function update(
        string $vehicleId,
        string $ownerId,
        string $startDate,
        UpdateVehicleOwnershipRequest $request
    ) {
        $vehicleId = (int) $vehicleId;
        $ownerId = (int) $ownerId;
        try {
            $vehicleOwnership = $this->repository->update($vehicleId, 
                                                          $ownerId, 
                                                          $startDate, 
                                                          $request);
            return new VehicleOwnershipResource($vehicleOwnership);
        } catch (Exception $e) {
            return ApiResponse::error($e->getMessage(), 404);
        }
    }

    /**
     * @OA\Delete(
     *     path="/vehicle-ownerships/{vehicleId}/{ownerId}/{startDate}",
     *     summary="Delete a vehicle ownership",
     *     tags={"Vehicle Ownerships"},
     *     @OA\Parameter(
     *         name="vehicleId",
     *         in="path",
     *         required=true,
     *         description="ID of the vehicle",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="ownerId",
     *         in="path",
     *         required=true,
     *         description="ID of the owner",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="startDate",
     *         in="path",
     *         required=true,
     *         description="Start date of ownership",
     *         @OA\Schema(type="string", format="date")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Vehicle ownership deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Vehicle ownership not found"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid input"
     *     )
     * )
     */
    public function destroy(
        string $vehicleId,
        string $ownerId,
        string $startDate 
    ) {
        $vehicleId = (int) $vehicleId;
        $ownerId = (int) $ownerId;
        try {
            $this->repository->delete($vehicleId, 
                                      $ownerId, 
                                      $startDate);
            return response()->json(['success' => true], 200);
        } catch (Exception $e) {
            return ApiResponse::error($e->getMessage(), 404);
        }
    }
}