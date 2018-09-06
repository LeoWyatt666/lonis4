<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CsPlayersVars
 *
 * @ORM\Table(name="cs_players_vars")
 * @ORM\Entity
 */
class CsPlayersVars
{
    /**
     * @var string
     *
     * @ORM\Column(name="key", type="string", length=50, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $key;

    /**
     * @var int
     *
     * @ORM\Column(name="playerId", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $playerid;

    /**
     * @var string
     *
     * @ORM\Column(name="value", type="string", length=512, nullable=false)
     */
    private $value;


}
