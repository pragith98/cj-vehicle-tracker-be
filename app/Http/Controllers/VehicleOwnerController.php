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
use App\Http\Requests\VehicleOwner\UpdateVehicleOwnerRequest;
use App\Http\Requests\VehicleOwner\PaginatedVehicleOwnerRequest;
use App\Http\Requests\VehicleOwner\StoreVehicleOwnerRequest;
use App\Http\Resources\VehicleOwnerPaginatedCollection;
use App\Http\Resources\VehicleOwnerResource;
use App\Repositories\Interfaces\VehicleOwnerRepositoryInterface;
use Exception;

/** 
 * @OA\Server(
 *     url=L5_SWAGGER_CONST_HOST
 * )
 */
class VehicleOwnerController extends Controller
{
    protected $repository;

    public function __construct(VehicleOwnerRepositoryInterface $vehicleOwnerRepository)
    {
        $this->repository = $vehicleOwnerRepository;
    }

    /**
     * @OA\Get(
     *     path="/vehicle-owners",
     *     summary="Get vehicle owners",
     *     tags={"Vehicle Owners"},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/VehicleOwnerResource")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Vehicle owners not found"
     *     )
     * )
     */
    public function index()
    {
        try {
            $vehicleOwners = $this->repository->getAll();
            return VehicleOwnerResource::collection($vehicleOwners);
        } catch (Exception $e) { 
            return ApiResponse::error($e->getMessage(), 404);
        }
    }

    /**
     * @OA\Get(
     *     path="/vehicle-owners/get-paginated",
     *     summary="Get paginated vehicle owners",
     *     tags={"Vehicle Owners"},
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
     *         @OA\JsonContent(ref="#/components/schemas/VehicleOwnerPaginatedCollection")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Vehicle owner not found"
     *     )
     * )
     */
    public function getPaginated(PaginatedVehicleOwnerRequest $request)
    {
        try {
            $vehicleOwners = $this->repository->getPaginated($request);
            return new VehicleOwnerPaginatedCollection($vehicleOwners);
        } catch (Exception $e) { 
            return ApiResponse::error($e->getMessage(), 404);
        }
    }

    /**
     * @OA\Post(
     *     path="/vehicle-owners",
     *     summary="Create a new vehicle owner",
     *     tags={"Vehicle Owners"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/StoreVehicleOwnerRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Vehicle owner created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/VehicleOwnerResource")
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Invalid input"
     *     )
     * )
     */
    public function store(StoreVehicleOwnerRequest $request)
    {
        try {
            $vehicleOwner = $this->repository->create($request);
            return new VehicleOwnerResource($vehicleOwner);
        } catch (Exception $e) { 
            return ApiResponse::error($e->getMessage(), 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/vehicle-owners/{id}",
     *     summary="Get vehicle owner",
     *     tags={"Vehicle Owners"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the vehicle owner to retrieve",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             ref="#/components/schemas/VehicleOwnerResource"
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Vehicle owner not found"
     *     )
     * )
     */
    public function show(string $id)
    {
        $id = (int) $id;
        try {
            $vehicleOwner = $this->repository->getById($id);
            return new VehicleOwnerResource($vehicleOwner);
        } catch (Exception $e) {
            return ApiResponse::error($e->getMessage(), 404);
        }
    }

    /**
     * @OA\Put(
     *     path="/vehicle-owners/{id}",
     *     summary="Update a vehicle owner",
     *     tags={"Vehicle Owners"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the vehicle owner to update",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/UpdateVehicleOwnerRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Vehicle owner updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/VehicleOwnerResource")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Vehicle owner not found"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid input"
     *     )
     * )
     */
    public function update(
        UpdateVehicleOwnerRequest $request, 
        string $id
    ) {
        $id = (int) $id;
        try {
            $vehicleOwner = $this->repository->update($id, 
                                                      $request);
            return new VehicleOwnerResource($vehicleOwner);
        } catch (Exception $e) {
            return ApiResponse::error($e->getMessage(), 404);
        }
    }

    /**
     * @OA\Delete(
     *     path="/vehicle-owners/{id}",
     *     summary="Delete a vehicle owner",
     *     tags={"Vehicle Owners"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the vehicle owner to delete",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Vehicle owner deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Vehicle owner not found"
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

    /**
     * @OA\Get(
     *     path="/vehicle-owners/{id}/is-deletable",
     *     summary="Check vehicle owner delability",
     *     tags={"Vehicle Owners"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the vehicle owner",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             ref="#/components/schemas/DeletabilityResource"
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Vehicle owner not found"
     *     )
     * )
     */
    public function isDeletable(string $id)
    {
        $id = (int) $id;
        try {
            return $this->repository->isDeletable($id);
        } catch (Exception $e) {
            return ApiResponse::error($e->getMessage(), 404);
        }
    }
}