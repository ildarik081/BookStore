<?php

namespace App\Controller;

use App\Dto\ControllerRequest\BaseRequest;
use App\Dto\ControllerResponse\BaseResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Annotations as OA;
use Nelmio\ApiDocBundle\Annotation\Model;

#[Route('/api/image', name: 'api_image_')]
class ImageController extends AbstractController
{
    public function __construct()
    {
    }

    /**
     * Список изображений
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
     *      description="Список изображений",
     *      @Model(type=BaseResponse::class)
     * )
     * @OA\Tag(name="Image")
     * @param BaseRequest $request
     * @return BaseResponse
     */
    #[Route('/list', name: 'list', methods: ['GET'])]
    public function list(BaseRequest $request): BaseResponse
    {
        return new BaseResponse();
    }

    /**
     * Добавить изображение
     *
     * @OA\RequestBody(
     *    description="Данные об изображении",
     *    @Model(type=ProductRequest::class)
     * )
     * @OA\Response(
     *      response=200,
     *      description="Добавленный изображение",
     *      @Model(type=Product::class)
     * )
     * @OA\Tag(name="Image")
     * @param BaseRequest $request
     * @return BaseResponse
     */
    #[Route('/add', name: 'add', methods: ['POST'])]
    public function add(BaseRequest $request): BaseResponse
    {
        return new BaseResponse();
    }

    /**
     * Изменить информацию об изображении
     *
     * id — обязательный параметр
     *
     * @OA\RequestBody(
     *    description="Данные о товаре",
     *    @Model(type=ProductRequest::class)
     * )
     * @OA\Response(
     *      response=200,
     *      description="Измененный данные об изображении",
     *      @Model(type=BaseResponse::class)
     * )
     * @OA\Tag(name="Image")
     * @param BaseRequest $request
     * @return BaseResponse
     */
    #[Route('/edit', name: 'edit', methods: ['PUT'])]
    public function edit(BaseRequest $request): BaseResponse
    {
        return new BaseResponse();
    }

    /**
     * Удалить изображение
     *
     * id — обязательный параметр
     *
     * @OA\RequestBody(
     *    description="Данные об изображении (можно передать только id)",
     *    @Model(type=BaseRequest::class)
     * )
     * @OA\Response(
     *      response=200,
     *      description="Статус удаления товара",
     *      @Model(type=BaseResponse::class)
     * )
     * @OA\Tag(name="Image")
     * @param BaseRequest $request
     * @return BaseResponse
     */
    #[Route('/delete', name: 'delete', methods: ['DELETE'])]
    public function delete(BaseRequest $request): BaseResponse
    {
        return new BaseResponse();
    }

    /**
     * Получить изображение по идентификатору
     *
     * @OA\Response(
     *      response=200,
     *      description="Данные об изображении",
     *      @Model(type=BaseResponse::class)
     * )
     * @OA\Tag(name="Product")
     * @param BaseRequest $product
     * @return BaseResponse
     */
    #[Route('/item/{id}', name: 'item', methods: ['GET'])]
    public function item(BaseRequest $request): BaseResponse
    {
        return new BaseResponse();
    }
}
