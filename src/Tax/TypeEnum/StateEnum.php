<?php

declare(strict_types=1);

namespace App\Tax\TypeEnum;

enum StateEnum: string
{
    case QUEBEC = 'quebec';
    case ONTARIO = 'ontario';
    case CALIFORNIA = 'california';
}
