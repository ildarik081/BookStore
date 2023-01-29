<?php

namespace App\Component\Utils;

use App\Entity\HistoryOrderStatus;

class Postman
{
    private static ?self $instance = null;
    private static ?HistoryOrderStatus $historyOrderStatus = null;

    private function __construct()
    {
    }

    /**
     * Получить экземпляр Postman
     *
     * @return Postman
     */
    public static function getInstance(): Postman
    {
        if (null !== self::$instance) {
            return self::$instance;
        }

        self::$instance = new self();

        return self::$instance;
    }

    /**
     * Событие для отправки email об изменении статуса заказа
     *
     * @param HistoryOrderStatus $historyOrderStatus
     * @return void
     */
    public function dispatchHistoryOrderStatus(HistoryOrderStatus $historyOrderStatus): void
    {
        self::$historyOrderStatus = $historyOrderStatus;
    }

    /**
     * Получить статус заказа для уведомления покупателя
     *
     * @return HistoryOrderStatus|null
     */
    public function getHistoryOrderStatus(): ?HistoryOrderStatus
    {
        $response = self::$historyOrderStatus;
        self::$historyOrderStatus = null;

        return $response;
    }
}
