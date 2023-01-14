<?php

namespace App\Component\Factory;

use App\Dto\ControllerResponse\ProductListResponse;
use App\Dto\ControllerResponse\SuccessResponse;
use App\Dto\Image as DtoImage;
use App\Dto\Product as DtoProduct;
use App\Entity\Product;
use App\Entity\Image;
use Doctrine\Common\Collections\Collection;

class SimpleResponsFactory
{
    public static function createSuccessResponse(bool $success): SuccessResponse
    {
        $response = new SuccessResponse();
        $response->success = $success;

        return $response;
    }

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
     * @param Product $product
     * @return DtoProduct
     */
    public static function createProduct(Product $product): DtoProduct
    {
        $productDto = new DtoProduct();
        $productDto->id = $product->getId();
        $productDto->price = $product->getPrice();
        $productDto->title = $product->getTitle();
        $productDto->description = $product->getDescription();
        $productDto->author = $product->getAuthor();
        $productDto->images = self::createImages($product->getImages());

        return $productDto;
    }

    /**
     * @param Collection $images
     * @return DtoImage[]
     */
    public static function createImages(Collection $images): array
    {
        $result = [];

        /** @var Image $image */
        foreach ($images as $image) {
            $result[] = self::createImage($image);
        }

        return $result;
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
     * @param Image $image
     * @return DtoImage
     */
    private static function createImage(Image $image): DtoImage
    {
        $imageDto = new DtoImage();
        $imageDto->fileName = $image->getFileName();
        $imageDto->path = $image->getPath();
        $imageDto->description = $image->getDescription();

        return $imageDto;
    }
}
