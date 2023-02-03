<?php

namespace App\Dto\ControllerRequest;

use JMS\Serializer\Annotation;
use App\Component\Interface\AbstractDtoControllerRequest;
use App\Dto\Image;
use Symfony\Component\Validator\Constraints as Assert;

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
    #[Assert\NotBlank(message: 'Параметр price является обязательным')]
    public ?float $price = null;

    /**
     * Наименование товара
     *
     * @var string|null
     * @Annotation\Type("string")
     * @Annotation\SerializedName("title")
     */
    #[Assert\NotBlank(message: 'Параметр title является обязательным')]
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
     * @Annotation\Type("array<App\Dto\Image>")
     * @Annotation\SerializedName("images")
     */
    public array $images = [];

    /**
     * Ссылка для скачивания
     *
     * @var string|null
     * @Annotation\Type("string")
     * @Annotation\SerializedName("url")
     */
    #[Assert\NotBlank(message: 'Параметр url является обязательным')]
    public ?string $url = null;
}
