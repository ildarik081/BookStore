<?php

namespace App\Entity;

use App\Repository\AcquiringSettingsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Настройки для эквайринга
 */
#[ORM\Entity(repositoryClass: AcquiringSettingsRepository::class)]
class AcquiringSettings
{
    #[ORM\Id]
    #[ORM\GeneratedValue('IDENTITY')]
    #[
        ORM\Column(
            type: Types::INTEGER,
            nullable: false,
            options: ['comment' => 'Идентификатор статуса заказа']
        )
    ]
    private ?int $id = null;

    #[
        ORM\Column(
            type: Types::STRING,
            nullable: false,
            length: 80,
            options: ['comment' => 'Логин для авторизации у мерчанта']
        )
    ]
    private ?string $login = null;

    #[
        ORM\Column(
            type: Types::STRING,
            nullable: false,
            length: 80,
            options: ['comment' => 'Пароль для авторизации у мерчанта']
        )
    ]
    private ?string $password = null;

    #[
        ORM\Column(
            type: Types::BOOLEAN,
            nullable: false,
            options: [
                'comment' => 'true — активный мерчант',
                'default' => false
            ]
        )
    ]
    private bool $isActive = false;

    #[ORM\ManyToOne(inversedBy: 'acquiringSettings')]
    #[ORM\JoinColumn(nullable: false)]
    private ?PaymentType $paymentType = null;

    /**
     * Получить идентификатор настройки мерчанта
     *
     * @return integer|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Получить логин для авторизации у мерчанта
     *
     * @return string|null
     */
    public function getLogin(): ?string
    {
        return $this->login;
    }

    /**
     * Записать логин для авторизации у мерчанта
     *
     * @param string $login
     * @return self
     */
    public function setLogin(string $login): self
    {
        $this->login = $login;

        return $this;
    }

    /**
     * Получить пароль для авторизации у мерчанта
     *
     * @return string|null
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * Записать пароль для авторизации у мерчанта
     *
     * @param string $password
     * @return self
     */
    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Признак активности мерчанта
     *
     * @return boolean
     */
    public function isActive(): bool
    {
        return $this->isActive;
    }

    /**
     * Изменить признак активности мерчанта
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
     * Получить тип оплаты мерчанта
     *
     * Принадлежность мерчанта к типу оплаты
     *
     * @return PaymentType|null
     */
    public function getPaymentType(): ?PaymentType
    {
        return $this->paymentType;
    }

    /**
     * Изменить тип оплаты для мерчанта
     *
     * @param PaymentType|null $paymentType
     * @return self
     */
    public function setPaymentType(?PaymentType $paymentType): self
    {
        $this->paymentType = $paymentType;

        return $this;
    }
}
