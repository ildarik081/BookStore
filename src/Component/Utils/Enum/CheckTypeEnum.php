<?php

namespace App\Component\Utils\Enum;

enum CheckTypeEnum: string
{
    /** Авансовый чек */
    case Advance = 'advance';

    /** Возврат аванса */
    case RefundAdvance = 'refundAdvance';

    /** Чек полного расчета */
    case FullSettlement = 'fullSettlement';

    /** Возврат полного расчета */
    case RefundFullSettlement = 'refundFullSettlement';
}
