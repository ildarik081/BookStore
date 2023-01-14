<?php

namespace App\Component\Factory;

use App\Dto\ControllerResponse\SuccessResponse;
use App\Entity\CartProduct;
use App\Entity\Product;

class EntityFactory
{
    public static function createCartProduct(int $quantity, Product $product): CartProduct
    {
        $cartProduct = new CartProduct();
        $cartProduct
            ->setQuantity($quantity)
            ->setProduct($product);

        return $cartProduct;
    }
}
