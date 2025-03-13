<?php

namespace App\Enums;

enum Salutation: string
{
    case MR = 'mr';
    case MS = 'ms';
    case MRS = 'mrs';
    case MISS = 'miss';
    case REV = 'rev';
    case COMPANY = 'company';

    public static function getValues(): array
    {
        return array_column(self::cases(), 'value');
    }
}