<?php

declare(strict_types=1);

namespace App\Enums\Status;
use App\Enums\Traits\EnumTrait;

enum StatusEnum: string
{
    use EnumTrait;
    
    case FINISHED = 'finished';
    case UNFINISHED = 'unfinished';

    /*
        we can add more statuses if necessary
        (i.e half-finished, non-started, trashed, etc.)
    */
}