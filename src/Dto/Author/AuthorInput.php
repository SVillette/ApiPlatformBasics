<?php

declare(strict_types=1);

namespace App\Dto\Author;

use App\Dto\Resource\Input;
use DateTimeInterface;

class AuthorInput extends Input
{

    public ?string $firstName = null;

    public ?string $lastName = null;

    public ?DateTimeInterface $birthday = null;

}
