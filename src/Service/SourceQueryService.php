<?
namespace App\Service;

use xPaw\SourceQuery\SourceQuery;

class SourceQueryService
{
    private $query;
    private $info;
    private $players;

    public function __construct()
    {
        $this->query = new SourceQuery;
    }

    public function Connect($addres)
    {
        try
        {
            $serv = parse_url($addres);
            $this->query->Connect($serv['host'], $serv['port'], 1, SourceQuery::SOURCE );

            $this->info = $this->query->GetInfo();
            $this->players = $this->query->GetPlayers();
        }
        catch( Exception $e )
        {
            echo $e->getMessage( );
        }
        finally
        {
            $this->query->Disconnect( );
        }
    }

    public function getInfo()
    {
        return $this->info;
    }

    public function getPlayers()
    {
        return $this->players;
    }
}