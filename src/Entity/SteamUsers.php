<?php

namespace App\Entity;

use Knojector\SteamAuthenticationBundle\User\AbstractSteamUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\Role\Role;

/**
 * @author Knojector <dev@404-labs.xyz>
 *
 * @ORM\Entity()
 */
class SteamUsers extends AbstractSteamUser
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    public function __construct()
    {
        $this->roles = [];
    }
    
    /**
     * @return array
     */
    public function getRoles(): array
    {
        $roles = [];
        foreach ($this->roles as $role) {
            $roles[] = new Role($role);
        }

        return $roles;
    }

    public function getId(): ?int
    {
        return $this->id;
    }
}