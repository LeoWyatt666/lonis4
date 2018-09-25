<?php

namespace App\Controller\Players;

use App\Entity\CsPlayers;
use App\Form\CsPlayersType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @Route("/admin/players")
 */
class AdminPlayersController extends AbstractController
{
    /**
     * @Route("/", name="admin_players_index", methods="GET")
     */
    public function index(
        Request $request, 
        PaginatorInterface $paginator
    ): Response
    {   
        // get request
        $search = $request->query->get('search');
        $page = $request->query->getInt('page', 1);

        // get query
        $query = $this->getDoctrine()
            ->getRepository(CsPlayers::class)
            ->queryAll($search);

        // get result
        $pagination = $paginator->paginate($query, $page, 20);

        if($pagination->getPage() > $pagination->getPageCount()) {
            throw $this->createNotFoundException();
        }

        // render
        return $this->render('controller/players/admin_players/index.html.twig', [
            'title' => 'Admin :: Players',
            'pagination' => $pagination,
            'search' => $search,
        ]);
    }

    /**
     * @Route("/new", name="admin_players_new", methods="GET|POST")
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

            return $this->redirectToRoute('admin_players_index');
        }

        return $this->render('controller/players/admin_players/new.html.twig', [
            'title' => 'Admin :: Players :: New',
            'player' => $csPlayer,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_players_show", methods="GET")
     */
    public function show(CsPlayers $csPlayer): Response
    {
        return $this->render('controller/players/admin_players/show.html.twig', [
            'title' => 'Admin :: Players :: '.$csPlayer->getUsername(),
            'player' => $csPlayer,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_players_edit", methods="GET|POST")
     */
    public function edit(Request $request, CsPlayers $csPlayer): Response
    {
        $form = $this->createForm(CsPlayersType::class, $csPlayer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_players_edit', ['id' => $csPlayer->getId()]);
        }

        return $this->render('controller/players/admin_players/edit.html.twig', [
            'title' => 'Admin :: Players :: '.$csPlayer->getUsername(),
            'player' => $csPlayer,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_players_delete", methods="DELETE")
     */
    public function delete(Request $request, CsPlayers $csPlayer): Response
    {
        if ($this->isCsrfTokenValid('delete'.$csPlayer->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($csPlayer);
            $em->flush();
        }

        return $this->redirectToRoute('admin_players_index');
    }
}
