<?php

namespace App\Entity;

use App\Repository\CartProductRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * Товары в корзине
 */
#[ORM\Entity(repositoryClass: CartProductRepository::class)]
#[ORM\Table(options: ['comment' => 'Товары в корзине'])]
class CartProduct
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    /** @phpstan-ignore-next-line */
    private int $id;

    #[ORM\ManyToOne(inversedBy: 'cartProducts')]
    private ?Product $product = null;

    #[ORM\ManyToOne(inversedBy: 'cartProducts')]
    private ?Cart $cart = null;

    #[ORM\Column(options: ['comment' => 'Количество товаров'])]
    private ?int $quantity = null;

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

    /**
     * Получить количество товаров
     *
     * @return integer|null
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
}
