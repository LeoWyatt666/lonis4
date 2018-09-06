<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * KzWeapons
 *
 * @ORM\Table(name="kz_weapons")
 * @ORM\Entity
 */
class KzWeapons
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
     * @ORM\Column(name="wname", type="string", length=16, nullable=false)
     */
    private $wname;

    /**
     * @var string|null
     *
     * @ORM\Column(name="fullname", type="string", length=32, nullable=true)
     */
    private $fullname;

    /**
     * @var string|null
     *
     * @ORM\Column(name="info", type="text", length=65535, nullable=true)
     */
    private $info;

    /**
     * @var int|null
     *
     * @ORM\Column(name="pspeed", type="integer", nullable=true)
     */
    private $pspeed;

    /**
     * @var bool
     *
     * @ORM\Column(name="best", type="boolean", nullable=false)
     */
    private $best = '0';


}
