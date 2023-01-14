<?php

namespace App\Dto\ControllerRequest;

use JMS\Serializer\Annotation;
use App\Component\Interface\AbstractDtoControllerRequest;
use App\Dto\Image;

class ProductRequest extends AbstractDtoControllerRequest
{
    /**
     * Идентификатор товара
     *
     * @var int|null
     * @Annotation\Type("integer")
     * @Annotation\SerializedName("id")
     */
    public ?int $id = null;

    /**
     * Стоимость товара
     *
     * @var float|null
     * @Annotation\Type("float")
     * @Annotation\SerializedName("price")
     */
    public ?float $price = null;

    /**
     * Наименование товара
     *
     * @var string|null
     * @Annotation\Type("string")
     * @Annotation\SerializedName("title")
     */
    public ?string $title = null;

    /**
     * Описание товара
     *
     * @var string|null
     * @Annotation\Type("string")
     * @Annotation\SerializedName("description")
     */
    public ?string $description = null;

    /**
     * Автор
     *
     * @var string|null
     * @Annotation\Type("string")
     * @Annotation\SerializedName("author")
     */
    public ?string $author = null;

    /**
     * Ссылка на изображение товара
     *
     * @var Image[]
     * @Annotation\Type("array")
     * @Annotation\SerializedName("array<App\Dto\Image>")
     */
    public array $image = [];

    /**
     * Ссылка для скачивания
     *
     * @var string|null
     * @Annotation\Type("string")
     * @Annotation\SerializedName("url")
     */
    public ?string $url = null;
}
