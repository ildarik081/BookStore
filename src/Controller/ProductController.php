<?php

namespace App\Controller;

use App\Component\Utils\ProductDtoValidator;
use App\Dto\ControllerRequest\BaseDtoRequest;
use App\Dto\ControllerRequest\ProductListRequest;
use App\Dto\ControllerRequest\ProductRequest;
use App\Dto\ControllerResponse\BaseDtoResponse;
use App\Dto\ControllerResponse\ProductListResponse;
use App\Dto\Product;
use App\Service\ProductService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Annotations as OA;
use Nelmio\ApiDocBundle\Annotation\Model;

#[Route('/api/product', name: 'api_product_')]
class ProductController extends AbstractController
{
    /**
     * @param ProductService $productService
     */
    public function __construct(private readonly ProductService $productService)
    {
    }

    /**
     * Список товаров
     *
     * @OA\Parameter(
     *      in="query",
     *      description="Сортировка (ASC, DESC)",
     *      name="orderBy"
     * ),
     * @OA\Parameter(
     *      in="query",
     *      description="Лимит",
     *      name="limit"
     * ),
     * @OA\Parameter(
     *      in="query",
     *      description="Смещение",
     *      name="offset"
     * ),
     * @OA\Response(
     *      response=200,
     *      description="Список товаров",
     *      @Model(type=ProductListResponse::class)
     * )
     * @OA\Tag(name="Product")
     * @param ProductListRequest $request
     * @return ProductListResponse
     */
    #[Route('/list', name: 'list', methods: ['GET'])]
    public function list(ProductListRequest $request): ProductListResponse
    {
        return $this->productService->getProductList($request);
    }

    /**
     * Добавить товар
     *
     * @OA\RequestBody(
     *    description="Данные о товаре",
     *    @Model(type=ProductRequest::class)
     * )
     * @OA\Response(
     *      response=200,
     *      description="Добавленный товар",
     *      @Model(type=Product::class)
     * )
     * @OA\Tag(name="Product")
     * @param ProductRequest $request
     * @return Product
     */
    #[Route('/add', name: 'add', methods: ['POST'])]
    public function add(ProductRequest $request): Product
    {
        return $this->productService->addProduct($request);
    }

    /**
     * Изменить товар
     *
     * id — обязательный параметр
     *
     * @OA\RequestBody(
     *    description="Данные о товаре",
     *    @Model(type=ProductRequest::class)
     * )
     * @OA\Response(
     *      response=200,
     *      description="Измененный товар",
     *      @Model(type=Product::class)
     * )
     * @OA\Tag(name="Product")
     * @param ProductRequest $request
     * @return Product
     */
    #[Route('/edit', name: 'edit', methods: ['PUT'])]
    public function edit(ProductRequest $request): Product
    {
        ProductDtoValidator::validateProductRequest($request);

        return $this->productService->editProduct($request);
    }

    /**
     * Удалить товар
     *
     * @OA\RequestBody(
     *    description="",
     *    @Model(type=BaseDtoRequest::class)
     * )
     * @OA\Response(
     *      response=200,
     *      description="",
     *      @Model(type=BaseDtoResponse::class)
     * )
     * @OA\Tag(name="Product")
     * @param BaseDtoRequest $request
     * @return BaseDtoResponse
     */
    #[Route('/delete/{id}', name: 'delete', methods: ['DELETE'])]
    public function delete(BaseDtoRequest $request): BaseDtoResponse
    {
        return new BaseDtoResponse();
    }

    /**
     * Получить товар по идентификатору
     *
     * @OA\RequestBody(
     *    description="",
     *    @Model(type=BaseDtoRequest::class)
     * )
     * @OA\Response(
     *      response=200,
     *      description="",
     *      @Model(type=BaseDtoResponse::class)
     * )
     * @OA\Tag(name="Product")
     * @param BaseDtoRequest $request
     * @return BaseDtoResponse
     */
    #[Route('/item/{id}', name: 'item', methods: ['GET'])]
    public function item(BaseDtoRequest $request): BaseDtoResponse
    {
        return new BaseDtoResponse();
    }
}
