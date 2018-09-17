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
    
    public function getImage($file)
    {
        // set paths
        $path_img = $this->params->get('images');
        $path_img_file = $this->params->get('kernel.project_dir').'/'.$path_img.$file;

        if(file_exists($path_img_file)) {
            return $path_img.$file;
        }
        else {
            return $path_img.dirname($file).'/noimage.png';
        }

    }

}