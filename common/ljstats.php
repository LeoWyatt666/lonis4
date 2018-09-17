<?
use Symfony\Component\Dotenv\Dotenv;

require __DIR__.'/../vendor/autoload.php';

// The check is to ensure we don't use .env in production
if (!isset($_SERVER['APP_ENV'])) {
    if (!class_exists(Dotenv::class)) {
        throw new \RuntimeException('APP_ENV environment variable is not defined..');
    }
    (new Dotenv())->load(__DIR__.'/../.env');
}

$mysql = parse_url(getenv('DATABASE_URL'));

$base_url = $_SERVER['REQUEST_URI'];

$mysql['db'] = substr($mysql['path'], 1);

ob_start();
require 'ljstats/index.php';
$ljstats = ob_get_clean();