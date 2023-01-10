<?php

namespace App\Controller;

use App\Dto\ControllerRequest\BaseDtoRequest;
use App\Dto\ControllerResponse\BaseResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Annotations as OA;
use Nelmio\ApiDocBundle\Annotation\Model;

#[Route('/api/cart', name: 'api_cart_')]
class CartController extends AbstractController
{
    /**
     * Получить содержимое корзины
     *
     * @OA\RequestBody(
     *    description="",
     *    @Model(type=BaseDtoRequest::class)
     * )
     * @OA\Response(
     *      response=200,
     *      description="",
     *      @Model(type=BaseResponse::class)
     * )
     * @OA\Tag(name="Cart")
     * @param BaseDtoRequest $request
     * @return BaseResponse
     */
    #[Route('', name: 'get_cart', methods: ['GET'])]
    public function getCart(BaseDtoRequest $request): BaseResponse
    {
        return new BaseResponse();
    }

    /**
     * Добавить товар в корзину
     *
     * @OA\RequestBody(
     *    description="",
     *    @Model(type=BaseDtoRequest::class)
     * )
     * @OA\Response(
     *      response=200,
     *      description="",
     *      @Model(type=BaseResponse::class)
     * )
     * @OA\Tag(name="Cart")
     * @param BaseDtoRequest $request
     * @return BaseResponse
     */
    #[Route('/add', name: 'add', methods: ['POST'])]
    public function add(BaseDtoRequest $request): BaseResponse
    {
        return new BaseResponse();
    }

    /**
     * Удалить товар из корзины
     *
     * @OA\RequestBody(
     *    description="",
     *    @Model(type=BaseDtoRequest::class)
     * )
     * @OA\Response(
     *      response=200,
     *      description="",
     *      @Model(type=BaseResponse::class)
     * )
     * @OA\Tag(name="Cart")
     * @param BaseDtoRequest $request
     * @return BaseResponse
     */
    #[Route('/remove', name: 'remove', methods: ['DELETE'])]
    public function remove(): void
    {
        return;
    }

    /**
     * Очистить корзину
     *
     * @OA\RequestBody(
     *    description="",
     *    @Model(type=BaseDtoRequest::class)
     * )
     * @OA\Response(
     *      response=200,
     *      description="",
     *      @Model(type=BaseResponse::class)
     * )
     * @OA\Tag(name="Cart")
     * @param BaseDtoRequest $request
     * @return BaseResponse
     */
    #[Route('/clear', name: 'clear', methods: ['DELETE'])]
    public function clear(): void
    {
        return;
    }
}
