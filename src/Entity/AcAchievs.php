<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AcAchievs
 *
 * @ORM\Table(name="ac_achievs")
 * @ORM\Entity
 */
class AcAchievs
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
     * @ORM\Column(name="type", type="string", length=40, nullable=false)
     */
    private $type;

    /**
     * @var int
     *
     * @ORM\Column(name="count", type="integer", nullable=false, options={"unsigned"=true})
     */
    private $count;

    /**
     * @var string
     *
     * @ORM\Column(name="icon", type="string", length=50, nullable=false, options={"fixed"=true})
     */
    private $icon;


}
