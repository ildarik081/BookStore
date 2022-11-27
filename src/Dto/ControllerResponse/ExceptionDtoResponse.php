<?php

namespace App\Dto\ControllerResponse;

use App\Component\Interface\Controller\ControllerResponseInterface;
use JMS\Serializer\Annotation;

class ExceptionDtoResponse implements ControllerResponseInterface
{
    /**
     * @var string
     * @Annotation\Type("string")
     */
    public string $code;

    /**
     * @var string
     * @Annotation\Type("string")
     */
    public string $message;
}
