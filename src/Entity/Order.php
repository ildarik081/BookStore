<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use DateTimeInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Заказ
 */
#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(
    name: '`order`',
    options: ['comment' => 'Заказы']
)]
#[ORM\HasLifecycleCallbacks]
class Order
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    /** @phpstan-ignore-next-line */
    private int $id;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(
        nullable: false,
        options: ['comment' => 'Связь со статусами']
    )]
    private ?OrderStatus $status = null;

    #[ORM\Column(
        length: 40,
        options: ['comment' => 'Идентификатор сессии']
    )]
    private ?string $sessionId = null;

    #[ORM\Column(options: ['comment' => 'Итоговая стоимоть заказа'])]
    private ?float $totalPrice = null;

    #[ORM\Column(
        length: 180,
        options: ['comment' => 'Email получателя']
    )]
    private ?string $email = null;

    #[ORM\Column(
        type: Types::DATETIME_MUTABLE,
        options: ['comment' => 'Дата создания заказа']
    )]
    private ?DateTimeInterface $dtCreate = null;

    /**
     * Получить идентификатор заказа
     *
     * @return integer
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Получить статус заказа
     *
     * @return OrderStatus|null
     */
    public function getStatus(): ?OrderStatus
    {
        return $this->status;
    }

    /**
     * Записать статус заказа
     *
     * @param OrderStatus|null $status
     * @return self
     */
    public function setStatus(?OrderStatus $status): self
    {
        $this->status = $status;

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
     * Получить итоговую стоимость заказа
     *
     * @return float|null
     */
    public function getTotalPrice(): ?float
    {
        return $this->totalPrice;
    }

    /**
     * Записать итоговую стоимость заказа
     *
     * @param float $totalPrice
     * @return self
     */
    public function setTotalPrice(float $totalPrice): self
    {
        $this->totalPrice = $totalPrice;

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
     * Получить дату создания заказа
     *
     * @return DateTimeInterface|null
     */
    public function getDtCreate(): ?DateTimeInterface
    {
        return $this->dtCreate;
    }

    /**
     * Записать дату создания заказа
     *
     * @param DateTimeInterface $dtCreate
     * @return self
     */
    #[ORM\PrePersist]
    public function setDtCreate(DateTimeInterface $dtCreate): self
    {
        $this->dtCreate = $dtCreate;

        return $this;
    }
}
