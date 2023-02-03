<?php

namespace App\Component\Message;

class SendTransactionMessage
{
    private int $transactionId;

    public function __construct(int $transactionId)
    {
        $this->transactionId = $transactionId;
    }

    public function getTransactionId(): int
    {
        return $this->transactionId;
    }
}
