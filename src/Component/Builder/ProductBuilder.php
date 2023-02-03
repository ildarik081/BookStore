<?php

namespace App\Component\Builder;

use App\Component\Exception\BuilderException;
use App\Entity\Image;
use App\Entity\Product;
use Psr\Log\LogLevel;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class ProductBuilder implements BuilderInterface
{
    private ?Product $existProduct = null;
    private ?Product $result = null;
    private ?float $price = null;
    private ?string $title = null;
    private ?string $description = null;
    private ?string $author = null;
    private ?array $images = null;
    private ?string $url = null;

    /**
     * Собрать Product
     *
     * @return ProductBuilder
     */
    public function build(): ProductBuilder
    {
        if (null === $this->existProduct) {
            $this->result = new Product();
        } else {
            $this->result = $this->existProduct;
        }

        $this->result
            ->setPrice($this->price)
            ->setTitle($this->title)
            ->setDescription($this->description)
            ->setAuthor($this->author)
            ->setUrl($this->url);

        /** @var Image $image */
        foreach ($this->images as $image) {
            $this->result->addImage($image);
        }

        return $this;
    }

    /**
     * Обнулить builder
     *
     * @return ProductBuilder
     */
    public function reset(): ProductBuilder
    {
        $this->existProduct = null;
        $this->result = null;
        $this->price = null;
        $this->title = null;
        $this->description = null;
        $this->author = null;
        $this->images = null;
        $this->url = null;

        return $this;
    }

    /**
     * Получить Product
     *
     * @return Product
     * @throws BuilderException
     */
    public function getResult(): Product
    {
        if (null === $this->result) {
            throw new BuilderException(
                message: 'Не вызван метод build()',
                code: ResponseAlias::HTTP_BAD_REQUEST,
                responseCode: 'METHOD_BUILD_NOT_FOUND',
                logLevel: LogLevel::CRITICAL
            );
        }

        $result = $this->result;
        $this->reset();

        return $result;
    }

    /**
     * Добавить Product
     *
     * @param Product|null $product
     * @return ProductBuilder
     */
    public function setExistProduct(?Product $product): ProductBuilder
    {
        $this->existProduct = $product;

        return $this;
    }

    /**
     * Добавить цену
     *
     * @param float|null $price
     * @return ProductBuilder
     */
    public function setPrice(?float $price): ProductBuilder
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Добавить название
     *
     * @param string|null $title
     * @return ProductBuilder
     */
    public function setTitle(?string $title): ProductBuilder
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Добавить описание
     *
     * @param string|null $description
     * @return ProductBuilder
     */
    public function setDescription(?string $description): ProductBuilder
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Добавить автора
     *
     * @param string|null $author
     * @return ProductBuilder
     */
    public function setAuthor(?string $author): ProductBuilder
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Добавить изображения
     *
     * @param Image[]|null $images
     * @return ProductBuilder
     */
    public function setImage(?array $images): ProductBuilder
    {
        $this->images = $images;

        return $this;
    }

    /**
     * Добавить ссылку для скачивания
     *
     * @param string|null $url
     * @return ProductBuilder
     */
    public function setUrl(?string $url): ProductBuilder
    {
        $this->url = $url;

        return $this;
    }
}
