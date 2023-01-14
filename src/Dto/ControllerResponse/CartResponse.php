<?php

namespace App\Dto\ControllerResponse;

use App\Component\Interface\Controller\ControllerResponseInterface;
use App\Dto\CartProduct;
use JMS\Serializer\Annotation;

class CartResponse implements ControllerResponseInterface
{
    /**
     * Дата создания корзины
     *
     * @var string
     * @Annotation\Type("string")
     * @Annotation\SerializedName("dtCreate")
     */
    public string $dtCreate;

    /**
     * Дата последнего обновления корзины
     *
     * @var string
     * @Annotation\Type("string")
     * @Annotation\SerializedName("dtUpdate")
     */
    public string $dtUpdate;

    /**
     * Общеяя стоимость товаров в корзине
     *
     * @var float
     * @Annotation\Type("float")
     * @Annotation\SerializedName("totalPrice")
     */
    public float $totalPrice;

    /**
     * Общее количество товаров в корзине
     *
     * @var int
     * @Annotation\Type("integer")
     * @Annotation\SerializedName("totalQuantity")
     */
    public int $totalQuantity;

    /**
     * Товары
     *
     * @var CartProduct[]
     * @Annotation\Type("array<App\Dto\CartProduct>")
     * @Annotation\SerializedName("products")
     */
    public array $products = [];
}
