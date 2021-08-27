<?php

declare(strict_types=1);

namespace App\Entity\Book;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Dto\Author\AuthorInput;
use App\Dto\Author\AuthorOutput;
use App\Entity\Resource\ResourceTrait;
use App\Entity\Resource\TimestampableTrait;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\Table;
use JetBrains\PhpStorm\Pure;

#[ApiResource(
    input: AuthorInput::class,
    output: AuthorOutput::class
)]
#[Entity]
#[Table(name: "author")]
class Author implements AuthorInterface
{

    use ResourceTrait, TimestampableTrait;

    #[Id, GeneratedValue, Column(type: Types::INTEGER)]
    private ?int $id = null;

    #[Column(type: Types::STRING, nullable: false)]
    private ?string $firstName = null;

    #[Column(type: Types::STRING, nullable: false)]
    private ?string $lastName = null;

    #[Column(type: Types::DATETIME_MUTABLE, nullable: false)]
    private ?DateTimeInterface $birthday = null;

    /**
     * @var Collection<int, BookInterface>
     */
    #[OneToMany(mappedBy: "author", targetEntity: Book::class, cascade: ["persist"], fetch: "EXTRA_LAZY")]
    private Collection $books;

    #[Pure]
    public function __construct()
    {
        $this->books = new ArrayCollection();
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): void
    {
        $this->firstName = $firstName;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(?string $lastName): void
    {
        $this->lastName = $lastName;
    }

    public function getBirthday(): ?DateTimeInterface
    {
        return $this->birthday;
    }

    public function setBirthday(?DateTimeInterface $birthday): void
    {
        $this->birthday = $birthday;
    }

    public function hasBooks(): bool
    {
        return 0 < $this->getBooks()->count();
    }

    public function getBooks(): Collection
    {
        return $this->books;
    }

    public function hasBook(?BookInterface $book): bool
    {
        return $this->getBooks()->contains($book);
    }

    public function addBook(?BookInterface $book): void
    {
        if ($this->hasBook($book)) {
            return;
        }

        $this->books->add($book);
        $book->setAuthor($this);
    }

    public function removeBook(?BookInterface $book): void
    {
        if (!$this->hasBook($book)) {
            return;
        }

        $this->books->removeElement($book);
        $book->setAuthor(null);
    }

}
