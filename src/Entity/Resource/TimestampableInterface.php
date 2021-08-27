<?php

declare(strict_types=1);

namespace App\Entity\Resource;

use DateTimeInterface;

interface TimestampableInterface
{

    public function getCreatedAt(): ?DateTimeInterface;

    public function setCreatedAt(?DateTimeInterface $createdAt): void;

    public function create(): void;

    public function getUpdatedAt(): ?DateTimeInterface;

    public function setUpdatedAt(?DateTimeInterface $updatedAt): void;

    public function update(): void;

}
