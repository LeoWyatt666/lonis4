<?
namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class AppFixtures extends Fixture
{
    private $params;

    public function __construct(ParameterBagInterface $params)
    {
        $this->params = $params;
    }

    public function load(ObjectManager $manager)
    {
        $path = $this->params->get('kernel.project_dir').'/data/';
        $files = [
            'fixtures.sql',
        ];
        $sql = '';
        foreach($files as $file) {
            $sql .= file_get_contents($path.$file);
        }
        $manager->getConnection()->exec($sql);

        $manager->flush();
    }

    public function getOrder() {
        return 99;  // Order in which this fixture will be executed
      }
}