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


}
