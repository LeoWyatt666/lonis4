<?php

namespace App\Controller\Records;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class RecordsController extends AbstractController
{
    /**
     * @Route("/records/demos", name="records_demos")
     */
    public function demos()
    {
        return $this->render('records/records/demos.html.twig', [
            'title' => 'RecordsController',
        ]);
    }
}
