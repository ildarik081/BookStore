<?php

namespace App\Entity;

use App\Repository\TransactionRepository;
use DateTime;
use DateTimeInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Транзакция
 */
#[ORM\Entity(repositoryClass: TransactionRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Transaction
{
    #[ORM\Id]
    #[ORM\GeneratedValue('IDENTITY')]
    #[
        ORM\Column(
            type: Types::INTEGER,
            nullable: false,
            options: ['comment' => 'Идентификатор транзакции']
        )
    ]
    private ?int $id = null;

    #[
        ORM\Column(
            type: Types::GUID,
            nullable: false,
            options: ['comment' => 'Идентификатор транзакции в формате UUID для мерчантов']
        )
    ]
    private ?string $uuid = null;

    #[
        ORM\Column(
            type: Types::FLOAT,
            nullable: false,
            options: ['comment' => 'Сумма транзакции']
        )
    ]
    private ?float $sum = null;

    #[
        ORM\Column(
            type: Types::BOOLEAN,
            nullable: false,
            options: [
                'comment' => 'true — активная транзакция (оплата не подтверждена)',
                'default' => true
            ]
        )
    ]
    private bool $isActive = true;

    #[
        ORM\Column(
            type: Types::STRING,
            nullable: true,
            length: 255,
            options: ['comment' => 'Ссылка для оплаты']
        )
    ]
    private ?string $paymentLink = null;

    #[
        ORM\Column(
            type: Types::STRING,
            nullable: true,
            length: 80,
            options: ['comment' => 'Внешний идентификатор мерчанта']
        )
    ]
    private ?string $externalId = null;

    #[
        ORM\Column(
            type: Types::STRING,
            nullable: false,
            length: 10,
            options: ['comment' => 'Код типа оплаты']
        )
    ]
    private ?string $paymentTypeCode = null;

    #[
        ORM\Column(
            type: Types::DATETIME_MUTABLE,
            nullable: false,
            options: ['comment' => 'Дата/время создания транзакции']
        )
    ]
    private ?DateTimeInterface $dtCreate = null;

    #[ORM\ManyToOne(inversedBy: 'transaction')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Order $order = null;

    #[
        ORM\OneToOne(
            inversedBy: 'transaction',
            cascade: ['persist', 'remove']
        )
    ]
    private ?Payment $payment = null;

    /**
     * Получить идентификатор транзакции
     *
     * @return integer|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Получить UUID транзакции
     *
     * передается мерчанту
     *
     * @return string|null
     */
    public function getUuid(): ?string
    {
        return $this->uuid;
    }

    /**
     * Записать UUID транзакции
     *
     * @param string $uuid
     * @return self
     */
    public function setUuid(string $uuid): self
    {
        $this->uuid = $uuid;

        return $this;
    }

    /**
     * Получить сумму транзакции
     *
     * @return float|null
     */
    public function getSum(): ?float
    {
        return $this->sum;
    }

    /**
     * Записать сумму транзакции
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
     * Признак активности транзакции
     *
     * **true** - оплата не подтверждена
     *
     * @return boolean
     */
    public function isActive(): bool
    {
        return $this->isActive;
    }

    /**
     * Изменить признак активности транзакции
     *
     * @param boolean $isActive
     * @return self
     */
    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Получить ссылку для оплаты
     *
     * @return string|null
     */
    public function getPaymentLink(): ?string
    {
        return $this->paymentLink;
    }

    /**
     * Записать ссылку для оплаты
     *
     * @param string|null $paymentLink
     * @return self
     */
    public function setPaymentLink(?string $paymentLink): self
    {
        $this->paymentLink = $paymentLink;

        return $this;
    }

    /**
     * Получить внешний идентификатор мерчанта
     *
     * @return string|null
     */
    public function getExternalId(): ?string
    {
        return $this->externalId;
    }

    /**
     * Записать внешний идентификатор мерчанта
     *
     * @param string|null $externalId
     * @return self
     */
    public function setExternalId(?string $externalId): self
    {
        $this->externalId = $externalId;

        return $this;
    }

    /**
     * Получить дату/время создания транзакции
     *
     * @return DateTimeInterface|null
     */
    public function getDtCreate(): ?DateTimeInterface
    {
        return $this->dtCreate;
    }

    /**
     * Записать дату/время создания транзакции
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
     * Получить заказ
     *
     * @return Order|null
     */
    public function getOrder(): ?Order
    {
        return $this->order;
    }

    /**
     * Записать заказ
     *
     * @param Order|null $order
     * @return self
     */
    public function setOrder(?Order $order): self
    {
        $this->order = $order;

        return $this;
    }

    /**
     * Получить код типа оплаты
     *
     * @return string|null
     */
    public function getPaymentTypeCode(): ?string
    {
        return $this->paymentTypeCode;
    }

    /**
     * Записать код типа оплаты
     *
     * @param string $paymentTypeCode
     * @return self
     */
    public function setPaymentTypeCode(string $paymentTypeCode): self
    {
        $this->paymentTypeCode = $paymentTypeCode;

        return $this;
    }

    /**
     * Получить оплату
     *
     * @return Payment|null
     */
    public function getPayment(): ?Payment
    {
        return $this->payment;
    }

    /**
     * Записать оплату
     *
     * @param Payment|null $payment
     * @return self
     */
    public function setPayment(?Payment $payment): self
    {
        $this->payment = $payment;

        return $this;
    }
}
