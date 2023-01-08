<?php

namespace App\Dto;

use App\Component\Interface\Controller\ControllerResponseInterface;
use JMS\Serializer\Annotation;

class Product implements ControllerResponseInterface
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
     * @var string|null
     * @Annotation\Type("string")
     * @Annotation\SerializedName("image")
     */
    public ?string $image = null;

    /**
     * Ссылка для скачивания
     *
     * @var string|null
     * @Annotation\Type("string")
     * @Annotation\SerializedName("url")
     */
    public ?string $url = null;
}
