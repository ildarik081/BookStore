<?php

namespace App\Service;

use App\Component\Builder\CartResponseBuilder;
use App\Component\Exception\BuilderException;
use App\Component\Exception\CartException;
use App\Component\Exception\RepositoryException;
use App\Component\Factory\EntityFactory;
use App\Component\Factory\SimpleResponsFactory;
use App\Dto\ControllerRequest\BaseRequest;
use App\Dto\ControllerRequest\ProductCartRequest;
use App\Dto\ControllerResponse\CartResponse;
use App\Dto\ControllerResponse\SuccessResponse;
use App\Entity\Cart;
use App\Entity\CartProduct;
use App\Repository\CartProductRepository;
use App\Repository\CartRepository;
use App\Repository\ProductRepository;
use Psr\Log\LogLevel;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class CartService
{
    /**
     * @param CartRepository $cartRepository
     */
    public function __construct(
        private readonly CartRepository $cartRepository,
        private readonly CartProductRepository $cartProductRepository,
        private readonly ProductRepository $productRepository,
        private readonly CartResponseBuilder $cartResponseBuilder
    ) {
    }

    /**
     * Получить содержимое корзины
     *
     * @param BaseRequest $request
     * @return CartResponse
     * @throws RepositoryException
     * @throws BuilderException
     */
    public function getCart(BaseRequest $request): CartResponse
    {
        $cart = $this->cartRepository->getCartBySessionId($request->session, true);

        return $this
            ->cartResponseBuilder
            ->setCart($cart)
            ->build()
            ->getResult();
    }

    /**
     * Добавить товары в корзину
     *
     * @param ProductCartRequest $request
     * @return SuccessResponse
     * @throws RepositoryException
     */
    public function addProduct(ProductCartRequest $request): SuccessResponse
    {
        $cart = $this->cartRepository->getCartBySessionId($request->session);

        if (null === $cart) {
            $cart = new Cart();
        }

        if ($this->checkDuplicatesProduct($request, $cart)) {
            return SimpleResponsFactory::createSuccessResponse(true);
        }

        $product = $this->productRepository->getProductById($request->id);
        $a = [];
        $cart
            ->addCartProduct(
                EntityFactory::createCartProduct($request->quantity, $product)
            )
            ->setSessionId($request->session);

        $this->cartRepository->save($cart, true);

        return SimpleResponsFactory::createSuccessResponse(true);
    }

    /**
     * Удалить товары из корзины
     *
     * @param ProductCartRequest $request
     * @return SuccessResponse
     * @throws CartException
     * @throws RepositoryException
     */
    public function deleteProduct(ProductCartRequest $request): SuccessResponse
    {
        $cart = $this->cartRepository->getCartBySessionId($request->session, true);
        $cartProduct = $this->getCartProductById($cart, $request->id);

        if ($cartProduct->getQuantity() <= $request->quantity) {
            $cart->removeCartProduct($cartProduct);
            $this->cartRepository->save($cart, true);
        } else {
            $cartProduct->setQuantity(
                $cartProduct->getQuantity() - $request->quantity
            );

            $this->cartProductRepository->save($cartProduct, true);
        }


        return SimpleResponsFactory::createSuccessResponse(true);
    }

    /**
     * Очистить корзину пользователя
     *
     * @param BaseRequest $request
     * @return SuccessResponse
     * @throws RepositoryException
     */
    public function clearCart(BaseRequest $request): SuccessResponse
    {
        $cart = $this->cartRepository->getCartBySessionId($request->session, true);

        foreach ($cart->getCartProducts() as $cartProduct) {
            $cart->removeCartProduct($cartProduct);
        }

        $this->cartRepository->save($cart, true);

        return SimpleResponsFactory::createSuccessResponse(true);
    }

    /**
     * Проверить повторяющиеся товары
     *
     * @param ProductCartRequest $request
     * @param Cart $cart
     * @return bool
     */
    private function checkDuplicatesProduct(ProductCartRequest $request, Cart $cart): bool
    {
        $flag = false;

        foreach ($cart->getCartProducts() as $cartProduct) {
            if ($cartProduct->getProduct()->getId() === $request->id) {
                $cartProduct->setQuantity($cartProduct->getQuantity() + $request->quantity);
                $this->cartRepository->save($cart, true);
                $flag = true;
            }
        }


        return $flag;
    }

    /**
     * Достать товар из коллекци по id
     *
     * @param Cart $cart
     * @param ProductCartRequest $request
     * @return CartProduct
     * @throws CartException
     */
    private function getCartProductById(Cart $cart, int $id): CartProduct
    {
        $cartProduct = $cart
            ->getCartProducts()
            ->filter(
                function (CartProduct $cartProduct) use ($id) {
                    return $cartProduct->getProduct()->getId() === $id;
                }
            )
            ->first();

        if (false === $cartProduct) {
            throw new CartException(
                message: 'В вашей корзине нет товара с идентификатором ' . $id,
                code: ResponseAlias::HTTP_BAD_REQUEST,
                responseCode: 'PRODUCT_NOT_FOUND_IN_CART',
                logLevel: LogLevel::WARNING
            );
        }

        /** @var CartProduct $cartProduct */
        return $cartProduct;
    }
}
