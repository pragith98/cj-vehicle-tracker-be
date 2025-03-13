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
use App\Http\Requests\User\PaginatedUserRequest;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\UserPaginatedCollection;
use App\Http\Resources\UserResource;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Exception;

/** 
 * @OA\Info(
 *      title="CJ Vehicle Tracker API", 
 *      version="1"
 * )
 * @OA\Server(
 *     url=L5_SWAGGER_CONST_HOST
 * )
 */
class UserController extends Controller
{
    protected $repository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->repository = $userRepository;
    }

    /**
     * @OA\Get(
     *     path="/users",
     *     summary="Get users",
     *     tags={"Users"},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/UserResource")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Users not found"
     *     )
     * )
     */
    public function index()
    {
        try {
            $users = $this->repository->getAll();
            return UserResource::collection($users);
        } catch (Exception $e) { 
            return ApiResponse::error($e->getMessage(), 404);
        }
    }

    /**
     * @OA\Get(
     *     path="/users/get-paginated",
     *     summary="Get paginated users",
     *     tags={"Users"},
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
     *         @OA\JsonContent(ref="#/components/schemas/UserPaginatedCollection")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Users not found"
     *     )
     * )
     */
    public function getPaginated(PaginatedUserRequest $request)
    {
        try {
            $users = $this->repository->getPaginated($request);
            return new UserPaginatedCollection($users);
        } catch (Exception $e) { 
            return ApiResponse::error($e->getMessage(), 404);
        }
    }

    /**
     * @OA\Post(
     *     path="/users",
     *     summary="Create a new user",
     *     tags={"Users"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/StoreUserRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="User created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/UserResource")
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Invalid input"
     *     )
     * )
     */
    public function store(StoreUserRequest $request)
    {
        try {
            $user = $this->repository->create($request);
            return new UserResource($user);
        } catch (Exception $e) { 
            return ApiResponse::error($e->getMessage(), 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/users/{id}",
     *     summary="Get user",
     *     tags={"Users"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the user to retrieve",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             ref="#/components/schemas/UserResource"
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="User not found"
     *     )
     * )
     */
    public function show(string $id)
    {
        $id = (int) $id;
        try {
            $user = $this->repository->getById($id);
            return new UserResource($user);
        } catch (Exception $e) {
            return ApiResponse::error($e->getMessage(), 404);
        }
    }

    /**
     * @OA\Put(
     *     path="/users/{id}",
     *     summary="Update a user",
     *     tags={"Users"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the user to update",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/UpdateUserRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="User updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/UserResource")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="User not found"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid input"
     *     )
     * )
     */
    public function update(
        UpdateUserRequest $request, 
        string $id
    ) {
        $id = (int) $id;
        try {
            $user = $this->repository->update($id, 
                                              $request);
            return new UserResource($user);
        } catch (Exception $e) {
            return ApiResponse::error($e->getMessage(), 404);
        }
    }

    /**
     * @OA\Delete(
     *     path="/users/{id}",
     *     summary="Delete a user",
     *     tags={"Users"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the user to delete",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="User deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="User not found"
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