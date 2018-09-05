<?php

namespace App\Controller\Records;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class RecordsController extends AbstractController
{
    /**
     * @Route("/records/records", name="records_records")
     */
    public function index()
    {
        return $this->render('records/records/index.html.twig', [
            'controller_name' => 'RecordsController',
        ]);
    }
}
