<?php

namespace App\Component\Handler;

use App\Component\Factory\EntityFactory;
use App\Component\Mailer\OrderStatusMailer;
use App\Component\Message\SendCompletedOrderMessage;
use App\Component\Utils\Enum\CheckTypeEnum;
use App\Component\Utils\Enum\OrderStatusEnum;
use App\Entity\Transaction;
use App\Repository\CheckTypeRepository;
use App\Repository\OrderRepository;
use App\Repository\OrderStatusRepository;
use App\Repository\PaymentCheckRepository;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class CompletedOrderHandler implements MessageHandlerInterface
{
    public function __construct(
        private readonly PaymentCheckRepository $paymentCheckRepository,
        private readonly OrderStatusRepository $orderStatusRepository,
        private readonly OrderRepository $orderRepository,
        private readonly CheckTypeRepository $checkTypeRepository,
        private readonly OrderStatusMailer $orderStatusMailer
    ) {
    }

    public function __invoke(SendCompletedOrderMessage $message)
    {
        $order = $this->orderRepository->find($message->getOrderId());

        /** @var Transaction $transaction */
        $transaction = $order
            ->getTransaction()
            ?->filter(function (Transaction $transaction) {
                return null !== $transaction->getPayment();
            })
            ->first()
        ;

        $checkType = $this->checkTypeRepository->getCheckTypeByCode(CheckTypeEnum::FullSettlement->value);
        $paymentCheck = EntityFactory::createPaymentCheck($transaction->getPayment(), $checkType);
        $this->paymentCheckRepository->save($paymentCheck, true);

        $orderStatus = $this->orderStatusRepository->getOrderStatusByCode(OrderStatusEnum::Completed->value);
        $historyOrderStatus = EntityFactory::createHistoryOrderStatus($orderStatus);
        $order->addHistoryOrderStatus($historyOrderStatus);
        $this->orderRepository->save($transaction->getOrder(), true);

        $this->orderStatusMailer->sendNotify($historyOrderStatus);
    }
}
