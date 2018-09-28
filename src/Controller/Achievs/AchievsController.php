<?php

namespace App\Controller\Achievs;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\AcAchievs;
use App\Model\AchievsModel;
use Knp\Component\Pager\PaginatorInterface;
use Ornicar\GravatarBundle\GravatarApi;

/**
 * @Route("/achievs")
 */
class AchievsController extends AbstractController
{
    /**
     * @Route("/", name="achievs")
     */
    public function achievs(
        Request $request,
        PaginatorInterface $paginator,
        AchievsModel $AchievsModel
    )
    {
        // get request
        $page = $request->query->getInt('page', 1);
        $locale = $request->getLocale();

        $achievs = $AchievsModel->getAchievs($locale);
        $pagination = $paginator->paginate($achievs, $page, 20);

        if($pagination->getPage() > $pagination->getPageCount()) {
            throw $this->createNotFoundException();
        }

        return $this->render('controller/achievs/achievs/achievs.html.twig', [
            'title'         => 'Achievs',
            'pagination'    => $pagination,
        ]);
    }

    /**
     * @Route("/{id}", name="achiev", requirements={"id"="\d+"})
     */
    public function achiev(
        $id,
        Request $request,
        PaginatorInterface $paginator,
        AchievsModel $AchievsModel
    )
    {
        $page = $request->query->getInt('page', 1);
        $locale = $request->getLocale();

        $achiev = $AchievsModel->getAchiev($locale, $id);
        if(!$achiev) { 
            throw $this->createNotFoundException(); 
        }
        
        $players = $AchievsModel->getAchievPlayers($id);
        $pagination = $paginator->paginate($players, $page, 20);

        if($pagination->getPage() > $pagination->getPageCount()) {
            throw $this->createNotFoundException();
        }

        return $this->render('controller/achievs/achievs/achiev.html.twig', [
            'title'          => 'Achiev Players',
            'achiev'        => $achiev,
            'pagination'    => $pagination,
        ]);
    }

     /**
     * @Route("/players", name="achievs_players")
     */
    public function players(
        Request $request,
        PaginatorInterface $paginator,
        AchievsModel $AchievsModel
    )
    {
        // get request
        $page = $request->query->getInt('page', 1);

        // get result
        $players = $AchievsModel->getAchievsPlayers();
        $pagination = $paginator->paginate($players, $page, 20);

        if($pagination->getPage() > $pagination->getPageCount()) {
            throw $this->createNotFoundException();
        }

        // render
        return $this->render('controller/achievs/achievs/players.html.twig', [
            'title' => 'Achievs Players',
            'pagination'    => $pagination,
        ]);
    }

     /**
     * @Route("/players/{id}", name="achievs_player", requirements={"id"="\d+"})
     */
    public function player(
        $id,
        Request $request,
        PaginatorInterface $paginator,
        AchievsModel $AchievsModel
    )
    {
        $locale = $request->getLocale();
        $page = $request->query->getInt('page', 1);

        $achievs = $AchievsModel->getAchievsPlayer($locale, $id);

        if(!$achievs) { 
            throw $this->createNotFoundException(); 
        }

        $pagination = $paginator->paginate($achievs, $page, 20);

        if($pagination->getPage() > $pagination->getPageCount()) {
            throw $this->createNotFoundException();
        }

        //Get all rows and sets
        $achievs = $pagination->getItems();
        foreach ($achievs as &$achiev) {
            $achiev["width"] = 0;
            if ($achiev["count"] != 1 && $achiev["count"] != $achiev["progress"]) {
                $achiev["width"] = $achiev["progress"] * 100 / $achiev["count"];
            }
            
            if ($achiev['count']==$achiev['progress']) {
                $achiev["achiev_completed"] = 'achiev_completed';
            }

            $achiev['unlocked'] = 0;
            //$achiev['unlocked'] = date_format($achiev['unlocked'], "%d.%m.%Y %H:%M");
        }
        $pagination->setItems($achievs);

        return $this->render('controller/achievs/achievs/player.html.twig', [
            'title' => 'Achives Player',
            'pagination'    => $pagination,
        ]);
    }
}
