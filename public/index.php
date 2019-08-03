<?php
/**
 * By Rootoor225 
 * Router ou dispatcher charged to find the correct url
 * POINT D'ENTREE DU SITE
 */
// monolog errors handler
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\FirePHPHandler;

require_once '../Core/constantes.php';
require_once VENDOR_PATH . '/autoload.php';
// require_once '../src/Router.php';
require_once '../Core/Database.php';

// Gestion ergonomique des erreurs
$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();

/** ***************************************
 *                  ROUTER
 *******************************************/
$router = new App\Router(VIEWPATH);

$router->get('/', 'Frontend/index/accueil', 'accueil')
		->get('/actualite/[i:id]', 'Frontend/actualite/show_id', 'show_actu_id')
		->get('/actualite', 'Frontend/actualite/index', 'index_actu')
		->get('/actualite/[*:slug]-[i:id]', 'Frontend/actualite/show', 'show_actu')
		->run();
		
