<?php

namespace App\Controller;

use App\Component\Exception\ProductException;
use App\Component\Exception\ValidatorException;
use App\Component\Factory\SimpleResponsFactory;
use App\Component\Validator\ProductDtoValidator;
use App\Dto\ControllerRequest\ProductListRequest;
use App\Dto\ControllerRequest\ProductRequest;
use App\Dto\ControllerResponse\BaseResponse;
use App\Dto\ControllerResponse\ProductListResponse;
use App\Dto\ControllerResponse\SuccessResponse;
use App\Dto\Product;
use App\Entity\Product as EntityProduct;
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
     * @throws ValidatorException
     */
    #[Route('/add', name: 'add', methods: ['POST'])]
    public function add(ProductRequest $request): Product
    {
        ProductDtoValidator::validateProductRequest($request);

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
     * @throws ValidatorException
     * @throws ProductException
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
     *    description="Данные о товаре (можно передать только id)",
     *    @Model(type=ProductRequest::class)
     * )
     * @OA\Response(
     *      response=200,
     *      description="Статус удаления товара",
     *      @Model(type=SuccessResponse::class)
     * )
     * @OA\Tag(name="Product")
     * @param ProductRequest $request
     * @return SuccessResponse
     * @throws ProductException
     */
    #[Route('/delete', name: 'delete', methods: ['DELETE'])]
    public function delete(ProductRequest $request): SuccessResponse
    {
        return $this->productService->deleteProduct($request);
    }

    /**
     * Получить товар по идентификатору
     *
     * @OA\Response(
     *      response=200,
     *      description="Данные о товаре",
     *      @Model(type=Product::class)
     * )
     * @OA\Tag(name="Product")
     * @param EntityProduct $product
     * @return Product
     */
    #[Route('/item/{id}', name: 'item', methods: ['GET'])]
    public function item(EntityProduct $product): Product
    {
        return SimpleResponsFactory::createProduct($product);
    }
}
