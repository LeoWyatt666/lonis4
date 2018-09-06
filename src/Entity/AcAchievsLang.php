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


}
