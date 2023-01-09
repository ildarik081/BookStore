<?php

namespace App\Service;

use App\Component\Builder\ProductBuilder;
use App\Component\Factory\EntityFactory;
use App\Component\Factory\SimpleResponsFactory;
use App\Dto\ControllerRequest\ProductListRequest;
use App\Dto\ControllerRequest\ProductRequest;
use App\Dto\ControllerResponse\ProductListResponse;
use App\Dto\Product;
use App\Repository\ProductRepository;
use Psr\Log\LogLevel;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class ProductService
{
    /**
     * @param ProductRepository $productRepository
     * @param ProductBuilder $builder
     */
    public function __construct(
        private readonly ProductRepository $productRepository,
        private readonly ProductBuilder $builder
    ) {
    }

    /**
     * Получить список товаров
     *
     * @param ProductListRequest $request
     * @return ProductListResponse
     */
    public function getProductList(ProductListRequest $request): ProductListResponse
    {
        $products = $this
            ->productRepository
            ->findBy(
                criteria: [],
                orderBy: ['id' => $request->orderBy],
                limit: $request->limit,
                offset: $request->offset
            );

        return SimpleResponsFactory::createProductListResponse($products);
    }

    /**
     * Добавить товар
     *
     * @param ProductRequest $request
     * @return Product
     */
    public function addProduct(ProductRequest $request): Product
    {
        $product = $this
            ->builder
            ->setPrice($request->price)
            ->setTitle($request->title)
            ->setUrl($request->url)
            ->setDescription($request->description)
            ->setAuthor($request->author)
            ->setImage($request->image)
            ->build()
            ->getResult();

        $this->productRepository->save($product, true);

        return SimpleResponsFactory::createProduct($product);
    }

    /**
     * Изменить товар
     *
     * @param ProductRequest $request
     * @return Product
     */
    public function editProduct(ProductRequest $request): Product
    {
        $product = EntityFactory::createProduct(
            $request->price,
            $request->title,
            $request->url,
            $request->description,
            $request->author,
            $request->image
        );

        $this->productRepository->save($product, true);

        return SimpleResponsFactory::createProduct($product);
    }
}
