<?php

namespace App\EventSubscriber;

use App\Component\Utils\Postman;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\TerminateEvent;

class TerminateSubscriber implements EventSubscriberInterface
{
    public function __construct()
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
            //todo отправлять шаблон в соответствии со статусом заказа
        }
    }

    public static function getSubscribedEvents(): array
    {
        return ['kernel.terminate' => 'onKernelTerminate'];
    }
}
