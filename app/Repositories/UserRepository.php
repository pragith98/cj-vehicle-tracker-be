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

use App\Http\Requests\User\PaginatedUserRequest;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;

class UserRepository implements UserRepositoryInterface
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function getAll(): Collection
    {
        try {
            return $this->user->all();
        } catch (ModelNotFoundException $e) {
            throw new Exception("Users not found.", 404);
        }
    }

    public function getPaginated(PaginatedUserRequest $request): array
    {
        $limit = $request->getLimit();
        $page = $request->getPage();

        try {
            $paginated = $this->user->paginate($limit, ['*'], 'page', $page);
            return [
                'data' => $paginated->items(),
                'total' => $paginated->total()
            ];
        } catch (ModelNotFoundException $e) {
            throw new Exception("Users not found.", 404);
        }
    }

    public function getById(int $id): User
    {
        try {
            return $this->user->findOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new Exception("User with ID {$id} not found.", 404);
        }
    }

    public function create(StoreUserRequest $request): User
    {
        try {
            return $this->user->create($request->validated());
        } catch (Exception $e) {
            throw new Exception("Failed to create user.", 500);
        }
    }

    public function update(
        int $id,
        UpdateUserRequest $request
    ): User {
        try {
            $user = $this->user->findOrFail($id);
            $user->update($request->validated());
            return $user;
        } catch (ModelNotFoundException $e) {
            throw new Exception("User with ID {$id} not found.", 404);
        } catch (Exception $e) {
            throw new Exception("Failed to update user.", 500);
        }
    }

    public function delete(int $id): bool
    {
        try {
            $user = $this->user->findOrFail($id);
            $user->delete();

            return true;
        } catch (ModelNotFoundException $e) {
            throw new Exception("User with ID {$id} not found.", 404);
        } catch (Exception $e) {
            throw new Exception("Failed to delete user.", 500);
        }
    }
}