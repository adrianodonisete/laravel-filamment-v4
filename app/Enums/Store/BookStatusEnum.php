<?php

namespace App\Enums\Store;

enum BookStatusEnum: string
{
    case ACTIVE = 'Active';
    case OUT_OF_STOCK = 'Out of Stock';
    case INACTIVE = 'Inactive';
}
