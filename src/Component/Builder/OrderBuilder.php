<?php

namespace App\Component\Builder;

use App\Component\Exception\BuilderException;
use App\Component\Factory\SimpleResponseFactory;
use App\Component\Utils\Aliases;
use App\Dto\CartProduct;
use App\Dto\ControllerResponse\CartResponse;
use App\Entity\Cart;
use Psr\Log\LogLevel;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

// class OrderBuilder implements BuilderInterface
// {
//     // /**
//     //  * Собрать заказ
//     //  *
//     //  * @return OrderBuilder
//     //  */
//     // public function build(): OrderBuilder
//     // {
        

//     //     return $this;
//     // }

//     // /**
//     //  * Обнулить builder
//     //  *
//     //  * @return OrderBuilder
//     //  */
//     // public function reset(): OrderBuilder
//     // {
//     //     $this->cart = null;
//     //     $this->result = null;
//     //     $this->totalPrice = null;

//     //     return $this;
//     // }

//     // /**
//     //  * Получить CartResponse
//     //  *
//     //  * @return CartResponse
//     //  * @throws BuilderException
//     //  */
//     // public function getResult(): CartResponse
//     // {
//     //     if (null === $this->result) {
//     //         throw new BuilderException(
//     //             message: 'Не вызван метод build()',
//     //             code: ResponseAlias::HTTP_BAD_REQUEST,
//     //             responseCode: 'METHOD_BUILD_NOT_FOUND',
//     //             logLevel: LogLevel::CRITICAL
//     //         );
//     //     }

//     //     $result = $this->result;
//     //     $this->reset();

//     //     return $result;
//     // }

//     // /**
//     //  * Добавить Cart
//     //  *
//     //  * @param Cart|null $cart
//     //  * @return OrderBuilder
//     //  */
//     // public function setCart(?Cart $cart): OrderBuilder
//     // {
//     //     $this->cart = $cart;

//     //     return $this;
//     // }
// }
