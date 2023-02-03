<?php

namespace App\Dto\ControllerRequest;

use JMS\Serializer\Annotation;
use App\Component\Interface\AbstractDtoControllerRequest;
use Symfony\Component\Validator\Constraints as Assert;

class ProductCartRequest extends AbstractDtoControllerRequest
{
    /**
     * Количество позиций товара
     *
     * @var int
     * @Annotation\Type("integer")
     * @Annotation\SerializedName("quantity")
     */
    #[Assert\NotBlank(message: 'Укажите количество товаров')]
    public int $quantity;

    /**
     * Идентификатор товара
     *
     * @var int
     * @Annotation\Type("integer")
     * @Annotation\SerializedName("id")
     */
    #[Assert\NotBlank(message: 'Укажите идентификатор товара')]
    public int $id;
}
