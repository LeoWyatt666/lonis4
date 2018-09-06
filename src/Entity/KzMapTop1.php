<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * KzMapTop1
 *
 * @ORM\Table(name="kz_map_top1", indexes={@ORM\Index(name="weapon", columns={"weapon"}), @ORM\Index(name="map", columns={"map"}), @ORM\Index(name="player", columns={"player"}), @ORM\Index(name="go_cp", columns={"go_cp"}), @ORM\Index(name="time", columns={"time"})})
 * @ORM\Entity
 */
class KzMapTop1
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
     * @var int
     *
     * @ORM\Column(name="player", type="integer", nullable=false, options={"unsigned"=true})
     */
    private $player;

    /**
     * @var string
     *
     * @ORM\Column(name="time", type="decimal", precision=10, scale=5, nullable=false)
     */
    private $time;

    /**
     * @var int
     *
     * @ORM\Column(name="cp", type="integer", nullable=false, options={"unsigned"=true})
     */
    private $cp;

    /**
     * @var int
     *
     * @ORM\Column(name="go_cp", type="integer", nullable=false, options={"unsigned"=true})
     */
    private $goCp;

    /**
     * @var int
     *
     * @ORM\Column(name="weapon", type="integer", nullable=false, options={"unsigned"=true})
     */
    private $weapon;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="time_add", type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $timeAdd = 'CURRENT_TIMESTAMP';

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

    public function getPlayer(): ?int
    {
        return $this->player;
    }

    public function setPlayer(int $player): self
    {
        $this->player = $player;

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

    public function getCp(): ?int
    {
        return $this->cp;
    }

    public function setCp(int $cp): self
    {
        $this->cp = $cp;

        return $this;
    }

    public function getGoCp(): ?int
    {
        return $this->goCp;
    }

    public function setGoCp(int $goCp): self
    {
        $this->goCp = $goCp;

        return $this;
    }

    public function getWeapon(): ?int
    {
        return $this->weapon;
    }

    public function setWeapon(int $weapon): self
    {
        $this->weapon = $weapon;

        return $this;
    }

    public function getTimeAdd(): ?\DateTimeInterface
    {
        return $this->timeAdd;
    }

    public function setTimeAdd(\DateTimeInterface $timeAdd): self
    {
        $this->timeAdd = $timeAdd;

        return $this;
    }


}
