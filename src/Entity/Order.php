<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use DateTime;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Заказ
 */
#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Order
{
    #[ORM\Id]
    #[ORM\GeneratedValue('IDENTITY')]
    #[
        ORM\Column(
            type: Types::INTEGER,
            nullable: false,
            options: ['comment' => 'Идентификатор заказа']
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
            type: Types::FLOAT,
            nullable: false,
            options: [
                'comment' => 'Итоговая стоимость заказа',
                'default' => 0
            ]
        )
    ]
    private ?float $totalPrice = null;

    #[
        ORM\Column(
            type: Types::DATETIME_MUTABLE,
            nullable: false,
            options: ['comment' => 'Дата/время создания заказа']
        )
    ]
    private ?DateTimeInterface $dtCreate = null;

    #[
        ORM\OneToMany(
            mappedBy: 'order',
            targetEntity: HistoryOrderStatus::class,
            cascade: ['persist'],
            orphanRemoval: true
        )
    ]
    private Collection $historyOrderStatus;

    #[
        ORM\OneToMany(
            mappedBy: 'order',
            cascade: ['persist'],
            targetEntity: OrderProduct::class
        )
    ]
    private Collection $orderProduct;

    #[ORM\ManyToOne(inversedBy: 'orders')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Recipient $recipient = null;

    #[ORM\OneToMany(mappedBy: 'order', targetEntity: Transaction::class)]
    private Collection $transaction;

    public function __construct()
    {
        $this->historyOrderStatus = new ArrayCollection();
        $this->orderProduct = new ArrayCollection();
        $this->transaction = new ArrayCollection();
    }

    /**
     * Получить идентификатор заказа
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
     * @return self
     */
    #[ORM\PrePersist]
    public function setDtCreate(): self
    {
        $this->dtCreate = new DateTime();

        return $this;
    }

    /**
     * Получить историю статусов заказа
     *
     * @return Collection<int, HistoryOrderStatus>
     */
    public function getHistoryOrderStatus(): Collection
    {
        return $this->historyOrderStatus;
    }

    /**
     * Добавить в историю статус заказа
     *
     * @param HistoryOrderStatus $historyOrderStatus
     * @return self
     */
    public function addHistoryOrderStatus(HistoryOrderStatus $historyOrderStatus): self
    {
        if (!$this->historyOrderStatus->contains($historyOrderStatus)) {
            $this->historyOrderStatus->add($historyOrderStatus);
            $historyOrderStatus->setOrder($this);
        }

        return $this;
    }

    /**
     * Удалить из истории статус заказа
     *
     * @param HistoryOrderStatus $historyOrderStatus
     * @return self
     */
    public function removeHistoryOrderStatus(HistoryOrderStatus $historyOrderStatus): self
    {
        if ($this->historyOrderStatus->removeElement($historyOrderStatus)) {
            if ($historyOrderStatus->getOrder() === $this) {
                $historyOrderStatus->setOrder(null);
            }
        }

        return $this;
    }

    /**
     * Получить товары заказа
     *
     * @return Collection<int, OrderProduct>
     */
    public function getOrderProduct(): Collection
    {
        return $this->orderProduct;
    }

    /**
     * Добавить товар в заказ
     *
     * @param OrderProduct $orderProduct
     * @return self
     */
    public function addOrderProduct(OrderProduct $orderProduct): self
    {
        if (!$this->orderProduct->contains($orderProduct)) {
            $this->orderProduct->add($orderProduct);
            $orderProduct->setOrder($this);
        }

        return $this;
    }

    /**
     * Удалить товар из заказа
     *
     * @param OrderProduct $orderProduct
     * @return self
     */
    public function removeOrderProduct(OrderProduct $orderProduct): self
    {
        if ($this->orderProduct->removeElement($orderProduct)) {
            if ($orderProduct->getOrder() === $this) {
                $orderProduct->setOrder(null);
            }
        }

        return $this;
    }

    /**
     * Получить информацию о получателе
     *
     * @return Recipient|null
     */
    public function getRecipient(): ?Recipient
    {
        return $this->recipient;
    }

    /**
     * Записать информацию о получателе
     *
     * @param Recipient|null $recipient
     * @return self
     */
    public function setRecipient(?Recipient $recipient): self
    {
        $this->recipient = $recipient;

        return $this;
    }

    /**
     * @return Collection<int, Transaction>
     */
    public function getTransaction(): Collection
    {
        return $this->transaction;
    }

    public function addTransaction(Transaction $transaction): self
    {
        if (!$this->transaction->contains($transaction)) {
            $this->transaction->add($transaction);
            $transaction->setOrder($this);
        }

        return $this;
    }

    public function removeTransaction(Transaction $transaction): self
    {
        if ($this->transaction->removeElement($transaction)) {
            if ($transaction->getOrder() === $this) {
                $transaction->setOrder(null);
            }
        }

        return $this;
    }
}
