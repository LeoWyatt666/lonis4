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

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMap(): ?string
    {
        return $this->map;
    }

    public function setMap(string $map): self
    {
        $this->map = $map;

        return $this;
    }

    public function getPlayer1(): ?int
    {
        return $this->player1;
    }

    public function setPlayer1(int $player1): self
    {
        $this->player1 = $player1;

        return $this;
    }

    public function getPlayer2(): ?int
    {
        return $this->player2;
    }

    public function setPlayer2(int $player2): self
    {
        $this->player2 = $player2;

        return $this;
    }

    public function getResult1(): ?int
    {
        return $this->result1;
    }

    public function setResult1(int $result1): self
    {
        $this->result1 = $result1;

        return $this;
    }

    public function getResult2(): ?int
    {
        return $this->result2;
    }

    public function setResult2(int $result2): self
    {
        $this->result2 = $result2;

        return $this;
    }


}
