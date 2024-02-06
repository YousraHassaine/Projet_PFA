<?php

namespace App\Entity;

use App\Repository\SpecialityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SpecialityRepository::class)]
class Speciality
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
///
    #[ORM\Column(length: 255)]
    private ?string $nomSpeciality = null;

    #[ORM\OneToMany(mappedBy: 'specialty', targetEntity: Doctor::class)]
    private Collection $Doctors;

    public function __construct()
    {
        $this->Doctors = new ArrayCollection();
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomSpeciality(): ?string
    {
        return $this->nomSpeciality;
    }

    public function setNomSpeciality(string $nomSpeciality): self
    {
        $this->nomSpeciality = $nomSpeciality;

        return $this;
    }

    /**
     * @return Collection<int, Doctor>
     */
    public function getDoctors(): Collection
    {
        return $this->Doctors;
    }

    public function addDoctor(Doctor $doctor): self
    {
        if (!$this->Doctors->contains($doctor)) {
            $this->Doctors->add($doctor);
            $doctor->setSpecialty($this);
        }

        return $this;
    }

    public function removeDoctor(Doctor $doctor): self
    {
        if ($this->Doctors->removeElement($doctor)) {
            // set the owning side to null (unless already changed)
            if ($doctor->getSpecialty() === $this) {
                $doctor->setSpecialty(null);
            }
        }

        return $this;
    }

 

   
}
