<?php

namespace App\Entity;

use App\Repository\AppointmentRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AppointmentRepository::class)]
class Appointment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $heureDebut = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $heureFin = null;

    #[ORM\ManyToOne(inversedBy: 'appointment')]
    private ?TypeRdv $typeRdv = null;

   ///

    #[ORM\ManyToOne(inversedBy: 'appointments')]
    private ?Doctor $Doctor = null;

    #[ORM\ManyToOne(inversedBy: 'appointments')]
    private ?Patient $Patient = null;

    //TODO
    //Atribut chadeau
    private ?int $patient_id;

    /**
     * @return int|null
     */
    public function getPatientId(): ?int
    {
        return $this->patient_id;
    }

    /**
     * @param int|null $patient_id
     */
    public function setPatientId(?int $patient_id): void
    {
        $this->patient_id = $patient_id;
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getHeureDebut(): ?\DateTimeInterface
    {
        return $this->heureDebut;
    }

    public function setHeureDebut(\DateTimeInterface $heureDebut): self
    {
        $this->heureDebut = $heureDebut;

        return $this;
    }

    public function getHeureFin(): ?\DateTimeInterface
    {
        return $this->heureFin;
    }

    public function setHeureFin(\DateTimeInterface $heureFin): self
    {
        $this->heureFin = $heureFin;

        return $this;
    }

    public function getTypeRdv(): ?TypeRdv
    {
        return $this->typeRdv;
    }

    public function setTypeRdv(?TypeRdv $typeRdv): self
    {
        $this->typeRdv = $typeRdv;

        return $this;
    }

    public function getPatient(): ?Patient
    {
        return $this->Patient;
    }
    public function setPatient(?Patient $Patient): static
    {
        $this->Patient = $Patient;

        return $this;
    }
    

    


    public function getDoctor(): ?Doctor
    {
        return $this->Doctor;
    }

    public function setDoctor(?Doctor $Doctor): static
    {
        $this->Doctor = $Doctor;

        return $this;
    }



    
}
