<?php

namespace App\Component\Message;

class SendTransactionMessage
{
    public int $transactionId;

    public function __construct(int $transactionId)
    {
        $this->transactionId = $transactionId;
    }
}