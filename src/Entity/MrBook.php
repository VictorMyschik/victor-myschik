<?php

namespace App\Entity;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MrBookRepository")
 */
class MrBook
{
  /**
   * @ORM\Id()
   * @ORM\GeneratedValue
   * @ORM\Column(type="integer")
   */
  private $id;
  /**
   * @ORM\ManyToMany(targetEntity="App\Entity\MrAuthor", inversedBy="books")
   */
  private $author;

  /**
   * @ORM\Column(type="string", length=255, nullable=true)
   */
  private $name;

  /**
   * @ORM\Column(type="integer", nullable=true)
   */
  private $page_cnt;

  /**
   * @ORM\Column(type="decimal", precision=10, scale=2)
   */
  private $price;

  /**
   * @ORM\Column(type="integer")
   */
  private $existence;

  /**
   * @ORM\Column(type="integer", nullable=true)
   */
  private $year;

  /**
   * @ORM\Column(type="string", length=25, nullable=true)
   */
  private $isbn;

  /**
   * @ORM\Column(type="string", length=255, nullable=true)
   */
  private $url;

  /**
   * @ORM\Column(type="string", length=10000, nullable=true)
   */
  private $description;

  public function __construct()
  {
    $this->author = new ArrayCollection();
    $this->mrLeads = new ArrayCollection();
  }

  public function getId(): ?int
  {
    return $this->id;
  }

  /**
   * @return Collection|MrAuthor[]
   */
  public function getAuthors(): Collection
  {
    return $this->author;
  }

  public function addAuthor(MrAuthor $author): self
  {
    if (!$this->author->contains($author))
    {
      $this->author[] = $author;
    }

    return $this;
  }

  public function removeAuthor(MrAuthor $author): self
  {
    if ($this->author->contains($author))
    {
      $this->author->removeElement($author);
    }

    return $this;
  }

  public function getName(): ?string
  {
    return $this->name;
  }

  public function setName(?string $name): self
  {
    $this->name = $name;

    return $this;
  }

  public function getPageCnt(): ?int
  {
    return $this->page_cnt;
  }

  public function setPageCnt(?int $page_cnt): self
  {
    $this->page_cnt = $page_cnt;

    return $this;
  }

  public function getPrice(): ?float
  {
    return $this->price;
  }

  public function setPrice(float $price): self
  {
    $this->price = $price;

    return $this;
  }

  const EXISTENCE_NO = 0;
  const EXISTENCE_YES = 1;
  const EXISTENCE_PREORDER = 2;
  const EXISTENCE_WAIT = 3;
  const EXISTENCE_WAIT_5 = 4;

  private static $existences = array(
    self::EXISTENCE_NO       => 'Нет в наличии',
    self::EXISTENCE_YES      => 'Есть',
    self::EXISTENCE_PREORDER => 'Уточняйте',
    self::EXISTENCE_WAIT     => 'Скоро в продаже',
    self::EXISTENCE_WAIT_5   => 'Доставка в течении 5 дней',
  );

  /**
   * @ORM\ManyToMany(targetEntity=MrLead::class, mappedBy="bookid")
   */
  private $mrLeads;

  public static function GetExistenceList()
  {
    return self::$existences;
  }

  public function getExistence(): ?int
  {
    return $this->existence;
  }

  public function getExistenceName(): string
  {
    return self::GetExistenceList()[$this->getExistence()];
  }

  public function setExistence(int $existence): self
  {
    $this->existence = $existence;

    return $this;
  }

  public function getYear(): ?int
  {
    return $this->year;
  }

  public function setYear(?int $year): self
  {
    $this->year = $year;

    return $this;
  }

  public function getIsbn(): ?string
  {
    return $this->isbn;
  }

  public function setIsbn(?string $isbn): self
  {
    $this->isbn = $isbn;

    return $this;
  }

  public function getUrl(): ?string
  {
    return $this->url;
  }

  public function setUrl(?string $url): self
  {
    $this->url = $url;

    return $this;
  }

  public function getDescription(): ?string
  {
    return $this->description;
  }

  public function setDescription(?string $description): self
  {
    $this->description = $description;

    return $this;
  }

  /**
   * @return Collection|MrLead[]
   */
  public function getMrLeads(): Collection
  {
      return $this->mrLeads;
  }

  public function addMrLead(MrLead $mrLead): self
  {
      if (!$this->mrLeads->contains($mrLead)) {
          $this->mrLeads[] = $mrLead;
          $mrLead->addBookid($this);
      }

      return $this;
  }

  public function removeMrLead(MrLead $mrLead): self
  {
      if ($this->mrLeads->removeElement($mrLead)) {
          $mrLead->removeBookid($this);
      }

      return $this;
  }

}
