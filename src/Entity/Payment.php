<?php

namespace App\Entity;

use App\Repository\PaymentRepository;
use DateTime;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Оплата
 */
#[ORM\Entity(repositoryClass: PaymentRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Payment
{
    #[ORM\Id]
    #[ORM\GeneratedValue('IDENTITY')]
    #[
        ORM\Column(
            type: Types::INTEGER,
            nullable: false,
            options: ['comment' => 'Идентификатор оплаты']
        )
    ]
    private ?int $id = null;

    #[
        ORM\Column(
            type: Types::FLOAT,
            nullable: false,
            options: ['comment' => 'Сумма оплаты']
        )
    ]
    private ?float $sum = null;

    #[
        ORM\Column(
            type: Types::DATETIME_MUTABLE,
            nullable: false,
            options: ['comment' => 'Дата/время создания оплаты']
        )
    ]
    private ?DateTimeInterface $dtCreate = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?PaymentType $paymentType = null;

    #[
        ORM\OneToOne(
            mappedBy: 'payment',
            cascade: ['persist', 'remove']
        )
    ]
    private ?Transaction $transaction = null;

    #[
        ORM\OneToMany(
            mappedBy: 'payment',
            targetEntity: PaymentCheck::class
        )
    ]
    private Collection $paymentCheck;

    public function __construct()
    {
        $this->paymentCheck = new ArrayCollection();
    }

    /**
     * Получить идентификатор оплаты
     *
     * @return integer|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Получить сумму оплаты
     *
     * @return float|null
     */
    public function getSum(): ?float
    {
        return $this->sum;
    }

    /**
     * Записать сумму оплаты
     *
     * @param float $sum
     * @return self
     */
    public function setSum(float $sum): self
    {
        $this->sum = $sum;

        return $this;
    }

    /**
     * Получить дату/время создания оплаты
     *
     * @return DateTimeInterface|null
     */
    public function getDtCreate(): ?DateTimeInterface
    {
        return $this->dtCreate;
    }

    /**
     * Записать дату/время создания оплаты
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
     * Получить тип оплаты
     *
     * @return PaymentType|null
     */
    public function getPaymentType(): ?PaymentType
    {
        return $this->paymentType;
    }

    /**
     * Записать тип оплаты
     *
     * @param PaymentType|null $paymentType
     * @return self
     */
    public function setPaymentType(?PaymentType $paymentType): self
    {
        $this->paymentType = $paymentType;

        return $this;
    }

    /**
     * Получить транзакцию оплаты
     *
     * @return Transaction|null
     */
    public function getTransaction(): ?Transaction
    {
        return $this->transaction;
    }

    /**
     * Записать транзакцию оплаты
     *
     * @param Transaction|null $transaction
     * @return self
     */
    public function setTransaction(?Transaction $transaction): self
    {
        if ($transaction === null && $this->transaction !== null) {
            $this->transaction->setPayment(null);
        }

        if ($transaction !== null && $transaction->getPayment() !== $this) {
            $transaction->setPayment($this);
        }

        $this->transaction = $transaction;

        return $this;
    }

    /**
     * Получить массив чеков оплаты
     *
     * @return Collection<int, PaymentCheck>
     */
    public function getPaymentCheck(): Collection
    {
        return $this->paymentCheck;
    }

    /**
     * Добавить чек оплаты
     *
     * @param PaymentCheck $paymentCheck
     * @return self
     */
    public function addPaymentCheck(PaymentCheck $paymentCheck): self
    {
        if (!$this->paymentCheck->contains($paymentCheck)) {
            $this->paymentCheck->add($paymentCheck);
            $paymentCheck->setPayment($this);
        }

        return $this;
    }

    /**
     * Удалить чек оплаты
     *
     * @param PaymentCheck $paymentCheck
     * @return self
     */
    public function removePaymentCheck(PaymentCheck $paymentCheck): self
    {
        if ($this->paymentCheck->removeElement($paymentCheck)) {
            if ($paymentCheck->getPayment() === $this) {
                $paymentCheck->setPayment(null);
            }
        }

        return $this;
    }
}
