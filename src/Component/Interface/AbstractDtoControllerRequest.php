<?php

namespace App\Component\Interface;

use JMS\Serializer\Annotation;

abstract class AbstractDtoControllerRequest extends AbstractDto
{
    /**
     * Сессия пользователя
     *
     * @var string
     * @Annotation\Type("string")
     * @Annotation\SerializedName("session")
     */
    public string $session;
}
