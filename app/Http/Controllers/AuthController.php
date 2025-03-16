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
use App\Http\Requests\AuthRequest;
use App\Repositories\Interfaces\AuthRepositoryInterface;
use Exception;
use Illuminate\Http\Request;

/** 
 * @OA\Server(
 *     url=L5_SWAGGER_CONST_HOST
 * )
 */
class AuthController extends Controller
{
    protected $repository;

    public function __construct(AuthRepositoryInterface $authRepository)
    {
        $this->repository = $authRepository;
    }

    /**
     * @OA\Post(
     *     path="/login",
     *     summary="Login to the system",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/AuthRequest")
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Invalid input"
     *     )
     * )
     */
    public function login(AuthRequest $request)
    {
        try {
            return $this->repository->login($request);
        } catch (Exception $e) { 
            return ApiResponse::error($e->getMessage(), 500);
        }
    }

    /**
     * @OA\Post(
     *     path="/logout",
     *     summary="Logout from the system",
     *     tags={"Auth"},
     *     @OA\Response(
     *         response=500,
     *         description="Invalid input"
     *     )
     * )
     */
    public function logout(Request $request)
    {
        try {
            return $this->repository->logout($request);
        } catch (Exception $e) { 
            return ApiResponse::error($e->getMessage(), 500);
        }
    }
}