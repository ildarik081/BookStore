<?php

namespace App\Entity;

use App\Repository\CartRepository;
use DateTime;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Корзина
 */
#[ORM\Entity(repositoryClass: CartRepository::class)]
#[ORM\Table(options: ['comment' => 'Корзины пользователей'])]
#[ORM\HasLifecycleCallbacks]
class Cart
{
    #[ORM\Id]
    #[ORM\GeneratedValue('IDENTITY')]
    #[
        ORM\Column(
            type: Types::INTEGER,
            nullable: false,
            options: ['comment' => 'Идентификатор корзины']
        )
    ]
    private ?int $id = null;

    #[
        ORM\Column(
            type: Types::STRING,
            nullable: false,
            length: 40,
            options: ['comment' => 'Идентификатор сессии']
        )
    ]
    private ?string $sessionId = null;

    #[
        ORM\Column(
            type: Types::DATETIME_MUTABLE,
            nullable: false,
            options: ['comment' => 'Дата создания корзины']
        )
    ]
    private ?DateTimeInterface $dtCreate = null;

    #[
        ORM\Column(
            type: Types::DATETIME_MUTABLE,
            nullable: false,
            options: ['comment' => 'Дата обновления корзины']
        )
    ]
    private ?DateTimeInterface $dtUpdate = null;

    #[ 
        ORM\OneToMany(
            mappedBy: 'cart',
            targetEntity: CartProduct::class,
            cascade: ['persist', 'remove']
        )
    ]
    private Collection $cartProducts;

    public function __construct()
    {
        $this->cartProducts = new ArrayCollection();
    }

    /**
     * Получить идентификатор корзины
     *
     * @return integer|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Получить идентификатор сессии
     *
     * @return string|null
     */
    public function getSessionId(): ?string
    {
        return $this->sessionId;
    }

    /**
     * Записать идентификатор сессии
     *
     * @param string $sessionId
     * @return self
     */
    public function setSessionId(string $sessionId): self
    {
        $this->sessionId = $sessionId;

        return $this;
    }

    /**
     * Получить дату создания корзины
     *
     * @return DateTimeInterface|null
     */
    public function getDtCreate(): ?DateTimeInterface
    {
        return $this->dtCreate;
    }

    /**
     * Записать дату создания корзины
     *
     * @return self
     */
    #[ORM\PrePersist]
    public function setDtCreate(): self
    {
        $this->dtCreate = new DateTime();

        return $this;
    }

    /**
     * Получить дату обновления корзины
     *
     * @return DateTimeInterface|null
     */
    public function getDtUpdate(): ?DateTimeInterface
    {
        return $this->dtUpdate;
    }

    /**
     * Записать дату обновления корзины
     *
     * @return self
     */
    #[ORM\PreFlush]
    public function setDtUpdate(): self
    {
        $this->dtUpdate = new DateTime();

        return $this;
    }

    /**
     * Получить массив товаров в корзине
     *
     * @return Collection
     */
    public function getCartProducts(): Collection
    {
        return $this->cartProducts;
    }

    /**
     * Добавить товар в корзину
     *
     * @param CartProduct $cartProduct
     * @return self
     */
    public function addCartProduct(CartProduct $cartProduct): self
    {
        if (!$this->cartProducts->contains($cartProduct)) {
            $this->cartProducts->add($cartProduct);
            $cartProduct->setCart($this);
        }

        return $this;
    }

    /**
     * Удалить товар из корзины
     *
     * @param CartProduct $cartProduct
     * @return self
     */
    public function removeCartProduct(CartProduct $cartProduct): self
    {
        if ($this->cartProducts->removeElement($cartProduct)) {
            if ($cartProduct->getCart() === $this) {
                $cartProduct->setCart(null);
            }
        }

        return $this;
    }
}
