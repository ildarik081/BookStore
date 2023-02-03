<?php

namespace App\Entity;

use App\Component\Interface\Controller\ControllerResponseInterface;
use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Товар
 */
#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue('IDENTITY')]
    #[
        ORM\Column(
            type: Types::INTEGER,
            nullable: false,
            options: ['comment' => 'Идентификатор товара']
        )
    ]
    private ?int $id = null;

    #[
        ORM\Column(
            type: Types::FLOAT,
            nullable: false,
            options: ['comment' => 'Стоимость товара']
        )
    ]
    private ?float $price = null;

    #[
        ORM\Column(
            type: Types::STRING,
            length: 255,
            nullable: false,
            options: ['comment' => 'Наименование товара']
        )
    ]
    private string $title;

    #[
        ORM\Column(
            type: Types::TEXT,
            nullable: true,
            options: ['comment' => 'Описание товара']
        )
    ]
    private ?string $description = null;

    #[
        ORM\Column(
            type: Types::STRING,
            length: 180,
            nullable: true,
            options: ['comment' => 'Автор']
        )
    ]
    private ?string $author = null;

    #[
        ORM\Column(
            type: Types::STRING,
            length: 255,
            nullable: false,
            options: ['comment' => 'Ссылка для скачивания']
        )
    ]
    private ?string $url = null;

    #[
        ORM\OneToMany(
            mappedBy: 'product',
            targetEntity: Image::class,
            cascade: ['persist', 'remove']
        )
    ]
    private Collection $images;

    public function __construct()
    {
        $this->images = new ArrayCollection();
    }

    /**
     * Получить идентификатор товара
     *
     * @return integer|null
     */
    public function getId(): ?int
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
     * @return string|null
     */
    public function getTitle(): ?string
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
     * @param string $url
     * @return self
     */
    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Получить коллекцию изображений товара
     *
     * @return Collection<int, Image>
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    /**
     * Добавить изображение
     *
     * @param Image $image
     * @return self
     */
    public function addImage(Image $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images->add($image);
            $image->setProduct($this);
        }

        return $this;
    }

    /**
     * Удалить изображение
     *
     * @param Image $image
     * @return self
     */
    public function removeImage(Image $image): self
    {
        if ($this->images->removeElement($image)) {
            if ($image->getProduct() === $this) {
                $image->setProduct(null);
            }
        }

        return $this;
    }
}
