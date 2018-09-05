<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * KzMap
 *
 * @ORM\Table(name="kz_map", indexes={@ORM\Index(name="FK_kz_map_kz_diff", columns={"diff"})})
 * @ORM\Entity
 */
class KzMap
{
    /**
     * @var string
     *
     * @ORM\Column(name="mapname", type="string", length=64, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $mapname;

    /**
     * @var string|null
     *
     * @ORM\Column(name="type", type="string", length=32, nullable=true)
     */
    private $type;

    /**
     * @var int|null
     *
     * @ORM\Column(name="sc", type="integer", nullable=true, options={"unsigned"=true})
     */
    private $sc;

    /**
     * @var string|null
     *
     * @ORM\Column(name="authors", type="string", length=128, nullable=true)
     */
    private $authors;

    /**
     * @var string|null
     *
     * @ORM\Column(name="date_old", type="string", length=16, nullable=true)
     */
    private $dateOld;

    /**
     * @var string|null
     *
     * @ORM\Column(name="comm", type="string", length=8, nullable=true)
     */
    private $comm;

    /**
     * @var int
     *
     * @ORM\Column(name="locked", type="integer", nullable=false)
     */
    private $locked = '0';

    /**
     * @var \KzDiff
     *
     * @ORM\ManyToOne(targetEntity="KzDiff")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="diff", referencedColumnName="id")
     * })
     */
    private $diff;

    public function getMapname(): ?string
    {
        return $this->mapname;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getSc(): ?int
    {
        return $this->sc;
    }

    public function setSc(?int $sc): self
    {
        $this->sc = $sc;

        return $this;
    }

    public function getAuthors(): ?string
    {
        return $this->authors;
    }

    public function setAuthors(?string $authors): self
    {
        $this->authors = $authors;

        return $this;
    }

    public function getDateOld(): ?string
    {
        return $this->dateOld;
    }

    public function setDateOld(?string $dateOld): self
    {
        $this->dateOld = $dateOld;

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

    public function getLocked(): ?int
    {
        return $this->locked;
    }

    public function setLocked(int $locked): self
    {
        $this->locked = $locked;

        return $this;
    }

    public function getDiff(): ?KzDiff
    {
        return $this->diff;
    }

    public function setDiff(?KzDiff $diff): self
    {
        $this->diff = $diff;

        return $this;
    }


}
