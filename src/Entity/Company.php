<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\CompanyRepository;
use ApiPlatform\Core\Annotation\ApiFilter;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;


/**
 * @ORM\Entity(repositoryClass=CompanyRepository::class)
 * @ApiResource(
 *  attributes={"pagination_enabled"= false},
 *  collectionOperations={"get"},
 *  normalizationContext={"groups"={"Limit:two"}},
 *  denormalizationContext={"groups"={"Limit:two"}},
 *  itemOperations={
 *           "get"={"normalizationContext"={"groups"={"Limit:two"}}},
 *           "patch"={"denormalizationContext"={"groups"={"Limit:two"}}
 *          }
 *      },
 * )
 */
class Company
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups("Limit:two")
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $siren;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups("Limit:two")
     */
    private $activityArea;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups("Limit:one")
     */
    private $adress;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     * @Groups("Limit:one")
     */
    private $zipcode;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups("Limit:one")
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups("Limit:one")
     */
    private $country;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups("Limit:one")
     */
    private $employeesNumb;

    /**
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="company", cascade={"persist"})
     */
    private $users;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSiren(): ?string
    {
        return $this->siren;
    }

    public function setSiren(string $siren): self
    {
        $this->siren = $siren;

        return $this;
    }

    public function getActivityArea(): ?string
    {
        return $this->activityArea;
    }

    public function setActivityArea(string $activityArea): self
    {
        $this->activityArea = $activityArea;

        return $this;
    }

    public function getAdress(): ?string
    {
        return $this->adress;
    }

    public function setAdress(string $adress): self
    {
        $this->adress = $adress;

        return $this;
    }

    public function getZipcode(): ?string
    {
        return $this->zipcode;
    }

    public function setZipcode(string $zipcode): self
    {
        $this->zipcode = $zipcode;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getEmployeesNumb(): ?int
    {
        return $this->employeesNumb;
    }

    public function setEmployeesNumb(?int $employeesNumb): self
    {
        $this->employeesNumb = $employeesNumb;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setCompany($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getCompany() === $this) {
                $user->setCompany(null);
            }
        }

        return $this;
    }
}
