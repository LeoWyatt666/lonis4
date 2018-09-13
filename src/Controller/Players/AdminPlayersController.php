<?php

namespace App\Controller\Players;

use App\Entity\CsPlayers;
use App\Form\CsPlayersType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/players")
 */
class AdminPlayersController extends AbstractController
{
    /**
     * @Route("/", name="cs_players_index", methods="GET")
     */
    public function index(): Response
    {
        return $this->render('cs_players/index.html.twig', 
            ['cs_players' => $this->getDoctrine()->getRepository(CsPlayers::class)->findAll()]);
    }

    /**
     * @Route("/new", name="cs_players_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $csPlayer = new CsPlayers();
        $form = $this->createForm(CsPlayersType::class, $csPlayer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($csPlayer);
            $em->flush();

            return $this->redirectToRoute('cs_players_index');
        }

        return $this->render('cs_players/new.html.twig', [
            'cs_player' => $csPlayer,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="cs_players_show", methods="GET")
     */
    public function show(CsPlayers $csPlayer): Response
    {
        return $this->render('cs_players/show.html.twig', ['cs_player' => $csPlayer]);
    }

    /**
     * @Route("/{id}/edit", name="cs_players_edit", methods="GET|POST")
     */
    public function edit(Request $request, CsPlayers $csPlayer): Response
    {
        $form = $this->createForm(CsPlayersType::class, $csPlayer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('cs_players_edit', ['id' => $csPlayer->getId()]);
        }

        return $this->render('cs_players/edit.html.twig', [
            'cs_player' => $csPlayer,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="cs_players_delete", methods="DELETE")
     */
    public function delete(Request $request, CsPlayers $csPlayer): Response
    {
        if ($this->isCsrfTokenValid('delete'.$csPlayer->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($csPlayer);
            $em->flush();
        }

        return $this->redirectToRoute('cs_players_index');
    }
}
