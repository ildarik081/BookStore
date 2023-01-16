<?php

namespace App\Entity;

use App\Repository\OrderProductRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Товары в заказе
 */
#[ORM\Entity(repositoryClass: OrderProductRepository::class)]
#[ORM\Table(options: ['comment' => 'Товары в заказе'])]
class OrderProduct
{
    #[ORM\Id]
    #[ORM\GeneratedValue('IDENTITY')]
    #[
        ORM\Column(
            type: Types::INTEGER,
            nullable: false,
            options: ['comment' => 'Идентификатор товара в заказе']
        )
    ]
    private ?int $id = null;

    #[
        ORM\Column(
            nullable: false,
            options: [
                'comment' => 'Количество товаров',
                'default' => 0
            ]
        )
    ]
    private int $quantity = 0;

    #[
        ORM\ManyToOne(
            cascade: ['persist']
        )
    ]
    private ?Product $product = null;

    #[ORM\ManyToOne(inversedBy: 'orderProduct')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Order $order = null;

    /**
     * Получить идентификатор товара в заказе
     *
     * @return integer|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Получить количество товаров
     *
     * @return integer
     */
    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    /**
     * Записать количество товаров
     *
     * @param integer $quantity
     * @return self
     */
    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Получить товар
     *
     * @return Product|null
     */
    public function getProduct(): ?Product
    {
        return $this->product;
    }

    /**
     * Записать товар
     *
     * @param Product|null $product
     * @return self
     */
    public function setProduct(?Product $product): self
    {
        $this->product = $product;

        return $this;
    }

    public function getOrder(): ?Order
    {
        return $this->order;
    }

    public function setOrder(?Order $order): self
    {
        $this->order = $order;

        return $this;
    }
}
