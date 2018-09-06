<?php

namespace App\Controller\Kreedz;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class KreedzController extends AbstractController
{
    /**
     * @Route("/kreedz/last", name="kreedz_last")
     */
    public function last()
    {
        return $this->render('kreedz/kreedz/last.html.twig', [
            'title' => 'KreedzController',
        ]);
    }
}
