<?php

namespace App\Dto\Rabbit;

use JMS\Serializer\Annotation;

class SendTransaction
{
    /**
     * Идентификатор транзакции
     *
     * @var int
     * @Annotation\Type("integer")
     * @Annotation\SerializedName("id")
     */
    public int $id;
}
