<?php

namespace App\Controller\Kreedz;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class KreedzController extends AbstractController
{
    /**
     * @Route("/kreedz/kreedz", name="kreedz_kreedz")
     */
    public function index()
    {
        return $this->render('kreedz/kreedz/index.html.twig', [
            'controller_name' => 'KreedzController',
        ]);
    }
}
