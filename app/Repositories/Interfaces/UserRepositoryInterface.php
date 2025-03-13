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

use App\Http\Requests\PaginatedUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Support\Collection;

interface UserRepositoryInterface
{
  public function getAll(): Collection;

  public function getPaginated(PaginatedUserRequest $request): array;
  
  public function getById($id): User;
  
  public function create(StoreUserRequest $request): User;
  
  public function update(
    $id,
    UpdateUserRequest $request
  ): User;
  
  public function delete($id): bool;
}