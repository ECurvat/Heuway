<?php

namespace App\Entity;

use DateTimeInterface;

// pas d'ORM ici car pas d'injection dans la base de données
// entité créée manuellement et pas en ligne de commandes car pas dans la base de données
class ServiceSearch {

    /**
     * var DateTimeInterface|null
     */
    private $debut = null;

    /**
     * var DateTimeInterface|null
     */
    private $fin = null;

    /**
     * var string|null
     */
    private $depot;

    /**
     * var int|null
     */
    private $ligne;

    /**
     * @var DateTimeInterface|null
     */
    public function getDebut(): ?\DateTimeInterface
    {
        return $this->debut;
    }

    /**
     * @var int|null
     */
    public function getFin(): ?\DateTimeInterface
    {
        return $this->fin;
    }

    /**
     * @var string|null
     */
    public function getDepot(): ?string
    {
        return $this->depot;
    }

    /**
     * @var int|null
     */
    public function getLigne(): ?int
    {
        return $this->ligne;
    }

    // Setters
    /**
     * @param DateTimeInterface $debut
     * @return ServiceSearch
     */
    public function setDebut(?\DateTimeInterface $debut): self
    {
        $this->debut = $debut;

        return $this;
    }

    /**
     * @param DateTimeInterface $fin
     * @return ServiceSearch
     */
    public function setFin(?\DateTimeInterface $fin): self
    {
        $datetime = new \DateTime();
        $datetime->setTimestamp($fin->getTimestamp());
        $fin = $datetime;
        $fin = $fin->modify('+1 day');
        $this->fin = $fin;

        return $this;
    }

    /**
     * @param string $depot
     * @return ServiceSearch
     */
    public function setDepot(string $depot): self
    {
        $this->depot = $depot;

        return $this;
    }

    /**
     * @param int $ligne
     * @return ServiceSearch
     */
    public function setLigne(string $ligne): self
    {
        $this->ligne = $ligne;

        return $this;
    }

}