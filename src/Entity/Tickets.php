<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tickets
 *
 * @ORM\Table(name="tickets")
 * @ORM\Entity
 */
class Tickets
{
    /**
     * @var int
     *
     * @ORM\Column(name="idtickets", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idtickets;

    /**
     * @var string
     *
     * @ORM\Column(name="request", type="string", length=500, nullable=false)
     */
    private $request;

    /**
     * @var string
     *
     * @ORM\Column(name="outcome", type="string", length=15, nullable=false, options={"default"="Unresolved"})
     */
    private $outcome = 'Unresolved';

    public function getIdtickets(): ?int
    {
        return $this->idtickets;
    }

    public function getRequest(): ?string
    {
        return $this->request;
    }

    public function setRequest(string $request): self
    {
        $this->request = $request;

        return $this;
    }

    public function getOutcome(): ?string
    {
        return $this->outcome;
    }

    public function setOutcome(string $outcome): self
    {
        $this->outcome = $outcome;

        return $this;
    }


}
