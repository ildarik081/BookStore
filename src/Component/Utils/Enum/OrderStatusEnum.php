<?php

namespace App\Component\Utils\Enum;

use App\Dto\Email\ParamsEmail;

enum OrderStatusEnum: string
{
    /** Новый заказ */
    case New = 'new';

    /** Заказ в работе */
    case InWork = 'inWork';

    /** Завершенный заказ */
    case Completed = 'completed';

    /**
     * Получить тему для email уведомления
     *
     * @param integer|null $paramsEmail
     * @return string
     */
    public function getSubject(int $number): string
    {
        return match ($this) {
            self::New => 'Вами оформлен заказ № ' . $number,
            self::InWork => 'Заказ № ' . $number . ' передан в работу',
            self::Completed => 'Заказ № ' . $number . ' успешно завершен'
        };
    }
}
