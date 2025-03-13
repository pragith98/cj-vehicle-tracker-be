<?php

/*
 * @copyright (c) 2025 Pragith Lakshan Thilakarathna
 * All rights reserved. 
 * This code is proprietary to CJNextGenSys. 
 * Unauthorized use, reproduction, modification, distribution, or sale 
 * without the explicit written permission of CJNextGenSys is strictly prohibited.
 * For inquiries, please contact: [info@cjnextgensys.com]
*/

namespace App\Repositories\Interfaces;

use App\Http\Requests\User\PaginatedUserRequest;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\User;
use Illuminate\Support\Collection;

interface UserRepositoryInterface
{
  public function getAll(): Collection;

  public function getPaginated(PaginatedUserRequest $request): array;
  
  public function getById(int $id): User;
  
  public function create(StoreUserRequest $request): User;
  
  public function update(
    int $id,
    UpdateUserRequest $request
  ): User;
  
  public function delete(int $id): bool;
}