<?php

namespace App\Entity;

use App\Component\Interfaces\ProductInterface;
use App\Repository\CartProductRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Товары в корзине
 */
#[ORM\Entity(repositoryClass: CartProductRepository::class)]
class CartProduct implements ProductInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue('IDENTITY')]
    #[
        ORM\Column(
            type: Types::INTEGER,
            nullable: false,
            options: ['comment' => 'Идентификатор товара в корзине']
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
            inversedBy: 'cartProducts',
            cascade: ['persist']
        )
    ]
    private ?Product $product = null;

    #[
        ORM\ManyToOne(
            inversedBy: 'cartProducts',
            cascade: ['persist']
        )
    ]
    private ?Cart $cart = null;

    /**
     * Получить идентификатор товара в корзине
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
    public function getQuantity(): int
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

    /**
     * Получить корзину
     *
     * @return Cart|null
     */
    public function getCart(): ?Cart
    {
        return $this->cart;
    }

    /**
     * Записать корзину
     *
     * @param Cart|null $cart
     * @return self
     */
    public function setCart(?Cart $cart): self
    {
        $this->cart = $cart;

        return $this;
    }
}
