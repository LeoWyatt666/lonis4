<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * KzLjsRecs
 *
 * @ORM\Table(name="kz_ljs_recs")
 * @ORM\Entity
 */
class KzLjsRecs
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
     * @ORM\Column(name="plname", type="string", length=32, nullable=false)
     */
    private $plname;

    /**
     * @var string
     *
     * @ORM\Column(name="distance", type="string", length=8, nullable=false)
     */
    private $distance;

    /**
     * @var string
     *
     * @ORM\Column(name="block", type="string", length=3, nullable=false)
     */
    private $block;

    /**
     * @var string
     *
     * @ORM\Column(name="prestrafe", type="string", length=8, nullable=false)
     */
    private $prestrafe;

    /**
     * @var string
     *
     * @ORM\Column(name="speed", type="string", length=8, nullable=false)
     */
    private $speed;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=8, nullable=false)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="country", type="string", length=2, nullable=false)
     */
    private $country;

    /**
     * @var string
     *
     * @ORM\Column(name="comm", type="string", length=8, nullable=false)
     */
    private $comm;


}
