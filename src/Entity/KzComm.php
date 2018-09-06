<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * KzComm
 *
 * @ORM\Table(name="kz_comm")
 * @ORM\Entity
 */
class KzComm
{
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=8, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $name;

    /**
     * @var int
     *
     * @ORM\Column(name="sort", type="integer", nullable=false)
     */
    private $sort;

    /**
     * @var string
     *
     * @ORM\Column(name="fullname", type="string", length=16, nullable=false)
     */
    private $fullname;

    /**
     * @var string|null
     *
     * @ORM\Column(name="url", type="string", length=64, nullable=true)
     */
    private $url;

    /**
     * @var string|null
     *
     * @ORM\Column(name="demos", type="string", length=128, nullable=true)
     */
    private $demos;

    /**
     * @var string|null
     *
     * @ORM\Column(name="image", type="string", length=256, nullable=true)
     */
    private $image;

    /**
     * @var string|null
     *
     * @ORM\Column(name="download", type="string", length=256, nullable=true)
     */
    private $download;

    /**
     * @var string|null
     *
     * @ORM\Column(name="mapinfo", type="string", length=256, nullable=true)
     */
    private $mapinfo;

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getSort(): ?int
    {
        return $this->sort;
    }

    public function setSort(int $sort): self
    {
        $this->sort = $sort;

        return $this;
    }

    public function getFullname(): ?string
    {
        return $this->fullname;
    }

    public function setFullname(string $fullname): self
    {
        $this->fullname = $fullname;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(?string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getDemos(): ?string
    {
        return $this->demos;
    }

    public function setDemos(?string $demos): self
    {
        $this->demos = $demos;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getDownload(): ?string
    {
        return $this->download;
    }

    public function setDownload(?string $download): self
    {
        $this->download = $download;

        return $this;
    }

    public function getMapinfo(): ?string
    {
        return $this->mapinfo;
    }

    public function setMapinfo(?string $mapinfo): self
    {
        $this->mapinfo = $mapinfo;

        return $this;
    }


}
