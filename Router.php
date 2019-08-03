<?php
/**
 * Router class
 */
// activer le typage strict des variables et fonctions et leur retour pour mieux deguster PHP !
declare(strict_types=1);
// definir le namespace
namespace App;

class Router{
    // Attributs ou proprietes
    /**
     * Variable du chemin de vue
     *
     * @var string
     */
    private $viewPath;
    /**
     * @var Altorouter
     */
    private $router;

    // Methodes
    /**
     * constructeur chage d'instancier les objets a l'appel
     *
     * @param string $viewPath
     */
    public function __construct(string $viewPath)
    {
        $this->router = new \AltoRouter();
        //$this->router->setBasePath('../vendor/altorouter/altorouter/AltoRouter'); // (optional) the subdir AltoRouter lives in
        $this->viewPath = $viewPath;
    }
    /**
     * fonction chargee de definir la route selon le routeur
     *
     * @param string $url
     * @param string $pathTofile
     * @param string|null $linkName : utile pour (generer) les liens des boutons et autres
     * @return self
     */
    public function get(string $url, string $pathTofile, ?string $linkName = null):self
    {
        $this->router->map('GET', $url, $pathTofile, $linkName);
        return $this; // methode fluent pour autoriser l'enchainement des appels sans devoir redefenir la variable
    }

    public function post(string $url, string $pathTofile, ?string $linkName = null):self
    {
        $this->router->map('POST', $url, $pathTofile, $linkName);
        return $this; // methode fluent pour autoriser l'enchainement des appels sans devoir redefenir la variable
    }
    
    /**
     * match methode pour eviter la collision entre les routes en GET et POST
     * donc methode qui gere deux routes de meme nom mais de methodes differentes
     * plus besoin de dupliquer les routes en faisant leur partie GET et POST separement
     *
     * @param  mixed $url
     * @param  mixed $pathTofile
     * @param  mixed $linkName
     *
     * @return self
     */
    public function match(string $url, string $pathTofile, ?string $linkName = null):self
    {
        $this->router->map('GET|POST', $url, $pathTofile, $linkName);
        return $this; // methode fluent pour autoriser l'enchainement des appels sans devoir redefenir la variable
    }
    /**
     * url : methode pour reecrire a sa facon la fonction native "generate()" de AltoRouter
     *
     * @param  mixed $nomRoute
     * @param  mixed $params
     *
     * @return void
     */
    public function url(string $nomRoute, array $params = [])
    {
        return $this->router->generate($nomRoute, $params);
    }
    
    /**
     * run
     *
     * @return self
     */
    public function run(): self
    {
        
        $match = $this->router->match();
        if(is_array($match)){ // ou if ($match != false)
            if (is_callable($match['target'])) {
                call_user_func_array($match['target'],$match['params']);
            } else {
                // Definir ici les variables a utiliser ou passer via le routeur !
                $view = $match['target'];
                $params = $match['params'];
                $router = $this; // renvoyer l'objet courant plutot que $this->router... on pourra ecrire simplement $router
                ob_start();
                include_once $this->viewPath.$view.'.php';
                $content_for_layout = ob_get_clean();
            }
                /*
                 * Si l'URL commence par /admin/ aller charger le template destiné à l'administration
                 */
                if(!preg_match("#^(\/admin)\/{0,}(.)*#",$_SERVER['REQUEST_URI'])){
                    include_once $this->viewPath.'templates/default.php';
                }else{
                    include_once $this->viewPath.'templates/admin_default.php';
                }
        }else{ // message d'erreur en cas de piratage de l'URL
            $errorMsg =  "<strong>OOPS!</strong> Vous tentez d'acc&eacute;der &agrave; une page via une URL erron&eacute;e !";
            include_once $this->viewPath.'templates/e404.php';
        }
        return $this;
    }




}// fin de la classe