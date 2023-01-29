<?php

namespace App\EventSubscriber;

use App\Component\Mailer\OrderStatusMailer;
use App\Component\Utils\Postman;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\TerminateEvent;

class TerminateSubscriber implements EventSubscriberInterface
{
    public function __construct(private readonly OrderStatusMailer $orderStatusMailer)
    {
    }

    /**
     * @param TerminateEvent $event
     * @return void
     */
    public function onKernelTerminate(TerminateEvent $event): void
    {
        $historyOrderStatus = Postman::getInstance()->getHistoryOrderStatus();

        if (null !== $historyOrderStatus) {
            $this->orderStatusMailer->sendNotify($historyOrderStatus);
        }
    }

    public static function getSubscribedEvents(): array
    {
        return ['kernel.terminate' => 'onKernelTerminate'];
    }
}
