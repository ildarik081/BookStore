<?php

namespace App\Component\Builder;

use App\Component\Exception\BuilderException;
use App\Component\Factory\SimpleResponsFactory;
use App\Component\Utils\Aliases;
use App\Dto\CartProduct;
use App\Dto\ControllerResponse\CartResponse;
use App\Entity\Cart;
use Psr\Log\LogLevel;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class CartResponseBuilder implements BuilderInterface
{
    private ?Cart $cart = null;
    private ?CartResponse $result = null;
    private ?float $totalPrice = null;

    /**
     * Собрать CartResponse
     *
     * @return CartResponseBuilder
     */
    public function build(): CartResponseBuilder
    {
        if (null === $this->cart) {
            throw new BuilderException(
                message: 'Требуется передать сущность Cart',
                code: ResponseAlias::HTTP_BAD_REQUEST,
                responseCode: 'CART_NOT_FOUND',
                logLevel: LogLevel::CRITICAL
            );
        }

        $this->result = new CartResponse();
        $this->result->dtCreate = null === $this->cart->getDtCreate()
            ? ''
            : ($this->cart->getDtCreate())->format(Aliases::DT_FORMAT);
        $this->result->dtUpdate = null === $this->cart->getDtUpdate()
            ? ''
            : ($this->cart->getDtUpdate())->format(Aliases::DT_FORMAT);
        $this->result->products = $this->createCartProductDto();
        $this->result->totalQuantity = $this->getTotalQuantity();
        $this->result->totalPrice = $this->totalPrice ?? 0;

        return $this;
    }

    /**
     * Обнулить builder
     *
     * @return CartResponseBuilder
     */
    public function reset(): CartResponseBuilder
    {
        $this->cart = null;
        $this->result = null;
        $this->totalPrice = null;

        return $this;
    }

    /**
     * Получить CartResponse
     *
     * @return CartResponse
     * @throws BuilderException
     */
    public function getResult(): CartResponse
    {
        if (null === $this->result) {
            throw new BuilderException(
                message: 'Не вызван метод build()',
                code: ResponseAlias::HTTP_BAD_REQUEST,
                responseCode: 'METHOD_BUILD_NOT_FOUND',
                logLevel: LogLevel::CRITICAL
            );
        }

        $result = $this->result;
        $this->reset();

        return $result;
    }

    /**
     * Добавить Cart
     *
     * @param Cart|null $cart
     * @return CartResponseBuilder
     */
    public function setCart(?Cart $cart): CartResponseBuilder
    {
        $this->cart = $cart;

        return $this;
    }

    private function getTotalQuantity(): int
    {
        $quantity = 0;

        foreach ($this->cart->getCartProducts() as $product) {
            $quantity += $product->getQuantity();
        }

        return $quantity;
    }

    /**
     * Собрать DTO CartProduct
     *
     * @return CartProduct[]
     */
    private function createCartProductDto(): array
    {
        $result = [];

        foreach ($this->cart->getCartProducts() as $cartProduct) {
            $this->totalPrice += $cartProduct->getProduct()->getPrice() * $cartProduct->getQuantity();

            $cartProductDto = new CartProduct();
            $cartProductDto->quantity = $cartProduct->getQuantity();
            $cartProductDto->id = $cartProduct->getProduct()?->getId();
            $cartProductDto->price = $cartProduct->getProduct()?->getPrice();
            $cartProductDto->title = $cartProduct->getProduct()?->getTitle();
            $cartProductDto->description = $cartProduct->getProduct()?->getDescription();
            $cartProductDto->author = $cartProduct->getProduct()?->getAuthor();
            $cartProductDto->images = SimpleResponsFactory::createImages($cartProduct->getProduct()?->getImages());
            $result[] = $cartProductDto;
        }

        return $result;
    }
}
