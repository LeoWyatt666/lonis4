<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AcAchievsPlayers
 *
 * @ORM\Table(name="ac_achievs_players")
 * @ORM\Entity
 */
class AcAchievsPlayers
{
    /**
     * @var int
     *
     * @ORM\Column(name="playerId", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $playerid;

    /**
     * @var int
     *
     * @ORM\Column(name="achievId", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $achievid;

    /**
     * @var int
     *
     * @ORM\Column(name="progress", type="integer", nullable=false)
     */
    private $progress;

    /**
     * @var int
     *
     * @ORM\Column(name="unlocked", type="integer", nullable=false)
     */
    private $unlocked;


}
