<?
namespace App\Service;

use GeoIp2\Database\Reader;
use GeoIp2\Exception\AddressNotFoundException;

class GeoIp2Service
{
    public $geoip;

    public function __construct($db) 
    {
        $this->geoip = new Reader($db);
    }

    public function getCity($ip)
    {
        try {
            return $this->geoip->city($ip ?: '127.0.0.1');
        } catch (AddressNotFoundException $e) {
            return [];
        }
    }
}