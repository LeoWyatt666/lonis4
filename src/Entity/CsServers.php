<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CsServers
 *
 * @ORM\Table(name="cs_servers", indexes={@ORM\Index(name="FK_cs_servers_cs_servers_mod", columns={"mod"})})
 * @ORM\Entity
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
     * @var int
     *
     * @ORM\Column(name="mod", type="integer", nullable=false, options={"unsigned"=true})
     */
    private $mod;

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
    private $vip;

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


}
