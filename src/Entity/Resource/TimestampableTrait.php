<?php

declare(strict_types=1);

namespace App\Entity\Resource;

use DateTime;
use DateTimeInterface;
use Doctrine\ORM\Mapping\Column;

trait TimestampableTrait
{

    #[Column(type: "datetime", nullable: false)]
    private ?DateTimeInterface $createdAt = null;

    #[Column(type: "datetime", nullable: false)]
    private ?DateTimeInterface $updatedAt = null;

    public function getCreatedAt(): ?DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?DateTimeInterface $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function create(): void
    {
        $this->setCreatedAt(new DateTime());
        $this->update();
    }

    public function getUpdatedAt(): ?DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?DateTimeInterface $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    public function update(): void
    {
        $this->setUpdatedAt(new DateTime());
    }

}
