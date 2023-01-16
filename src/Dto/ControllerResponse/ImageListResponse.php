<?php

namespace App\Dto\ControllerResponse;

use App\Component\Interface\Controller\ControllerResponseInterface;
use App\Dto\Image;
use JMS\Serializer\Annotation;

class ImageListResponse implements ControllerResponseInterface
{
    /**
     * Изображения
     *
     * @var Image[]
     * @Annotation\Type("array<App\Dto\Image>")
     * @Annotation\SerializedName("images")
     */
    public array $images = [];
}
