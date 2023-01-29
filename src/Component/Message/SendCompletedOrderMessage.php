<?php

namespace App\Component\Message;

class SendCompletedOrderMessage
{
    public int $orderId;

    public function __construct(int $orderId)
    {
        $this->orderId = $orderId;
    }
}