<?
namespace App\Service;

use App\Libraries\Hlds;

class HldsService
{
    public $hlds;

    public function __construct(Hlds $hlds) 
    {
        $this->hlds = $hlds;
    }

    public function getServerInfo($ip, $get_players = false)
    {
        if ($this->hlds->connect($ip)) {
            $server = $this->hlds->info();
            $get_players && $server['players_list'] = $this->hlds->get_players();
        }

        return $server ?? 0;
    }

}