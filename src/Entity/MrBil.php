<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use App\Repository\MrBilRepository;
use Doctrine\ORM\Mapping as ORM;
/**
 * MrBil
 *
 * @ORM\Table(name="mr_bil")
 * @ORM\Entity(repositoryClass=App\Repository\MrBilRepository::class)
 */
class MrBil
{
  /**
   * @var int
   *
   * @ORM\Column(name="id", type="integer", nullable=false)
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="SEQUENCE")
   * @ORM\SequenceGenerator(sequenceName="mr_bil_id_seq", allocationSize=1, initialValue=1)
   */
  private $id;

  /**
   * @ORM\ManyToOne(targetEntity="App\Entity\MrBook", inversedBy="mr_book")
   * @ORM\Column(name="bookid", nullable=false)
   * @ORM\JoinColumn(nullable=false)
   */
  private $bookid;

  /**
   * @var int
   *
   * @ORM\Column(name="authorid", type="integer", nullable=false)
   */
  private $authorid;


  public function getId(): ?int
  {
    return $this->id;
  }

  public function getBook(): ?MrBook
  {
    return $this->bookid;
  }

  public function setBookID(int $value): void
  {
    $this->bookid = $value;
  }

  public function getAuthorID(): ?MrAuthor
  {
    $this->authorid;
  }

  public function setAuthorID(int $value): void
  {
    $this->authorid = $value;
  }

}
