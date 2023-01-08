<?php

namespace App\Entity;

use App\Repository\OrderStatusRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Статус заказа
 */
#[ORM\Entity(repositoryClass: OrderStatusRepository::class)]
#[ORM\Table(options: ['comment' => 'Справочник статусов заказа'])]
class OrderStatus
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
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

    /**
     * Получить идентификатор статуса
     *
     * @return integer|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Получить значение статуса
     *
     * @return string|null
     */
    public function getValue(): ?string
    {
        return $this->value;
    }

    /**
     * Записать значение статуса
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
     * Получить описание статуса
     *
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * Записать описание статуса
     *
     * @param string|null $description
     * @return self
     */
    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }
}
