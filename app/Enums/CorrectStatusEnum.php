<?php

namespace App\Enums;

enum CorrectStatusEnum: string
{
    case TRUE = 'true';
    case FALSE = 'false';
    case PARTIAL = 'partial true';
}
