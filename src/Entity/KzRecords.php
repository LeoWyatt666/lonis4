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


}
