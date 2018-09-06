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


}
