<?php

namespace App\Service;

use App\Component\Factory\SimpleResponsFactory;
use App\Dto\ControllerRequest\ProductListRequest;
use App\Dto\ControllerResponse\ProductListResponse;
use App\Repository\ProductRepository;
use Psr\Log\LogLevel;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class ProductService
{
    /**
     * @param ProductRepository $productRepository
     */
    public function __construct(private readonly ProductRepository $productRepository)
    {
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
}
