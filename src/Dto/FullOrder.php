<?php

namespace App\Dto;

use JMS\Serializer\Annotation;
use App\Dto\HistoryOrderStatus;
use App\Dto\Product;

class FullOrder
{
    /**
     * Дата оформления заказа
     *
     * @var string
     * @Annotation\Type("string")
     * @Annotation\SerializedName("dtCreate")
     */
    public string $dtCreate;

    /**
     * Общая стоимость заказа
     *
     * @var float
     * @Annotation\Type("float")
     * @Annotation\SerializedName("totalPrice")
     */
    public float $totalPrice;

    /**
     * Общая стоимость заказа
     *
     * @var HistoryOrderStatus[]
     * @Annotation\Type("array<App\Dto\HistoryOrderStatus>")
     * @Annotation\SerializedName("history")
     */
    public array $history = [];

    /**
     * Товары
     *
     * @var OrderProduct[]
     * @Annotation\Type("array<App\Dto\OrderProduct>")
     * @Annotation\SerializedName("products")
     */
    public array $products = [];
}
