<?php

namespace App\Service;

use App\Component\Factory\SimpleResponseFactory;
use App\Component\Utils\Aliases;
use App\Component\Utils\ProductUtils;
use App\Dto\ControllerRequest\CheckoutRequest;
use App\Dto\ControllerResponse\SuccessResponse;
use App\Entity\HistoryOrderStatus;
use App\Entity\Order;
use App\Entity\OrderProduct;
use App\Entity\Recipient;
use App\Repository\CartRepository;
use App\Repository\OrderProductRepository;
use App\Repository\OrderRepository;
use App\Repository\OrderStatusRepository;
use Psr\Log\LogLevel;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class OrderService
{
    public function __construct(
        private readonly OrderRepository $orderRepository,
        private readonly OrderStatusRepository $orderStatusRepository,
        private readonly OrderProductRepository $orderProductRepository,
        private readonly CartRepository $cartRepository
    ) {
    }

    public function checkout(CheckoutRequest $request): SuccessResponse
    {
        $cart = $this->cartRepository->getCartBySessionId($request->session, true);

        $recipient = new Recipient();
        $recipient
            ->setFirstName($request->firstName)
            ->setEmail($request->email)
        ;

        $order = new Order();
        $order
            ->setSessionId($cart->getSessionId())
            ->setTotalPrice(ProductUtils::calculationTotalPrice($cart->getCartProducts()))
            ->setRecipient($recipient)
        ;

        $orderStatus = $this->orderStatusRepository->getOrderStatusByCode(Aliases::ORDER_STATUSES['new']['code']);

        $historyOrderStatus = new HistoryOrderStatus();
        $historyOrderStatus
            ->setStatus($orderStatus)
            ->setOrder($order)
        ;

        $this->orderRepository->save($order, true);

        foreach ($cart->getCartProducts() as $cartProduct) {
            $orderProduct = new OrderProduct();
            $orderProduct
                ->setProduct($cartProduct->getProduct())
                ->setOrder($order)
                ->setQuantity($cartProduct->getQuantity())
            ;

            $this->orderProductRepository->save($orderProduct);
        }

        $this->orderProductRepository->save($orderProduct, true);

        //! Удалить Payment и создать транзакции которые порождают оплаты
        //! Будет создаваться фиктивная транзакция, которая будет класться в очередь и переводиться в статус оплаченной
        //! После этого будет создаваться оплата и отправляться сообщение на почту через очередь


        return SimpleResponseFactory::createSuccessResponse(true);
    }   
}
