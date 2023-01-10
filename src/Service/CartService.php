<?php

namespace App\Service;

use App\Component\Exception\RepositoryException;
use App\Dto\ControllerRequest\BaseRequest;
use App\Dto\ControllerResponse\CartResponse;
use App\Repository\CartRepository;
use Psr\Log\LogLevel;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class CartService
{
    /**
     * @param CartRepository $cartRepository
     */
    public function __construct(private readonly CartRepository $cartRepository)
    {
    }

    /**
     * Получить содержимое корзины
     *
     * @param BaseRequest $request
     * @return CartResponse
     * @throws RepositoryException
     */
    public function getCart(BaseRequest $request): CartResponse
    {
        $cart = $this->cartRepository->getCartBySessionId($request->session);

        return new CartResponse();
    }
}
