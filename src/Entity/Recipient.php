<?php

namespace App\Entity;

use App\Repository\RecipientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Получатели
 */
#[ORM\Entity(repositoryClass: RecipientRepository::class)]
#[ORM\Table(options: ['comment' => 'Получатели'])]
class Recipient
{
    #[ORM\Id]
    #[ORM\GeneratedValue('IDENTITY')]
    #[
        ORM\Column(
            type: Types::INTEGER,
            nullable: false,
            options: ['comment' => 'Идентификатор получателя']
        )
    ]
    private ?int $id = null;

    #[
        ORM\Column(
            type: Types::STRING,
            length: 60,
            nullable: false,
            options: ['comment' => 'Имя получателя']
        )
    ]
    private ?string $firstName = null;

    #[
        ORM\Column(
            type: Types::STRING,
            length: 120,
            nullable: false,
            options: ['comment' => 'Email получателя']
        )
    ]
    private ?string $email = null;

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
        ORM\OneToMany(
            mappedBy: 'recipient',
            targetEntity: Order::class,
            cascade: ['persist', 'remove']
        )
    ]
    private Collection $orders;

    public function __construct()
    {
        $this->orders = new ArrayCollection();
    }

    /**
     * Получить идентификатор получателя
     *
     * @return integer|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Получить имя получателя
     *
     * @return string|null
     */
    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    /**
     * Записать имя получателя
     *
     * @param string $firstName
     * @return self
     */
    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Получить email получателя
     *
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * Записать email получателя
     *
     * @param string $email
     * @return self
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
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
     * Получить все заказы получателя
     *
     * @return Collection<int, Order>
     */
    public function getOrders(): Collection
    {
        return $this->orders;
    }

    /**
     * Добавить заказ получателю
     *
     * @param Order $order
     * @return self
     */
    public function addOrder(Order $order): self
    {
        if (!$this->orders->contains($order)) {
            $this->orders->add($order);
            $order->setRecipient($this);
        }

        return $this;
    }

    /**
     * Удалить заказ получателя
     *
     * @param Order $order
     * @return self
     */
    public function removeOrder(Order $order): self
    {
        if ($this->orders->removeElement($order)) {
            if ($order->getRecipient() === $this) {
                $order->setRecipient(null);
            }
        }

        return $this;
    }
}
