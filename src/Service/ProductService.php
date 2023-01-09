<?php

namespace App\Service;

use App\Component\Builder\ProductBuilder;
use App\Component\Exception\ProductException;
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
     * @throws ProductException
     */
    public function editProduct(ProductRequest $request): Product
    {
        $product = $this->productRepository->find($request->id);

        if (null === $product) {
            throw new ProductException(
                message: 'Отсутствуют товар с идентификатором ' . $request->id,
                code: ResponseAlias::HTTP_BAD_REQUEST,
                responseCode: 'PRODUCT_NOT_FOUND',
                logLevel: LogLevel::WARNING
            );
        }

        $this
            ->builder
            ->setExistProduct($product)
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
}
