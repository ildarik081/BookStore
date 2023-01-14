<?php

namespace App\Controller;

use App\Component\Exception\RepositoryException;
use App\Dto\CartProduct;
use App\Dto\ControllerRequest\BaseRequest;
use App\Dto\ControllerRequest\ProductCartRequest;
use App\Dto\ControllerResponse\BaseResponse;
use App\Dto\ControllerResponse\CartResponse;
use App\Dto\ControllerResponse\SuccessResponse;
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
     *    description="Идентификатор товара и количество едениц",
     *    @Model(type=ProductCartRequest::class)
     * )
     * @OA\Response(
     *      response=200,
     *      description="Статус добавления товара в корзину",
     *      @Model(type=SuccessResponse::class)
     * )
     * @OA\Tag(name="Cart")
     * @param ProductCartRequest $request
     * @return SuccessResponse
     */
    #[Route('/add', name: 'add', methods: ['POST'])]
    public function add(ProductCartRequest $request): SuccessResponse
    {
        return $this->cartService->addProduct($request);
    }

    /**
     * Удалить товар из корзины
     *
     * @OA\RequestBody(
     *    description="Идентификатор товара и количество едениц",
     *    @Model(type=ProductCartRequest::class)
     * )
     * @OA\Response(
     *      response=200,
     *      description="Статус удаления товаров из корзины",
     *      @Model(type=SuccessResponse::class)
     * )
     * @OA\Tag(name="Cart")
     * @param ProductCartRequest $request
     * @return SuccessResponse
     */
    #[Route('/remove', name: 'remove', methods: ['DELETE'])]
    public function remove(ProductCartRequest $request): SuccessResponse
    {
        return $this->cartService->deleteProduct($request);
    }

    /**
     * Очистить корзину
     *
     * @OA\Response(
     *      response=200,
     *      description="Статус очистки корзины",
     *      @Model(type=SuccessResponse::class)
     * )
     * @OA\Tag(name="Cart")
     * @return SuccessResponse
     */
    #[Route('/clear', name: 'clear', methods: ['DELETE'])]
    public function clear(BaseRequest $request): SuccessResponse
    {
        return $this->cartService->clearCart($request);
    }
}
