<?php

namespace App\Component\Handler;

use App\Component\Factory\EntityFactory;
use App\Component\Mailer\OrderStatusMailer;
use App\Component\Message\SendCompletedOrderMessage;
use App\Component\Message\SendTransactionMessage;
use App\Component\Utils\Enum\CheckTypeEnum;
use App\Component\Utils\Enum\OrderStatusEnum;
use App\Repository\CheckTypeRepository;
use App\Repository\OrderRepository;
use App\Repository\OrderStatusRepository;
use App\Repository\PaymentCheckRepository;
use App\Repository\PaymentTypeRepository;
use App\Repository\TransactionRepository;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class TransactionHandler implements MessageHandlerInterface
{
    public function __construct(
        private readonly TransactionRepository $transactionRepository,
        private readonly PaymentTypeRepository $paymentTypeRepository,
        private readonly PaymentCheckRepository $paymentCheckRepository,
        private readonly OrderStatusRepository $orderStatusRepository,
        private readonly OrderRepository $orderRepository,
        private readonly CheckTypeRepository $checkTypeRepository,
        private readonly OrderStatusMailer $orderStatusMailer,
        private readonly MessageBusInterface $bus
    ) {
    }

    public function __invoke(SendTransactionMessage $message)
    {
        $transaction = $this->transactionRepository->find($message->getTransactionId());
        $transaction->setIsActive(false);

        $paymentType = $this
            ->paymentTypeRepository
            ->getPaymentTypeByCode($transaction->getOrder()?->getPaymentTypeCode())
        ;

        $payment = EntityFactory::createPayment($paymentType, $transaction->getOrder()?->getTotalPrice() ?? 0.0);
        $transaction->setPayment($payment);

        $this->transactionRepository->save($transaction, true);

        $checkType = $this->checkTypeRepository->getCheckTypeByCode(CheckTypeEnum::Advance->value);
        $paymentCheck = EntityFactory::createPaymentCheck($payment, $checkType);
        $this->paymentCheckRepository->save($paymentCheck, true);

        $orderStatus = $this->orderStatusRepository->getOrderStatusByCode(OrderStatusEnum::InWork->value);
        $historyOrderStatus = EntityFactory::createHistoryOrderStatus($orderStatus);
        $transaction->getOrder()?->addHistoryOrderStatus($historyOrderStatus);
        $this->orderRepository->save($transaction->getOrder(), true);

        $this->orderStatusMailer->sendNotify($historyOrderStatus);

        $this->bus->dispatch(new SendCompletedOrderMessage($transaction->getOrder()?->getId()));
    }
}
