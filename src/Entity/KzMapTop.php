<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * KzMapTop
 *
 * @ORM\Table(name="kz_map_top", indexes={@ORM\Index(name="weapon", columns={"weapon"}), @ORM\Index(name="map", columns={"map"}), @ORM\Index(name="player", columns={"player"}), @ORM\Index(name="time", columns={"time"})})
 * @ORM\Entity
 */
class KzMapTop
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


}
