<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * KzLjsType
 *
 * @ORM\Table(name="kz_ljs_type")
 * @ORM\Entity
 */
class KzLjsType
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
     * @ORM\Column(name="sort", type="integer", nullable=false, options={"unsigned"=true})
     */
    private $sort = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="fullname", type="string", length=32, nullable=false)
     */
    private $fullname = '0';

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getSort(): ?int
    {
        return $this->sort;
    }

    public function setSort(int $sort): self
    {
        $this->sort = $sort;

        return $this;
    }

    public function getFullname(): ?string
    {
        return $this->fullname;
    }

    public function setFullname(string $fullname): self
    {
        $this->fullname = $fullname;

        return $this;
    }


}
