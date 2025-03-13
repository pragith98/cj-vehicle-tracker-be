<?php

/*
 * @copyright (c) 2025 Pragith Lakshan Thilakarathna
 * All rights reserved. 
 * This code is proprietary to CJNextGenSys. 
 * Unauthorized use, reproduction, modification, distribution, or sale 
 * without the explicit written permission of CJNextGenSys is strictly prohibited.
 * For inquiries, please contact: [info@cjnextgensys.com]
*/

namespace App\Http\Requests\MileageTracker;

use Illuminate\Foundation\Http\FormRequest;

class PaginatedMileageTrackerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'limit' => ['required', 'integer', 'min:1'],
            'page' => ['required', 'integer', 'min:1']
        ];
    }

    public function getLimit()
    {
        return $this->input('limit', 20);
    }

    public function getPage()
    {
        return $this->input('page', 1);
    }
}