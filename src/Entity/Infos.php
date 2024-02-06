<?php

namespace App\Entity;

use App\Repository\InfosRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InfosRepository::class)]
class Infos
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $carte = null;


//



    #[ORM\Column(length: 255)]
    private ?string $presentation = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $horaire = null;

    #[ORM\Column]
    private ?float $tarif = null;

    #[ORM\OneToOne(inversedBy: 'infos', cascade: ['persist', 'remove'])]
    private ?Doctor $Doctor = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCarte(): ?string
    {
        return $this->carte;
    }

    public function setCarte(string $carte): static
    {
        $this->carte = $carte;

        return $this;
    }

    public function getPresentation(): ?string
    {
        return $this->presentation;
    }

    public function setPresentation(string $presentation): static
    {
        $this->presentation = $presentation;

        return $this;
    }

    public function getHoraire(): ?\DateTimeInterface
    {
        return $this->horaire;
    }

    public function setHoraire(?\DateTimeInterface $horaire): static
    {
        $this->horaire = $horaire;

        return $this;
    }

    public function getTarif(): ?float
    {
        return $this->tarif;
    }

    public function setTarif(float $tarif): static
    {
        $this->tarif = $tarif;

        return $this;
    }

    public function getDoctor(): ?Doctor
    {
        return $this->doctor;
    }

    public function setDoctor(Doctor $doctor): static
    {
        $this->doctor = $doctor;

        return $this;
    }
}
