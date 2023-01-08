<?php

namespace App\Controller;

use App\Dto\ControllerRequest\BaseDtoRequest;
use App\Dto\ControllerResponse\BaseDtoResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Annotations as OA;
use Nelmio\ApiDocBundle\Annotation\Model;

#[Route('/api/product', name: 'api_product_')]
class ProductController extends AbstractController
{
    /**
     * Список товаров
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
    #[Route('/list', name: 'list', methods: ['GET'])]
    public function list(BaseDtoRequest $request): BaseDtoResponse
    {
        return new BaseDtoResponse();
    }

    /**
     * Добавить товар
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
    #[Route('/add', name: 'add', methods: ['POST'])]
    public function add(BaseDtoRequest $request): BaseDtoResponse
    {
        return new BaseDtoResponse();
    }

    /**
     * Изменить товар
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
    #[Route('/edit/{id}', name: 'edit', methods: ['PUT'])]
    public function edit(BaseDtoRequest $request): BaseDtoResponse
    {
        return new BaseDtoResponse();
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
