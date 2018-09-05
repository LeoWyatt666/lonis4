<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * KzRecords
 *
 * @ORM\Table(name="kz_records", uniqueConstraints={@ORM\UniqueConstraint(name="row", columns={"comm", "map", "mappath", "time"})}, indexes={@ORM\Index(name="map", columns={"map"})})
 * @ORM\Entity
 */
class KzRecords
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
     * @ORM\Column(name="map", type="string", length=64, nullable=false)
     */
    private $map;

    /**
     * @var string|null
     *
     * @ORM\Column(name="mappath", type="string", length=16, nullable=true)
     */
    private $mappath;

    /**
     * @var string|null
     *
     * @ORM\Column(name="time", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $time;

    /**
     * @var string|null
     *
     * @ORM\Column(name="player", type="string", length=32, nullable=true)
     */
    private $player;

    /**
     * @var string|null
     *
     * @ORM\Column(name="country", type="string", length=8, nullable=true)
     */
    private $country;

    /**
     * @var string|null
     *
     * @ORM\Column(name="comm", type="string", length=8, nullable=true)
     */
    private $comm;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMap(): ?string
    {
        return $this->map;
    }

    public function setMap(string $map): self
    {
        $this->map = $map;

        return $this;
    }

    public function getMappath(): ?string
    {
        return $this->mappath;
    }

    public function setMappath(?string $mappath): self
    {
        $this->mappath = $mappath;

        return $this;
    }

    public function getTime()
    {
        return $this->time;
    }

    public function setTime($time): self
    {
        $this->time = $time;

        return $this;
    }

    public function getPlayer(): ?string
    {
        return $this->player;
    }

    public function setPlayer(?string $player): self
    {
        $this->player = $player;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(?string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getComm(): ?string
    {
        return $this->comm;
    }

    public function setComm(?string $comm): self
    {
        $this->comm = $comm;

        return $this;
    }


}
