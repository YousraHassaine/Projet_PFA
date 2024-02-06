<?php

namespace App\Entity;

use App\Repository\PatientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PatientRepository::class)]
class Patient extends User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $assurance = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateNaissance = null;

    #[ORM\OneToMany(mappedBy: 'patient', targetEntity: Notice::class, orphanRemoval: true)]
    private Collection $Notice;



    public function __construct()
    {
        $this->Notice = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAssurance(): ?string
    {
        return $this->assurance;
    }

    public function setAssurance(string $assurance): self
    {
        $this->assurance = $assurance;

        return $this;
    }

    public function getDateNaissance(): ?\DateTimeInterface
    {
        return $this->dateNaissance;
    }

    public function setDateNaissance(\DateTimeInterface $dateNaissance): self
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    /**
     * @return Collection<int, Notice>
     */
    public function getNotice(): Collection
    {
        return $this->Notice;
    }

    public function addNotice(Notice $notice): self
    {
        if (!$this->Notice->contains($notice)) {
            $this->Notice->add($notice);
            $notice->setPatient($this);
        }

        return $this;
    }
//ToDO
///
    public function removeNotice(Notice $notice): self
    {
        if ($this->Notice->removeElement($notice)) {
            // set the owning side to null (unless already changed)
            if ($notice->getPatient() === $this) {
                $notice->setPatient(null);
            }
        }

        return $this;
    }


}
