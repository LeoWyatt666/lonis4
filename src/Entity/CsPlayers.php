<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * CsPlayers
 *
 * @ORM\Table(name="cs_players", uniqueConstraints={@ORM\UniqueConstraint(name="username", columns={"username"}), @ORM\UniqueConstraint(name="name_steam_id", columns={"username", "steam_id"})}, indexes={@ORM\Index(name="country", columns={"country"})})
 * @ORM\Entity(repositoryClass="App\Repository\CsPlayersRepository")
 */
class CsPlayers implements UserInterface, \Serializable
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
     * @ORM\Column(name="username", type="string", length=32, nullable=false)
     */
    private $username;

    /**
     * @var string|null
     *
     * @ORM\Column(name="password", type="string", length=50, nullable=true)
     */
    private $password = '';

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=254, nullable=false)
     */
    private $email = '';

    /**
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $isActive;

    /**
     * @var string|null
     *
     * @ORM\Column(name="ip", type="string", length=32, nullable=true)
     */
    private $ip;

    /**
     * @var string|null
     *
     * @ORM\Column(name="lastIp", type="string", length=20, nullable=true)
     */
    private $lastip;

    /**
     * @var int|null
     *
     * @ORM\Column(name="lastTime", type="integer", nullable=true)
     */
    private $lasttime;

    /**
     * @var string|null
     *
     * @ORM\Column(name="country", type="string", length=5, nullable=true)
     */
    private $country;

    /**
     * @var int|null
     *
     * @ORM\Column(name="onlineTime", type="integer", nullable=true)
     */
    private $onlinetime;

    /**
     * @var string|null
     *
     * @ORM\Column(name="steam_id", type="string", length=32, nullable=true)
     */
    private $steamId;

    /**
     * @var string|null
     *
     * @ORM\Column(name="amxx_flags", type="string", length=34, nullable=true)
     */
    private $amxxFlags;

    /**
     * @var int|null
     *
     * @ORM\Column(name="flags", type="integer", nullable=true)
     */
    private $flags = '0';

    /**
     * @var int|null
     *
     * @ORM\Column(name="icq", type="integer", nullable=true)
     */
    private $icq;

    /**
     * @var int|null
     *
     * @ORM\Column(name="steam_id_64", type="bigint", nullable=true)
     */
    private $steamId64;

    public function __construct()
    {
        $this->isActive = true;
        // may not be needed, see section on salt below
        // $this->salt = md5(uniqid('', true));
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getSalt()
    {
        // you *may* need a real salt depending on your encoder
        // see section on salt below
        return null;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getRoles()
    {
        return array('ROLE_USER');
    }

    public function eraseCredentials()
    {
    }
    
    public function getIp(): ?string
    {
        return $this->ip;
    }

    public function setIp(?string $ip): self
    {
        $this->ip = $ip;

        return $this;
    }

    public function getLastip(): ?string
    {
        return $this->lastip;
    }

    public function setLastip(?string $lastip): self
    {
        $this->lastip = $lastip;

        return $this;
    }

    public function getLasttime(): ?int
    {
        return $this->lasttime;
    }

    public function setLasttime(?int $lasttime): self
    {
        $this->lasttime = $lasttime;

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

    public function getOnlinetime(): ?int
    {
        return $this->onlinetime;
    }

    public function setOnlinetime(?int $onlinetime): self
    {
        $this->onlinetime = $onlinetime;

        return $this;
    }

    public function getSteamId(): ?string
    {
        return $this->steamId;
    }

    public function setSteamId(?string $steamId): self
    {
        $this->steamId = $steamId;

        return $this;
    }

    public function getAmxxFlags(): ?string
    {
        return $this->amxxFlags;
    }

    public function setAmxxFlags(?string $amxxFlags): self
    {
        $this->amxxFlags = $amxxFlags;

        return $this;
    }

    public function getFlags(): ?int
    {
        return $this->flags;
    }

    public function setFlags(?int $flags): self
    {
        $this->flags = $flags;

        return $this;
    }

    public function getIcq(): ?int
    {
        return $this->icq;
    }

    public function setIcq(?int $icq): self
    {
        $this->icq = $icq;

        return $this;
    }

    public function getSteamId64(): ?int
    {
        return $this->steamId64;
    }

    public function setSteamId64(?int $steamId64): self
    {
        $this->steamId64 = $steamId64;

        return $this;
    }

    /** @see \Serializable::serialize() */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password,
            // see section on salt below
            // $this->salt,
        ));
    }

    /** @see \Serializable::unserialize() */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->username,
            $this->password,
            // see section on salt below
            // $this->salt
        ) = unserialize($serialized, array('allowed_classes' => false));
    }

}
