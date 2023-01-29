<?php

namespace App\Entity;

use App\Repository\CheckTypeRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Тип чека
 *
 * - advance - _авансовый чек_
 * - refundAdvance - _возврат аванса_
 * - fullSettlement - _чек полного расчета_
 * - refundFullSettlement - _возврат полного расчета_
 */
#[ORM\Entity(repositoryClass: CheckTypeRepository::class)]
class CheckType
{
    #[ORM\Id]
    #[ORM\GeneratedValue('IDENTITY')]
    #[
        ORM\Column(
            type: Types::INTEGER,
            nullable: false,
            options: ['comment' => 'Идентификатор типа чека']
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
            options: ['comment' => 'Код типа чека']
        )
    ]
    private ?string $code = null;

    /**
     * Получить идентификатор типа чека
     *
     * @return integer|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Получить значение типа чека
     *
     * @return string|null
     */
    public function getValue(): ?string
    {
        return $this->value;
    }

    /**
     * Записать значение типа чека
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
     * Получить описание типа чека
     *
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * Записать описание типа чека
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
     * Получить код типа чека
     *
     * @return string|null
     */
    public function getCode(): ?string
    {
        return $this->code;
    }

    /**
     * Записать код типа чека
     *
     * @param string $code
     * @return self
     */
    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }
}
