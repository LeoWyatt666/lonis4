<?
namespace App\Service;

use GeoIp2\Database\Reader;
use GeoIp2\Exception\AddressNotFoundException;

class GeoIp2Service 
{
    public $reader;

    public function __construct($path) 
    {
        $this->reader = new Reader($path);
    }

    public function city($ip)
    {
        try {
            return $this->reader->city($ip ?: '127.0.0.1');
        } catch (AddressNotFoundException $e) {
            return false;
        }
    }
}