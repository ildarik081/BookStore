<?php

namespace App\Dto\ControllerResponse;

use App\Component\Interface\Controller\ControllerResponseInterface;
use JMS\Serializer\Annotation;

class SuccessResponse implements ControllerResponseInterface
{
    /**
     * Статус
     *
     * @var bool
     * @Annotation\Type("boolean")
     * @Annotation\SerializedName("success")
     */
    public bool $success = false;
}
