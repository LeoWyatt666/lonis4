<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CsServersMod
 *
 * @ORM\Table(name="cs_servers_mod")
 * @ORM\Entity
 */
class CsServersMod
{
    /**
     * @var int
     *
     * @ORM\Column(name="mid", type="integer", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $mid;

    /**
     * @var string
     *
     * @ORM\Column(name="modname", type="string", length=16, nullable=false)
     */
    private $modname;


}
