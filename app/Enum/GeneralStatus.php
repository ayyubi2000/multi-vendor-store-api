<?php

namespace App\Enum;

enum GeneralStatus: int
{
    case STATUS_DELETED = 0;
    case STATUS_NOT_ACTIVE = 10;
    case STATUS_ACTIVE = 20;
}
