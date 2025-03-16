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

use App\Http\Requests\AuthRequest;
use Illuminate\Http\Request;

interface AuthRepositoryInterface
{
    public function login(AuthRequest $request);

    public function logout(Request $request);

    public function user(Request $request);
}