<?php

namespace App\Entity;

use App\Repository\TypeRdvRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TypeRdvRepository::class)]
class TypeRdv
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $libelle = null;

    #[ORM\OneToMany(mappedBy: 'typeRdv', targetEntity: Appointment::class)]
    private Collection $appointment;

    public function __construct()
    {
        $this->appointment = new ArrayCollection();
    }

   
   

    public function getId(): ?int
    {
        return $this->id;
    }
///
    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(?string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * @return Collection<int, appointment>
     */
    public function getAppointment(): Collection
    {
        return $this->appointment;
    }

    public function addAppointment(appointment $appointment): self
    {
        if (!$this->appointment->contains($appointment)) {
            $this->appointment->add($appointment);
            $appointment->setTypeRdv($this);
        }

        return $this;
    }

    public function removeAppointment(appointment $appointment): self
    {
        if ($this->appointment->removeElement($appointment)) {
            // set the owning side to null (unless already changed)
            if ($appointment->getTypeRdv() === $this) {
                $appointment->setTypeRdv(null);
            }
        }

        return $this;
    }

    
}
