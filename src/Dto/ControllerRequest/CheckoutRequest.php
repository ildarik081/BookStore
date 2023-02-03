<?php

namespace App\Dto\ControllerRequest;

use App\Component\Interface\AbstractDtoControllerRequest;
use JMS\Serializer\Annotation;
use Symfony\Component\Validator\Constraints as Assert;

class CheckoutRequest extends AbstractDtoControllerRequest
{
    /**
     * Имя покупателя
     *
     * @var string
     * @Annotation\Type("string")
     * @Annotation\SerializedName("firstName")
     */
    #[Assert\NotBlank(message: 'Имя покупателя является обязательным')]
    public string $firstName;

    /**
     * Email покупателя
     *
     * @var string
     * @Annotation\Type("string")
     * @Annotation\SerializedName("email")
     */
    #[Assert\NotBlank(message: 'Email является обязательным')]
    #[Assert\Email(message: 'Не верный формат email')]
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
    #[Assert\NotBlank(message: 'Требуется указать тип оплаты')]
    public string $paymentType;
}
