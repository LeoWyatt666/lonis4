<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * KzDuel
 *
 * @ORM\Table(name="kz_duel")
 * @ORM\Entity
 */
class KzDuel
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
     * @ORM\Column(name="map", type="string", length=64, nullable=false)
     */
    private $map;

    /**
     * @var int
     *
     * @ORM\Column(name="player1", type="integer", nullable=false, options={"unsigned"=true})
     */
    private $player1;

    /**
     * @var int
     *
     * @ORM\Column(name="player2", type="integer", nullable=false, options={"unsigned"=true})
     */
    private $player2;

    /**
     * @var int
     *
     * @ORM\Column(name="result1", type="integer", nullable=false)
     */
    private $result1;

    /**
     * @var int
     *
     * @ORM\Column(name="result2", type="integer", nullable=false)
     */
    private $result2;


}
