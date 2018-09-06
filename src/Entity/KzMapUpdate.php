<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * KzMapUpdate
 *
 * @ORM\Table(name="kz_map_update")
 * @ORM\Entity
 */
class KzMapUpdate
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
     * @var int|null
     *
     * @ORM\Column(name="diff", type="integer", nullable=true, options={"unsigned"=true})
     */
    private $diff = '0';

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


}
