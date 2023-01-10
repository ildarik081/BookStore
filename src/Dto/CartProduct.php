<?php

namespace App\Dto;

use JMS\Serializer\Annotation;

class CartProduct extends Product
{
    /**
     * Количество позиций товара
     *
     * @var int
     * @Annotation\Type("integer")
     * @Annotation\SerializedName("quantity")
     */
    public int $quantity;
}
