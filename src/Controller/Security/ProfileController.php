<?
namespace App\Controller\Security;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\CsPlayers;
use Ornicar\GravatarBundle\GravatarApi;

class ProfileController extends AbstractController
{
    /**
     * @Route("/auth/profile", name="profile")
     */
    public function profile(
        Request $request
    )
    {
        $em = $this->getDoctrine()->getManager();
        $er = $this->getDoctrine()->getRepository(CsPlayers::class);
        $gravatar = new GravatarApi;

        $player = $this->getUser();
        
        if(property_exists($player, 'profileName')) {
            $steam = $player;
            $player = $er->findBySteam($steam->getSteamId());
            if(!isset($player)) {
                $name = $er->isUsername($steam->getProfileName());
                $player = new CsPlayers;
                $player->setUsername($name);
                $player->setSteamId64($steam->getSteamId());
                $player->setAvatar($steam->getAvatar());
                $em->persist($player);
                $em->flush();

                return $this->redirectToRoute('profile');
            }
            $player->setAvatar($steam->getAvatar());
        }
        else {
            $player->setAvatar($gravatar->getUrl($player->getEmail()));
        }

        

        if ($request->getMethod()=="POST") {
            $subPlayer = $request->request->get('player');

            $checkPlayer = $er->findByUsername($subPlayer['username']);
            if(!isset($checkPlayer)) {
                $player->setUsername($subPlayer['username']);
            }

            if (!empty($subPlayer['password'])) {
                $subPlayer['password'] = md5($subPlayer['password']);
            }
            
            $player->setIcq($subPlayer['icq'] ?: 0);
            $player->setIp($subPlayer['ip']);
            $player->setAvatar($subPlayer['avatar']);
            $em->persist($player);
            $em->flush();

            return $this->redirectToRoute('profile');
        }   

        // if ($this->isCsrfTokenValid('profile', $request->request->get('token'))) {
        //     throw $this->createNotFoundException();
        // }

        return $this->render('controller/security/profile.html.twig', array(
            'title'     => 'Profile',
            'player'    => $player,
        ));
    }
    
}
