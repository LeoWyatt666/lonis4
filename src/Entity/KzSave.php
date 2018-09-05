<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * KzSave
 *
 * @ORM\Table(name="kz_save")
 * @ORM\Entity
 */
class KzSave
{
    /**
     * @var string
     *
     * @ORM\Column(name="map", type="string", length=50, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $map;

    /**
     * @var int
     *
     * @ORM\Column(name="player", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $player;

    /**
     * @var int
     *
     * @ORM\Column(name="posx", type="integer", nullable=false)
     */
    private $posx;

    /**
     * @var int
     *
     * @ORM\Column(name="posy", type="integer", nullable=false)
     */
    private $posy;

    /**
     * @var int
     *
     * @ORM\Column(name="posz", type="integer", nullable=false)
     */
    private $posz;

    /**
     * @var int
     *
     * @ORM\Column(name="time", type="integer", nullable=false)
     */
    private $time;

    /**
     * @var int
     *
     * @ORM\Column(name="angle_x", type="integer", nullable=false)
     */
    private $angleX;

    /**
     * @var int
     *
     * @ORM\Column(name="angle_y", type="integer", nullable=false)
     */
    private $angleY;

    /**
     * @var int
     *
     * @ORM\Column(name="angle_z", type="integer", nullable=false)
     */
    private $angleZ;

    /**
     * @var int
     *
     * @ORM\Column(name="cp", type="integer", nullable=false, options={"unsigned"=true})
     */
    private $cp = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="go_cp", type="integer", nullable=false, options={"unsigned"=true})
     */
    private $goCp = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="weapon", type="integer", nullable=false, options={"unsigned"=true})
     */
    private $weapon;

    public function getMap(): ?string
    {
        return $this->map;
    }

    public function getPlayer(): ?int
    {
        return $this->player;
    }

    public function getPosx(): ?int
    {
        return $this->posx;
    }

    public function setPosx(int $posx): self
    {
        $this->posx = $posx;

        return $this;
    }

    public function getPosy(): ?int
    {
        return $this->posy;
    }

    public function setPosy(int $posy): self
    {
        $this->posy = $posy;

        return $this;
    }

    public function getPosz(): ?int
    {
        return $this->posz;
    }

    public function setPosz(int $posz): self
    {
        $this->posz = $posz;

        return $this;
    }

    public function getTime(): ?int
    {
        return $this->time;
    }

    public function setTime(int $time): self
    {
        $this->time = $time;

        return $this;
    }

    public function getAngleX(): ?int
    {
        return $this->angleX;
    }

    public function setAngleX(int $angleX): self
    {
        $this->angleX = $angleX;

        return $this;
    }

    public function getAngleY(): ?int
    {
        return $this->angleY;
    }

    public function setAngleY(int $angleY): self
    {
        $this->angleY = $angleY;

        return $this;
    }

    public function getAngleZ(): ?int
    {
        return $this->angleZ;
    }

    public function setAngleZ(int $angleZ): self
    {
        $this->angleZ = $angleZ;

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


}
