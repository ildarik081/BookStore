<?php

namespace App\Component\Utils\Enum;

enum PaymentTypeEnum: string
{
    /** Оплата банковской картой */
    case Card = 'card';

    /** Оплата через систему безопасных платежей */
    case Sbp = 'sbp';
}
