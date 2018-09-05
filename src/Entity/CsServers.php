<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CsServers
 *
 * @ORM\Table(name="cs_servers", indexes={@ORM\Index(name="FK_cs_servers_cs_servers_mod", columns={"mod"})})
 * @ORM\Entity(repositoryClass="App\Repository\CsServersRepository")
 */
class CsServers
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
     * @ORM\Column(name="addres", type="string", length=32, nullable=false)
     */
    private $addres;

    /**
     * @var bool
     *
     * @ORM\Column(name="vip", type="boolean", nullable=false)
     */
    private $vip = '0';

    /**
     * @var string|null
     *
     * @ORM\Column(name="name", type="string", length=32, nullable=true)
     */
    private $name;

    /**
     * @var string|null
     *
     * @ORM\Column(name="map", type="string", length=32, nullable=true)
     */
    private $map;

    /**
     * @var int|null
     *
     * @ORM\Column(name="players", type="integer", nullable=true)
     */
    private $players;

    /**
     * @var int|null
     *
     * @ORM\Column(name="max_players", type="integer", nullable=true)
     */
    private $maxPlayers;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="update", type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $update = 'CURRENT_TIMESTAMP';

    /**
     * @var \CsServersMod
     *
     * @ORM\ManyToOne(targetEntity="CsServersMod")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="mod", referencedColumnName="mid")
     * })
     */
    private $mod;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAddres(): ?string
    {
        return $this->addres;
    }

    public function setAddres(string $addres): self
    {
        $this->addres = $addres;

        return $this;
    }

    public function getVip(): ?bool
    {
        return $this->vip;
    }

    public function setVip(bool $vip): self
    {
        $this->vip = $vip;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getMap(): ?string
    {
        return $this->map;
    }

    public function setMap(?string $map): self
    {
        $this->map = $map;

        return $this;
    }

    public function getPlayers(): ?int
    {
        return $this->players;
    }

    public function setPlayers(?int $players): self
    {
        $this->players = $players;

        return $this;
    }

    public function getMaxPlayers(): ?int
    {
        return $this->maxPlayers;
    }

    public function setMaxPlayers(?int $maxPlayers): self
    {
        $this->maxPlayers = $maxPlayers;

        return $this;
    }

    public function getUpdate(): ?\DateTimeInterface
    {
        return $this->update;
    }

    public function setUpdate(\DateTimeInterface $update): self
    {
        $this->update = $update;

        return $this;
    }

    public function getMod(): ?CsServersMod
    {
        return $this->mod;
    }

    public function setMod(?CsServersMod $mod): self
    {
        $this->mod = $mod;

        return $this;
    }


}
