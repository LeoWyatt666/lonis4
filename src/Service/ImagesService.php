<?
namespace App\Service;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class ImagesService
{
    private $params;

    public function __construct(ParameterBagInterface $params)
    {
        $this->params = $params;
    }
    
    public function image($file)
    {
        // set paths
        $path_img_maps = $this->params->get('kernel.project_dir').'/public/images/'.$file;

        if(file_exists($path_img_maps)) {
            return '/images/'.$file;
        }
        else {
            return '/images/'.dirname($file).'/noimage.png';
        }

    }

}