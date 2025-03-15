<?php

/*
 * @copyright (c) 2025 Pragith Lakshan Thilakarathna
 * All rights reserved. 
 * This code is proprietary to CJNextGenSys. 
 * Unauthorized use, reproduction, modification, distribution, or sale 
 * without the explicit written permission of CJNextGenSys is strictly prohibited.
 * For inquiries, please contact: [info@cjnextgensys.com]
*/

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="DeletabilityResource",
 *     type="object",
 *     title="Deletability Resource",
 *     @OA\Property(property="isDeletable", type="bool", example="false"),
 *     @OA\Property(property="messages", example="[]"),
 * )
 */
class DeletabilityResource extends JsonResource
{
    public function __construct(
        public bool $isDeletable,
        public array $messages = []
    ) {}

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'isDeletable' => $this->isDeletable,
            'messages' => $this->messages
        ];
    }
}
