<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * KzLjsRecs
 *
 * @ORM\Table(name="kz_ljs_recs")
 * @ORM\Entity
 */
class KzLjsRecs
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="plname", type="string", length=32, nullable=false)
     */
    private $plname;

    /**
     * @var string
     *
     * @ORM\Column(name="distance", type="string", length=8, nullable=false)
     */
    private $distance;

    /**
     * @var string
     *
     * @ORM\Column(name="block", type="string", length=3, nullable=false)
     */
    private $block;

    /**
     * @var string
     *
     * @ORM\Column(name="prestrafe", type="string", length=8, nullable=false)
     */
    private $prestrafe;

    /**
     * @var string
     *
     * @ORM\Column(name="speed", type="string", length=8, nullable=false)
     */
    private $speed;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=8, nullable=false)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="country", type="string", length=2, nullable=false)
     */
    private $country;

    /**
     * @var string
     *
     * @ORM\Column(name="comm", type="string", length=8, nullable=false)
     */
    private $comm;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPlname(): ?string
    {
        return $this->plname;
    }

    public function setPlname(string $plname): self
    {
        $this->plname = $plname;

        return $this;
    }

    public function getDistance(): ?string
    {
        return $this->distance;
    }

    public function setDistance(string $distance): self
    {
        $this->distance = $distance;

        return $this;
    }

    public function getBlock(): ?string
    {
        return $this->block;
    }

    public function setBlock(string $block): self
    {
        $this->block = $block;

        return $this;
    }

    public function getPrestrafe(): ?string
    {
        return $this->prestrafe;
    }

    public function setPrestrafe(string $prestrafe): self
    {
        $this->prestrafe = $prestrafe;

        return $this;
    }

    public function getSpeed(): ?string
    {
        return $this->speed;
    }

    public function setSpeed(string $speed): self
    {
        $this->speed = $speed;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

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

    public function getComm(): ?string
    {
        return $this->comm;
    }

    public function setComm(string $comm): self
    {
        $this->comm = $comm;

        return $this;
    }


}
