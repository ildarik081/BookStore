<?php

namespace App\Component\Builder;

use App\Component\Exception\BuilderException;
use App\Component\Factory\SimpleResponseFactory;
use App\Component\Utils\Aliases;
use App\Component\Utils\ProductUtils;
use App\Dto\CartProduct;
use App\Dto\ControllerResponse\CartResponse;
use App\Entity\Cart;
use Psr\Log\LogLevel;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class CartResponseBuilder implements BuilderInterface
{
    private ?Cart $cart = null;
    private ?CartResponse $result = null;

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
        $this->result->totalQuantity = ProductUtils::calculationTotalQuantity($this->cart->getCartProducts());
        $this->result->totalPrice = ProductUtils::calculationTotalPrice($this->cart->getCartProducts());

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

    /**
     * Собрать DTO CartProduct
     *
     * @return CartProduct[]
     */
    private function createCartProductDto(): array
    {
        $result = [];

        foreach ($this->cart->getCartProducts() as $cartProduct) {
            $cartProductDto = new CartProduct();
            $cartProductDto->quantity = $cartProduct->getQuantity();
            $cartProductDto->id = $cartProduct->getProduct()?->getId();
            $cartProductDto->price = $cartProduct->getProduct()?->getPrice();
            $cartProductDto->title = $cartProduct->getProduct()?->getTitle();
            $cartProductDto->description = $cartProduct->getProduct()?->getDescription();
            $cartProductDto->author = $cartProduct->getProduct()?->getAuthor();
            $cartProductDto->images = SimpleResponseFactory::createImagesFromCollection(
                $cartProduct->getProduct()?->getImages()
            );
            $result[] = $cartProductDto;
        }

        return $result;
    }
}
