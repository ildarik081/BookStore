<?php

namespace App\Component\Handler;

use App\Component\Factory\EntityFactory;
use App\Component\Message\SendTransactionMessage;
use App\Component\Utils\Enum\CheckTypeEnum;
use App\Repository\CheckTypeRepository;
use App\Repository\PaymentCheckRepository;
use App\Repository\PaymentTypeRepository;
use App\Repository\TransactionRepository;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class SendTransactionHandler implements MessageHandlerInterface
{
    public function __construct(
        private readonly TransactionRepository $transactionRepository,
        private readonly PaymentTypeRepository $paymentTypeRepository,
        private readonly PaymentCheckRepository $paymentCheckRepository,
        private readonly CheckTypeRepository $checkTypeRepository
    ) {
    }

    public function __invoke(SendTransactionMessage $message)
    {
        $transaction = $this->transactionRepository->find($message->transactionId);
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

        //todo собрать чек
        //todo и написать сообщение о том что можно написать комманд, который будет фискализовать чеки
        //todo тут нужно будет запустить отправку сообщения на почту
        //todo а тот в свою очередь будет генерить чек полного расчета
    }
}
