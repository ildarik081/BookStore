<?php

namespace App\Controller;

use App\Component\Exception\RepositoryException;
use App\Dto\ControllerRequest\BaseRequest;
use App\Dto\ControllerResponse\BaseResponse;
use App\Dto\ControllerResponse\CartResponse;
use App\Service\CartService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Annotations as OA;
use Nelmio\ApiDocBundle\Annotation\Model;

#[Route('/api/cart', name: 'api_cart_')]
class CartController extends AbstractController
{
    public function __construct(private readonly CartService $cartService)
    {
    }

    /**
     * Получить содержимое корзины
     *
     * @OA\Response(
     *      response=200,
     *      description="Список товаров в корзине",
     *      @Model(type=CartResponse::class)
     * )
     * @OA\Tag(name="Cart")
     * @param BaseRequest $request
     * @return CartResponse
     * @throws RepositoryException
     */
    #[Route('', name: 'get_cart', methods: ['GET'])]
    public function getCart(BaseRequest $request): CartResponse
    {
        return $this->cartService->getCart($request);
    }

    /**
     * Добавить товар в корзину
     *
     * @OA\RequestBody(
     *    description="",
     *    @Model(type=BaseRequest::class)
     * )
     * @OA\Response(
     *      response=200,
     *      description="",
     *      @Model(type=BaseResponse::class)
     * )
     * @OA\Tag(name="Cart")
     * @param BaseRequest $request
     * @return BaseResponse
     */
    #[Route('/add', name: 'add', methods: ['POST'])]
    public function add(BaseRequest $request): BaseResponse
    {
        return new BaseResponse();
    }

    /**
     * Удалить товар из корзины
     *
     * @OA\RequestBody(
     *    description="",
     *    @Model(type=BaseRequest::class)
     * )
     * @OA\Response(
     *      response=200,
     *      description="",
     *      @Model(type=BaseResponse::class)
     * )
     * @OA\Tag(name="Cart")
     * @param BaseRequest $request
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
     *    @Model(type=BaseRequest::class)
     * )
     * @OA\Response(
     *      response=200,
     *      description="",
     *      @Model(type=BaseResponse::class)
     * )
     * @OA\Tag(name="Cart")
     * @param BaseRequest $request
     * @return BaseResponse
     */
    #[Route('/clear', name: 'clear', methods: ['DELETE'])]
    public function clear(): void
    {
        return;
    }
}
