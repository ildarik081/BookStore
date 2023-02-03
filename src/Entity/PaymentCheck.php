<?php

namespace App\Entity;

use App\Repository\PaymentCheckRepository;
use DateTime;
use DateTimeInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Чеки заказа
 */
#[ORM\Entity(repositoryClass: PaymentCheckRepository::class)]
#[ORM\HasLifecycleCallbacks]
class PaymentCheck
{
    #[ORM\Id]
    #[ORM\GeneratedValue('IDENTITY')]
    #[
        ORM\Column(
            type: Types::INTEGER,
            nullable: false,
            options: ['comment' => 'Идентификатор чека']
        )
    ]
    private ?int $id = null;

    #[
        ORM\Column(
            type: Types::STRING,
            length: 40,
            nullable: true,
            options: ['comment' => 'Внешний идентификатор сервиса фискализации']
        )
    ]
    private ?string $externalId = null;

    #[
        ORM\Column(
            type: Types::BOOLEAN,
            nullable: false,
            options: [
                'comment' => 'true — чек требует фискализации',
                'default' => true
            ]
        )
    ]
    private bool $isActive = true;

    #[
        ORM\Column(
            type: Types::BOOLEAN,
            nullable: false,
            options: [
                'comment' => 'true — ошибка фискализации чека',
                'default' => false
            ]
        )
    ]
    private bool $isError = false;

    #[
        ORM\Column(
            type: Types::STRING,
            length: 255,
            nullable: true,
            options: ['comment' => 'Текст ошибки фискализации']
        )
    ]
    private ?string $errorMessage = null;

    #[
        ORM\Column(
            type: Types::DATETIME_MUTABLE,
            nullable: false,
            options: ['comment' => 'Дата/время создания чека']
        )
    ]
    private ?DateTimeInterface $dtCreate = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?CheckType $checkType = null;

    #[ORM\ManyToOne(inversedBy: 'paymentCheck')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Payment $payment = null;

    /**
     * Получить идентификатор чека
     *
     * @return integer|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Получить внешний идентификатор сервиса фискализации
     *
     * @return string|null
     */
    public function getExternalId(): ?string
    {
        return $this->externalId;
    }

    /**
     * Записать внешний идентификатор сервиса фискализации
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
     * Признак фискализации
     *
     * **true** - чек требует фискализации
     *
     * @return boolean|null
     */
    public function isActive(): ?bool
    {
        return $this->isActive;
    }

    /**
     * Изменить признак фискализации
     *
     * **true** - чек требует фискализации
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
     * Признак ошибки при фискализации
     *
     * @return boolean|null
     */
    public function isError(): ?bool
    {
        return $this->isError;
    }

    /**
     * Изменить признак ошибки фискализации
     *
     * @param boolean $isError
     * @return self
     */
    public function setIsError(bool $isError): self
    {
        $this->isError = $isError;

        return $this;
    }

    /**
     * Получить сообщение, которое отдал сервис фискализации во время ошибки
     *
     * @return string|null
     */
    public function getErrorMessage(): ?string
    {
        return $this->errorMessage;
    }

    /**
     * Записать сообщение об ошибке
     *
     * @param string|null $errorMessage
     * @return self
     */
    public function setErrorMessage(?string $errorMessage): self
    {
        $this->errorMessage = $errorMessage;

        return $this;
    }

    /**
     * Получить дату/время добавления чека
     *
     * @return DateTimeInterface|null
     */
    public function getDtCreate(): ?DateTimeInterface
    {
        return $this->dtCreate;
    }

    /**
     * Записать дату/время создания чека
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
     * Получить тип чека
     *
     * @return CheckType|null
     */
    public function getCheckType(): ?CheckType
    {
        return $this->checkType;
    }

    /**
     * Записать тип чека
     *
     * @param CheckType|null $checkType
     * @return self
     */
    public function setCheckType(?CheckType $checkType): self
    {
        $this->checkType = $checkType;

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
