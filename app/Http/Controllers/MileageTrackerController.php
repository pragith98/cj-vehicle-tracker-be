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
use App\Http\Requests\MileageTracker\PaginatedMileageTrackerRequest;
use App\Http\Requests\MileageTracker\StoreMileageTrackerRequest;
use App\Http\Requests\MileageTracker\UpdateMileageTrackerRequest;
use App\Http\Resources\MileageTrackerPaginatedCollection;
use App\Http\Resources\MileageTrackerResource;
use App\Repositories\Interfaces\MileageTrackerRepositoryInterface;
use Exception;

/** 
 * @OA\Server(
 *     url=L5_SWAGGER_CONST_HOST
 * )
 */
class MileageTrackerController extends Controller
{
    protected $repository;

    public function __construct(MileageTrackerRepositoryInterface $mileageTrackerRepository)
    {
        $this->repository = $mileageTrackerRepository;
    }

    /**
     * @OA\Get(
     *     path="/mileage-trackers",
     *     summary="Get mileage trackers",
     *     tags={"Mileage Trackers"},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/MileageTrackerResource")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Mileage trackers not found"
     *     )
     * )
     */
    public function index()
    {
        try {
            $mileageTrackers = $this->repository->getAll();
            return MileageTrackerResource::collection($mileageTrackers);
        } catch (Exception $e) { 
            return ApiResponse::error($e->getMessage(), 404);
        }
    }

    /**
     * @OA\Get(
     *     path="/mileage-trackers/get-paginated",
     *     summary="Get paginated mileage trackers",
     *     tags={"Mileage Trackers"},
     *     @OA\Parameter(
     *         name="limit",
     *         in="query",
     *         required=true,
     *         @OA\Schema(type="integer", format="int64", example=20)
     *     ),
     *     @OA\Parameter(
     *         name="serial-no",
     *         in="query",
     *         required=false,
     *         @OA\Schema(type="string", example="ss4er-sfsdf")
     *     ),
     *     @OA\Parameter(
     *         name="status",
     *         in="query",
     *         required=false,
     *         @OA\Schema(type="string", example="available")
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
     *         @OA\JsonContent(ref="#/components/schemas/MileageTrackerPaginatedCollection")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Mileage trackers not found"
     *     )
     * )
     */
    public function getPaginated(PaginatedMileageTrackerRequest $request)
    {
        try {
            $mileageTrackers = $this->repository->getPaginated($request);
            return new MileageTrackerPaginatedCollection($mileageTrackers);
        } catch (Exception $e) { 
            return ApiResponse::error($e->getMessage(), 404);
        }
    }

    /**
     * @OA\Post(
     *     path="/mileage-trackers",
     *     summary="Create a new mileage tracker",
     *     tags={"Mileage Trackers"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/StoreMileageTrackerRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Mileage tracker created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/MileageTrackerResource")
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Invalid input"
     *     )
     * )
     */
    public function store(StoreMileageTrackerRequest $request)
    {
        try {
            $mileageTracker = $this->repository->create($request);
            return new MileageTrackerResource($mileageTracker);
        } catch (Exception $e) { 
            return ApiResponse::error($e->getMessage(), 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/mileage-trackers/{id}",
     *     summary="Get mileage tracker",
     *     tags={"Mileage Trackers"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the mileage tracker to retrieve",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             ref="#/components/schemas/MileageTrackerResource"
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Mileage tracker not found"
     *     )
     * )
     */
    public function show(string $id)
    {
        $id = (int) $id;
        try {
            $mileageTracker = $this->repository->getById($id);
            return new MileageTrackerResource($mileageTracker);
        } catch (Exception $e) {
            return ApiResponse::error($e->getMessage(), 404);
        }
    }

    /**
     * @OA\Put(
     *     path="/mileage-trackers/{id}",
     *     summary="Update a mileage tracker",
     *     tags={"Mileage Trackers"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the mileage tracker to update",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/UpdateMileageTrackerRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Mileage tracker updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/MileageTrackerResource")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Mileage tracker not found"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid input"
     *     )
     * )
     */
    public function update(
        UpdateMileageTrackerRequest $request, 
        string $id
    ) {
        $id = (int) $id;
        try {
            $mileageTracker = $this->repository->update($id, 
                                                        $request);
            return new MileageTrackerResource($mileageTracker);
        } catch (Exception $e) {
            return ApiResponse::error($e->getMessage(), 404);
        }
    }

    /**
     * @OA\Delete(
     *     path="/mileage-trackers/{id}",
     *     summary="Delete a mileage tracker",
     *     tags={"Mileage Trackers"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the mileage tracker to delete",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Mileage tracker deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Mileage tracker not found"
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
     *     path="/mileage-trackers/{id}/is-deletable",
     *     summary="Check mileage trackers delability",
     *     tags={"Mileage Trackers"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the mileage trackers",
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
     *         description="Mileage Tracker not found"
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

    /**
     * @OA\Put(
     *     path="/mileage-trackers/{id}/generate-key",
     *     summary="Update a mileage tracker key",
     *     tags={"Mileage Trackers"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the mileage tracker to update key",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Mileage tracker key updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/MileageTrackerResource")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Mileage tracker not found"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid input"
     *     )
     * )
     */
    public function generateKey(string $id) {
        $id = (int) $id;
        try {
            $mileageTracker = $this->repository->generateKey($id);
            return new MileageTrackerResource($mileageTracker);
        } catch (Exception $e) {
            return ApiResponse::error($e->getMessage(), 404);
        }
    }
}