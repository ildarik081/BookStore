<?php

namespace App\Component\Utils\Enum;

enum OrderStatusEnum: string
{
    /** Новый заказ */
    case NewOrder = 'new';

    /** Заказ в работе */
    case InWork = 'inWork';

    /** Завершенный заказ */
    case Completed = 'completed';

    /**
     * Получить тему для email уведомления
     *
     * @param integer|null $number
     * @return string
     */
    public function getSubject(?int $number): string
    {
        return match ($this) {
            self::NewOrder => 'Вами оформлен заказ № ' . $number,
            self::InWork => 'Заказ № ' . $number . ' передан в работу',
            self::Completed => 'Заказ № ' . $number . ' успешно завершен',
            default => 'Движение по заказу'
        };
    }
}
