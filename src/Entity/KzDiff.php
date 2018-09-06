<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * KzDiff
 *
 * @ORM\Table(name="kz_diff")
 * @ORM\Entity
 */
class KzDiff
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="dname", type="string", length=32, nullable=false)
     */
    private $dname;

    /**
     * @var string
     *
     * @ORM\Column(name="dpname", type="string", length=32, nullable=false)
     */
    private $dpname;

    /**
     * @var int
     *
     * @ORM\Column(name="ddot", type="integer", nullable=false)
     */
    private $ddot;

    /**
     * @var string
     *
     * @ORM\Column(name="dcolor", type="string", length=16, nullable=false, options={"fixed"=true})
     */
    private $dcolor;

    /**
     * @var string
     *
     * @ORM\Column(name="icon", type="string", length=32, nullable=false, options={"fixed"=true})
     */
    private $icon;


}
