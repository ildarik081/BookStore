<?php

namespace App\Dto\ControllerRequest;

use App\Component\Interface\AbstractDtoControllerRequest;
use JMS\Serializer\Annotation;

class CheckoutRequest extends AbstractDtoControllerRequest
{
    /**
     * Имя покупателя
     *
     * @var string
     * @Annotation\Type("string")
     * @Annotation\SerializedName("firstName")
     */
    public string $firstName;

    /**
     * Email покупателя
     *
     * @var string
     * @Annotation\Type("string")
     * @Annotation\SerializedName("email")
     */
    public string $email;

    /**
     * Тип оплаты
     *
     * - card — банковской картой
     * - sbp — СБП
     *
     * @var string
     * @Annotation\Type("string")
     * @Annotation\SerializedName("paymentType")
     */
    public string $paymentType;
}
