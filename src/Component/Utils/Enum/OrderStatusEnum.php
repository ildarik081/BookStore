<?php

namespace App\Component\Utils\Enum;

enum OrderStatusEnum: string
{
    /** Новый заказ */
    case New = 'new';

    /** Заказ в работе */
    case InWork = 'inWork';

    /** Завершенный заказ */
    case Completed = 'completed';
}
