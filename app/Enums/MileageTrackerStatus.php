<?php

/*
 * @copyright (c) 2025 Pragith Lakshan Thilakarathna
 * All rights reserved. 
 * This code is proprietary to CJNextGenSys. 
 * Unauthorized use, reproduction, modification, distribution, or sale 
 * without the explicit written permission of CJNextGenSys is strictly prohibited.
 * For inquiries, please contact: [info@cjnextgensys.com]
*/

namespace App\Enums;

enum MileageTrackerStatus: string
{
    case ASSIGNED = 'assigned';
    case AVAILABLE = 'available';
    case TERMINATED = 'terminated';

    public static function getValues(): array
    {
        return array_column(self::cases(), 'value');
    }
}