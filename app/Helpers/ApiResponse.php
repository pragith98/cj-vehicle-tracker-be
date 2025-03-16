<?php

/*
 * @copyright (c) 2025 Pragith Lakshan Thilakarathna
 * All rights reserved. 
 * This code is proprietary to CJNextGenSys. 
 * Unauthorized use, reproduction, modification, distribution, or sale 
 * without the explicit written permission of CJNextGenSys is strictly prohibited.
 * For inquiries, please contact: [info@cjnextgensys.com]
*/

namespace App\Helpers;

class ApiResponse {
  public static function error($message, $statusCode = 400) {
    return response()->json([
      'success' => false, 
      'message' => $message
    ], $statusCode);
  }
}