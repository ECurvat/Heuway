<?php

namespace App\Entity;

use App\Repository\ServiceRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ServiceRepository::class)]
class Service
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    #[Assert\NotNull]
    private ?int $numero_groupe = null;

    #[ORM\Column(length: 5)]
    #[Assert\NotNull]
    private ?string $depot = null;

    #[ORM\Column(length: 1)]
    #[Assert\NotNull]
    private ?int $ligne = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Assert\NotNull]
    private ?\DateTimeInterface $debut = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Assert\NotNull]
    private ?\DateTimeInterface $fin = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $pause = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $dispo = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $deplacement = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $coupure = null;

    #[ORM\ManyToOne(targetEntity: Contrat::class, inversedBy: 'services')]
    private ?\App\Entity\Contrat $contrat;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumeroGroupe(): ?int
    {
        return $this->numero_groupe;
    }

    public function setNumeroGroupe(int $numero_groupe): self
    {
        $this->numero_groupe = $numero_groupe;

        return $this;
    }

    public function getDepot(): ?string
    {
        return $this->depot;
    }

    public function setDepot(string $depot): self
    {
        $this->depot = $depot;

        return $this;
    }

    public function getLigne(): ?int
    {
        return $this->ligne;
    }

    public function setLigne(string $ligne): self
    {
        $this->ligne = $ligne;

        return $this;
    }

    public function getDebut(): ?\DateTimeInterface
    {
        return $this->debut;
    }

    public function setDebut(\DateTimeInterface $debut): self
    {
        $this->debut = $debut;

        return $this;
    }

    public function getFin(): ?\DateTimeInterface
    {
        return $this->fin;
    }

    public function setFin(\DateTimeInterface $fin): self
    {
        $this->fin = $fin;

        return $this;
    }

    public function getPause(): ?\DateTimeInterface
    {
        return $this->pause;
    }

    public function setPause(\DateTimeInterface $pause): self
    {
        $this->pause = $pause;

        return $this;
    }

    public function getDispo(): ?\DateTimeInterface
    {
        return $this->dispo;
    }

    public function setDispo(\DateTimeInterface $dispo): self
    {
        $this->dispo = $dispo;

        return $this;
    }

    public function getDeplacement(): ?\DateTimeInterface
    {
        return $this->deplacement;
    }

    public function setDeplacement(\DateTimeInterface $deplacement): self
    {
        $this->deplacement = $deplacement;

        return $this;
    }

    public function getCoupure(): ?\DateTimeInterface
    {
        return $this->coupure;
    }

    public function setCoupure(\DateTimeInterface $coupure): self
    {
        $this->coupure = $coupure;

        return $this;
    }

    public function getContrat(): ?Contrat
    {
        return $this->contrat;
    }

    public function setContrat(?Contrat $contrat): self
    {
        $this->contrat = $contrat;

        return $this;
    }
}
