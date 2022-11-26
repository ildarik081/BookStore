<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
#[ORM\Table(options: ['comment' => 'Товары'])]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    /** @phpstan-ignore-next-line */
    private int $id;

    #[ORM\Column(options: ['comment' => 'Стоимость товара'])]
    private ?float $price = null;

    #[ORM\Column(
        length: 255,
        options: ['comment' => 'Наименование товара']
    )]
    private string $title;

    #[ORM\Column(
        type: Types::TEXT,
        nullable: true,
        options: ['comment' => 'Описание товара']
    )]
    private ?string $description = null;

    #[ORM\Column(
        length: 180,
        nullable: true,
        options: ['comment' => 'Автор']
    )]
    private ?string $author = null;

    #[ORM\Column(
        length: 255,
        nullable: true,
        options: ['comment' => 'Ссылка на изображение товара']
    )]
    private ?string $image = null;

    #[ORM\Column(
        length: 255,
        nullable: true,
        options: ['comment' => 'Ссылка для скачивания']
    )]
    private ?string $url = null;

    /**
     * Получить идентификатор корзины
     *
     * @return integer
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Получить стоимость товара
     *
     * @return float|null
     */
    public function getPrice(): ?float
    {
        return $this->price;
    }

    /**
     * Записать стоимость товара
     *
     * @param float $price
     * @return self
     */
    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Получить наименование товара
     *
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Записать наименование товара
     *
     * @param string $title
     * @return self
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Получить описание товара
     *
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * Записать описание товара
     *
     * @param string|null $description
     * @return self
     */
    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Получить автора
     *
     * @return string|null
     */
    public function getAuthor(): ?string
    {
        return $this->author;
    }

    /**
     * Записать автора
     *
     * @param string|null $author
     * @return self
     */
    public function setAuthor(?string $author): self
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Получить ссылку на изображение товара
     *
     * @return string|null
     */
    public function getImage(): ?string
    {
        return $this->image;
    }

    /**
     * Записать ссылку на изображение товара
     *
     * @param string|null $image
     * @return self
     */
    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Получить ссылку для скачивания
     *
     * @return string|null
     */
    public function getUrl(): ?string
    {
        return $this->url;
    }

    /**
     * Записать ссылку для скачивания
     *
     * @param string|null $url
     * @return self
     */
    public function setUrl(?string $url): self
    {
        $this->url = $url;

        return $this;
    }
}
