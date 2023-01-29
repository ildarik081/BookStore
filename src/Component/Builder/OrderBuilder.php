<?php

namespace App\Component\Builder;

use App\Component\Exception\BuilderException;
use App\Component\Factory\EntityFactory;
use App\Component\Utils\ProductUtils;
use App\Dto\ControllerRequest\CheckoutRequest;
use App\Entity\Cart;
use App\Entity\Order;
use Psr\Log\LogLevel;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class OrderBuilder implements BuilderInterface
{
    private ?Cart $cart = null;
    private ?CheckoutRequest $checkoutRequest = null;
    private ?Order $order = null;

    /**
     * Собрать заказ
     *
     * @return OrderBuilder
     */
    public function build(): OrderBuilder
    {
        $this->order = new Order();
        $this->order
            ->setSessionId($this->cart->getSessionId())
            ->setTotalPrice(ProductUtils::calculationTotalPrice($this->cart->getCartProducts()))
            ->setRecipient(
                EntityFactory::createRecipient($this->checkoutRequest->firstName, $this->checkoutRequest->email)
            )
            ->setPaymentTypeCode($this->checkoutRequest->paymentType)
        ;

        return $this;
    }

    /**
     * Обнулить builder
     *
     * @return OrderBuilder
     */
    public function reset(): OrderBuilder
    {
        $this->cart = null;
        $this->checkoutRequest = null;
        $this->order = null;

        return $this;
    }

    /**
     * Получить Order
     *
     * @return Order
     * @throws BuilderException
     */
    public function getResult(): Order
    {
        if (null === $this->order) {
            throw new BuilderException(
                message: 'Не вызван метод build()',
                code: ResponseAlias::HTTP_BAD_REQUEST,
                responseCode: 'METHOD_BUILD_NOT_FOUND',
                logLevel: LogLevel::CRITICAL
            );
        }

        $result = $this->order;
        $this->reset();

        return $result;
    }

    /**
     * Добавить Cart
     *
     * @param Cart|null $cart
     * @return OrderBuilder
     */
    public function setCart(?Cart $cart): OrderBuilder
    {
        $this->cart = $cart;

        return $this;
    }

    /**
     * Добавить CheckoutRequest
     *
     * @param CheckoutRequest|null $request
     * @return OrderBuilder
     */
    public function setCheckoutRequest(?CheckoutRequest $request): OrderBuilder
    {
        $this->checkoutRequest = $request;

        return $this;
    }
}
