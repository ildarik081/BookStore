<?php

namespace App\Component\Factory;

use App\Dto\ControllerResponse\ProductListResponse;
use App\Dto\Product as DtoProduct;
use App\Entity\Product;

class SimpleResponsFactory
{
    /**
     * @param Product[] $products
     * @return ProductListResponse
     */
    public static function createProductListResponse(array $products): ProductListResponse
    {
        $response = new ProductListResponse();
        $response->products = self::createProducts($products);

        return $response;
    }

    /**
     * @param Product[] $products
     * @return DtoProduct[]
     */
    private static function createProducts(array $products): array
    {
        $result = [];

        foreach ($products as $product) {
            $result[] = self::createProduct($product);
        }

        return $result;
    }

    /**
     * @param Product $product
     * @return DtoProduct
     */
    private static function createProduct(Product $product): DtoProduct
    {
        $productDto = new DtoProduct();
        $productDto->id = $product->getId();
        $productDto->price = $product->getPrice();
        $productDto->title = $product->getTitle();
        $productDto->description = $product->getDescription();
        $productDto->author = $product->getAuthor();
        $productDto->image = $product->getImage();
        $productDto->url = $product->getUrl();

        return $productDto;
    }
}
