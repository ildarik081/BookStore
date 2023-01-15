<?php

namespace App\Component\Factory;

use App\Dto\ControllerResponse\SuccessResponse;
use App\Entity\CartProduct;
use App\Entity\Image;
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

    public static function createImage(
        string $fileName,
        string $path,
        ?string $description = null
    ): Image {
        $image = new Image();
        $image
            ->setFileName($fileName)
            ->setPath($path)
            ->setDescription($description);

        return $image;
    }
}
