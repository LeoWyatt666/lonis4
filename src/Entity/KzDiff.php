<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * KzDiff
 *
 * @ORM\Table(name="kz_diff")
 * @ORM\Entity
 */
class KzDiff
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
     * @ORM\Column(name="dname", type="string", length=32, nullable=false)
     */
    private $dname;

    /**
     * @var string
     *
     * @ORM\Column(name="dpname", type="string", length=32, nullable=false)
     */
    private $dpname;

    /**
     * @var int
     *
     * @ORM\Column(name="ddot", type="integer", nullable=false)
     */
    private $ddot;

    /**
     * @var string
     *
     * @ORM\Column(name="dcolor", type="string", length=16, nullable=false, options={"fixed"=true})
     */
    private $dcolor;

    /**
     * @var string
     *
     * @ORM\Column(name="icon", type="string", length=32, nullable=false, options={"fixed"=true})
     */
    private $icon;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDname(): ?string
    {
        return $this->dname;
    }

    public function setDname(string $dname): self
    {
        $this->dname = $dname;

        return $this;
    }

    public function getDpname(): ?string
    {
        return $this->dpname;
    }

    public function setDpname(string $dpname): self
    {
        $this->dpname = $dpname;

        return $this;
    }

    public function getDdot(): ?int
    {
        return $this->ddot;
    }

    public function setDdot(int $ddot): self
    {
        $this->ddot = $ddot;

        return $this;
    }

    public function getDcolor(): ?string
    {
        return $this->dcolor;
    }

    public function setDcolor(string $dcolor): self
    {
        $this->dcolor = $dcolor;

        return $this;
    }

    public function getIcon(): ?string
    {
        return $this->icon;
    }

    public function setIcon(string $icon): self
    {
        $this->icon = $icon;

        return $this;
    }


}
