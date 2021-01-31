<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MrLeadRepository")
 */
class MrLead extends MrOrm
{
	/**
	 * @ORM\Id
	 * @ORM\GeneratedValue
	 * @ORM\Column(type="integer")
	 */
	private $id;

	/**
	 * @ORM\ManyToMany(targetEntity=MrBook::class, inversedBy="mrLeads")
	 */
	private $bookid;

	/**
	 * @ORM\Column(type="integer")
	 */
	private $status;

	/**
	 * @ORM\Column(type="string", length=255)
	 */
	private $phone;

	/**
	 * @ORM\Column(type="string", length=255)
	 */
	private $address;

	public function __construct()
	{
		$this->bookid = new ArrayCollection();
	}

	public function getId(): ?int
	{
		return $this->id;
	}

	/**
	 * @return Collection|MrBook[]
	 */
	public function getBookid(): Collection
	{
		return $this->bookid;
	}

	public function addBookid(MrBook $bookid): self
	{
		if (!$this->bookid->contains($bookid))
		{
			$this->bookid[] = $bookid;
		}

		return $this;
	}

	public function removeBookid(MrBook $bookid): self
	{
		$this->bookid->removeElement($bookid);

		return $this;
	}

	const STATUS_NEW = 0;
	const STATUS_WORK = 1;
	const STATUS_DONE = 2;

	private static $status_list = array(
			self::STATUS_NEW  => 'в ожидании',
			self::STATUS_WORK => 'обрабатывается',
			self::STATUS_DONE => 'выполнено',
	);

	/**
	 * @ORM\Column(type="string", length=33)
	 */
	private $identifier;

	public static function getStatusList(): array
	{
		return self::$status_list;
	}

	public function getStatus(): int
	{
		return $this->status;
	}

	public function getStatusName(): string
	{
		return self::getStatusList()[$this->status];
	}

	public function setStatus(int $status): self
	{
		if (!isset(self::getStatusList()[$status]))
		{
			dd('Unknown status: ' . $status);
		}

		$this->status = $status;

		return $this;
	}

	public function getPhone(): ?string
	{
		return $this->phone;
	}

	public function setPhone(string $phone): self
	{
		$this->phone = $phone;

		return $this;
	}

	public function getAddress(): ?string
	{
		return $this->address;
	}

	public function setAddress(string $address): self
	{
		$this->address = $address;

		return $this;
	}

	public function getIdentifier(): ?string
	{
		return $this->identifier;
	}

	public function setIdentifier(string $identifier): self
	{
		$this->identifier = $identifier;

		return $this;
	}

	/**
	 * @param UserInterface $user
	 * @return bool
	 */
	public function canEdit(UserInterface $user): bool
	{
		foreach ($user->getRoles() as $role)
		{
			if ($role == 'ROLE_USER')
			{
				return true;
			}
		}

		return false;
	}
}
