<?php

namespace App\Dto\ControllerResponse;

use App\Component\Interface\Controller\ControllerResponseInterface;
use App\Dto\Product;
use JMS\Serializer\Annotation;

class ProductListResponse implements ControllerResponseInterface
{
    /**
     * Товары
     *
     * @var Product[]
     * @Annotation\Type("array<App\Dto\Product>")
     * @Annotation\SerializedName("products")
     */
    public array $products = [];
}
