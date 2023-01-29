<?php

namespace App\Entity;

use App\Repository\PaymentTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Тип оплаты
 *
 * - card - _Банковской картой онлайн_
 * - sbp - _Система быстрых платежей_
 */
#[ORM\Entity(repositoryClass: PaymentTypeRepository::class)]
class PaymentType
{
    #[ORM\Id]
    #[ORM\GeneratedValue('IDENTITY')]
    #[
        ORM\Column(
            type: Types::INTEGER,
            nullable: false,
            options: ['comment' => 'Идентификатор типа оплаты']
        )
    ]
    private ?int $id = null;

    #[
        ORM\Column(
            type: Types::STRING,
            length: 30,
            nullable: false,
            options: ['comment' => 'Значение']
        )
    ]
    private ?string $value = null;

    #[
        ORM\Column(
            type: Types::STRING,
            length: 255,
            nullable: true,
            options: ['comment' => 'Описание']
        )
    ]
    private ?string $description = null;

    #[
        ORM\Column(
            type: Types::STRING,
            length: 20,
            nullable: false,
            options: ['comment' => 'Код типа оплаты']
        )
    ]
    private ?string $code = null;

    #[ORM\OneToMany(mappedBy: 'paymentType', targetEntity: AcquiringSettings::class)]
    private Collection $acquiringSettings;

    public function __construct()
    {
        $this->acquiringSettings = new ArrayCollection();
    }

    /**
     * Получить идентификатор типа оплаты
     *
     * @return integer|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Получить значение типа оплаты
     *
     * @return string|null
     */
    public function getValue(): ?string
    {
        return $this->value;
    }

    /**
     * Записать значение типа оплаты
     *
     * @param string $value
     * @return self
     */
    public function setValue(string $value): self
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Получить описание типа оплаты
     *
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * Записать описание типа оплаты
     *
     * @param string|null $description
     * @return self
     */
    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Получить код типа оплаты
     *
     * @return string|null
     */
    public function getCode(): ?string
    {
        return $this->code;
    }

    /**
     * Записать код типа оплаты
     *
     * @param string $code
     * @return self
     */
    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Получить настройки для эквайринга
     *
     * Настройка должна быть с isActive = true
     *
     * @return Collection<int, AcquiringSettings>
     */
    public function getAcquiringSettings(): Collection
    {
        return $this->acquiringSettings;
    }

    /**
     * Добавить настройку эквайринга для этого типа
     *
     * @param AcquiringSettings $acquiringSetting
     * @return self
     */
    public function addAcquiringSetting(AcquiringSettings $acquiringSetting): self
    {
        if (!$this->acquiringSettings->contains($acquiringSetting)) {
            $this->acquiringSettings->add($acquiringSetting);
            $acquiringSetting->setPaymentType($this);
        }

        return $this;
    }

    /**
     * Удалить настройку эквайринга для этого типа
     *
     * @param AcquiringSettings $acquiringSetting
     * @return self
     */
    public function removeAcquiringSetting(AcquiringSettings $acquiringSetting): self
    {
        if ($this->acquiringSettings->removeElement($acquiringSetting)) {
            if ($acquiringSetting->getPaymentType() === $this) {
                $acquiringSetting->setPaymentType(null);
            }
        }

        return $this;
    }
}
