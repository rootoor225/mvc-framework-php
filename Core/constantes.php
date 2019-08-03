<?php
/*********************************************************************************
// Fichier contenant toutes les constantes devant servir dans le projet
// par ADI Junior <Rootoor225/> - dimanche 05 Mai 2019 - 14h33 Universite Nangui Abrogoua 
// NB: Prendre la peine de ne pas fermer les balises PHP des fichiers a inclure
// Definir le chemin d'acces a chaque fichier du projet ou a son dossier
***********************************************************************************/
define('DS', DIRECTORY_SEPARATOR); // le mettre toujours en premier car d'autres peuvent en dependre
// url complet  de ce format>  localhost/test/index.php?q=XXX&b=YYY&c=ZZZ    s'obtient avec  
// $urlcomplet = $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
// 
// Code d'affichage de l'URL de la page courante. 
if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') 
    $lienURL = "https"; 
else
    $lienURL = "http"; 
  
// Faire un append sur les caracteres ommuns de l'URL. 
$lienURL .= "://"; 
  
// Append the host(domain name, ip) to the URL. 
$lienURL .= $_SERVER['HTTP_HOST']; 
define('HTTP_ROOT',$lienURL);

/*******************************************************************************************
//			  lienURLS ABSOLUS (les ROOT) => utiles pour les recritures des URLs
********************************************************************************************/
// vers le dossier public (  /unaf/public  )
define('PUBLIC_LINK', dirname($_SERVER['SCRIPT_NAME'])); //permet de savoir le dossier racine de index.php => /unaf/public
// vers le dossier unaf (  http://localhost/unaf  )
define('SITE_ROOT', $lienURL.str_replace($_SERVER['DOCUMENT_ROOT'],'', str_replace('\\', '/', dirname(__DIR__))));
// vers le dossier public ( http://localhost/site/public )
define('PUBLIC_ROOT', $lienURL.str_replace($_SERVER['DOCUMENT_ROOT'],'', 
							str_replace('\\', '/', dirname(__DIR__).'/public')));
// vers le dossier App (  http://localhost/site/App  )
define('SRC_ROOT', $lienURL.str_replace($_SERVER['DOCUMENT_ROOT'],'', str_replace('\\', '/', dirname(__DIR__).'/src')));
// vers le dossier Views (  http://localhost/unaf/App/Views  )
define('VIEWS_ROOT', SITE_ROOT.'/'.'Views');
// vers le dossier assets (  http://localhost/site/App/public/assets  )
define('ASSETS_ROOT', PUBLIC_ROOT.'/'.'assets');


/***********************************************************************************************
//			  lienURLS RELATIFS  (les PATH) => utiles pour faciliter les inclusions
************************************************************************************************/
// vers le dossier public (maniere 1)
define('SITE_LINK', dirname(dirname($_SERVER['SCRIPT_NAME']))); //permet de savoir le dossier où est le fichier index.php => /unaf/
// vers le dossier public (maniere 2) 
define('PUBLIC_UNIXPATH', dirname($_SERVER['SCRIPT_FILENAME'])); // C:/xampp/htdocs/site/public
// vers le dossier public (maniere 3)
define('PUBLIC_WINPATH',getcwd().DS); // C:\xampp\htdocs\site\public\
// vers le dossier htdocs 
$htdocs = $_SERVER['DOCUMENT_ROOT']; //  C:/xampp/htdocs/
define('HTDOCS', $htdocs);    //  C:/xampp/htdocs/
// vers le dossier Core
define("CORE_PATH", __DIR__); // C:\xampp\htdocs\site\Core
// vers le dossier Core
define("HELPERS_PATH", __DIR__); // C:\xampp\htdocs\site\Core
// vers le dossier unaf (genre Linux)
define('SITE_PATH', dirname(dirname($_SERVER['SCRIPT_FILENAME']))); //  C:/xampp/htdocs/site
// vers le dossier public
define('ASSETS_PATH', PUBLIC_UNIXPATH.DS.'assets'.DS); // C:\xampp\htdocs\site\public\assets\    on aurait pu utiliser la fonction getcwd() qui affiche C:\xampp\htdocs\unaf\public
// vers le dossier App (genre Linux)
define('VIEWS_PATH', SITE_PATH.'/Views/'); //  C:/xampp/htdocs/site/App
// vers le dossier Vendor (genre Linux)
define('VENDOR_PATH', SITE_PATH.'/vendor'); //  C:/xampp/htdocs/site/App/vendor

// with altorouter and php -S localhost:8000 -t public   command
define('VIEWPATH', str_replace('\\','/',SITE_PATH).'/Views/');
