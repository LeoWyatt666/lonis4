<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AcAchievsLang
 *
 * @ORM\Table(name="ac_achievs_lang")
 * @ORM\Entity
 */
class AcAchievsLang
{
    /**
     * @var int
     *
     * @ORM\Column(name="lid", type="integer", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $lid;

    /**
     * @var int
     *
     * @ORM\Column(name="achievid", type="integer", nullable=false)
     */
    private $achievid;

    /**
     * @var string|null
     *
     * @ORM\Column(name="lang", type="string", length=16, nullable=true)
     */
    private $lang;

    /**
     * @var string|null
     *
     * @ORM\Column(name="name", type="string", length=256, nullable=true)
     */
    private $name;

    /**
     * @var string|null
     *
     * @ORM\Column(name="desc", type="string", length=256, nullable=true)
     */
    private $desc;

    public function getLid(): ?int
    {
        return $this->lid;
    }

    public function getAchievid(): ?int
    {
        return $this->achievid;
    }

    public function setAchievid(int $achievid): self
    {
        $this->achievid = $achievid;

        return $this;
    }

    public function getLang(): ?string
    {
        return $this->lang;
    }

    public function setLang(?string $lang): self
    {
        $this->lang = $lang;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDesc(): ?string
    {
        return $this->desc;
    }

    public function setDesc(?string $desc): self
    {
        $this->desc = $desc;

        return $this;
    }


}
