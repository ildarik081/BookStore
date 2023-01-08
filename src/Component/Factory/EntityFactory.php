<?php

namespace App\Component\Factory;

use App\Entity\Product;

class EntityFactory
{
    /**
     * @param float $price
     * @param string $title
     * @param string $url
     * @param string|null $description
     * @param string|null $author
     * @param string|null $image
     * @return Product
     */
    public static function createProduct(
        float $price,
        string $title,
        string $url,
        ?string $description = null,
        ?string $author = null,
        ?string $image = null
    ): Product {
        $product = new Product();
        $product
            ->setPrice($price)
            ->setTitle($title)
            ->setDescription($description)
            ->setAuthor($author)
            ->setImage($image)
            ->setUrl($url);

        return $product;
    }
}
