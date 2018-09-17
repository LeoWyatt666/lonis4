<?
namespace App\Service;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class ZipService
{
    private $params;
    private $zip;

    public function __construct(ParameterBagInterface $params)
    {
        $this->params = $params;
        $this->zip= new \ZipArchive();
    }

    public function getImage($arhive, $name)
    {
        $name_img = $name.'.jpg';
        $path_img = dirname($arhive);
        $path_arhive = $this->params->get('kernel.project_dir').'/'.$arhive;
        
        if ($this->zip->open($path_arhive)) {
            $im_string = $this->zip->getFromName($name_img);
            if(!empty($im_string)) {
                $im = imagecreatefromstring($im_string);
                imagejpeg($im, $path.'/'.$name_img);
            }
        }
    }
}