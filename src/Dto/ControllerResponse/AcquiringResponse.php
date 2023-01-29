<?php

namespace App\Dto\ControllerResponse;

use App\Component\Interface\Controller\ControllerResponseInterface;
use JMS\Serializer\Annotation;

class AcquiringResponse implements ControllerResponseInterface
{
    /**
     * Ссылка на оплату заказа
     *
     * @var string
     * @Annotation\Type("string")
     * @Annotation\SerializedName("paymentLink")
     */
    public string $paymentLink;
}
