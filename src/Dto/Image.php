<?php

namespace App\Dto;

use JMS\Serializer\Annotation;

class Image
{
    /**
     * Идентификатор изображения
     *
     * @var int|null
     * @Annotation\Type("integer")
     * @Annotation\SerializedName("id")
     */
    public ?int $id = null;

    /**
     * Наименование файла изображения
     *
     * @var string|null
     * @Annotation\Type("string")
     * @Annotation\SerializedName("fileName")
     */
    public ?string $fileName = null;

    /**
     * Путь до изображения
     *
     * @var string|null
     * @Annotation\Type("string")
     * @Annotation\SerializedName("path")
     */
    public ?string $path = null;

    /**
     * Описание к изображению
     *
     * @var string|null
     * @Annotation\Type("string")
     * @Annotation\SerializedName("description")
     */
    public ?string $description = null;
}
