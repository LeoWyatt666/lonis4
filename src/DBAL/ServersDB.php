<?
namespace App\DBAL;

use Doctrine\DBAL\Driver\Connection;

class ServersDB
{
    private $conn;

    public function __construct(Connection $conn)
    {
        $this->conn = $conn;
    }

    public function findAll()
    {
        return $this->conn->fetchAll(
                'SELECT * FROM cs_view_servers s'
            );
    }

    public function find($id)
    {
        return $this->conn->executeQuery(
                'SELECT * FROM cs_view_servers s WHERE id = ?',
                [$id]
            )
            ->fetch();
    }
}