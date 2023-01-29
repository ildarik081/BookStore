<?php

namespace App\Entity;

use App\Repository\RecipientRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Получатель
 */
#[ORM\Entity(repositoryClass: RecipientRepository::class)]
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
}
