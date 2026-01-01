<?php

namespace App\Enums;

enum EscrowStatus: string
{
    case CREATED   = 'created';
    case FUNDED    = 'funded';
    case SHIPPING  = 'shipping';
    case DELIVERED = 'delivered';
    case RELEASED  = 'released';
    case DISPUTED  = 'disputed';
    case REFUNDED  = 'refunded';
}
