<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Lego\MrNameFieldTrait;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MrAuthorRepository")
 */
class MrAuthor
{
	/**
	 * @ORM\Id()
	 * @ORM\GeneratedValue()
	 * @ORM\Column(type="integer")
	 */
	private $id;

	/**
	 * @ORM\ManyToMany(targetEntity="App\Entity\MrBook", mappedBy="author")
	 */
	private $books;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Name;

	public function __construct()
         	{
         		$this->books = new ArrayCollection();
         	}
	/**
	 * @return Collection|MrBook[]
	 */
	public function getBook(): Collection
         	{
         		return $this->books;
         	}

	public function addBook(MrBook $book): self
         	{
         		if (!$this->books->contains($book)) {
         			$this->books[] = $book;
         			$book->addAuthor($this);
         		}
         
         		return $this;
         	}

	public function removeBook(MrBook $book): self
         	{
         		if ($this->books->contains($book)) {
         			$this->books->removeElement($book);
         			$book->removeCategory($this);
         		}
         
         		return $this;
         	}

    public function getName(): ?string
    {
        return $this->Name;
    }

    public function setName(?string $Name): self
    {
        $this->Name = $Name;

        return $this;
    }
}

