<?php

namespace App\Dto\ControllerRequest;

use JMS\Serializer\Annotation;
use App\Component\Interface\AbstractDtoControllerRequest;

class ProductCartRequest extends AbstractDtoControllerRequest
{
    /**
     * Количество позиций товара
     *
     * @var int
     * @Annotation\Type("integer")
     * @Annotation\SerializedName("quantity")
     */
    public int $quantity;

    /**
     * Идентификатор товара
     *
     * @var int
     * @Annotation\Type("integer")
     * @Annotation\SerializedName("id")
     */
    public int $id;
}
