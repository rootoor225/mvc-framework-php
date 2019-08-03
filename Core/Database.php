<?php
/**********************************************************************************
* Classe de Connection à la base de données utilisant le design pattern SINGLETON
***********************************************************************************/
// utilisation de namespace (non chargé automatiquement)
// namespace Core;
// use \PDO; // utilisation des focntions incluses dans php donc situées à la racine du projet 

class Database
{
    /**
     * Instance de la classe Database
     * @access private
     * @var Database
     * @see getInstance
     */
    private static $instance;

    /**
     * Type de la base de donnée.
     * @access private
     * @var string
     * @see __construct
     */
    private $type = "mysql";

    /**
     * Adresse du serveur hôte.
     * @access private
     * @var string
     * @see __construct
     */
    private $host = "localhost";

    /**
     * Nom de la base de données.
     * @access private
     * @var string
     * @see __construct
     */
    private $dbname = "mvc-amateur";

    /**
     * Nom d'utilisateur pour la Database à la base de données
     * @access private
     * @var string
     * @see __construct
     */
    private $username = "root";

    /**
     * Mot de passe pour la Database à la base de données
     * @access private
     * @var string
     * @see __construct
     */
    private $password = 'toor';
    
    /**
     * Options de la connexion à la base de données
     * @access private
     * @var string
     * @see __construct
     */
    private $options = array(
                                // Affichage des Erreurs en local
                                PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,
                                // Pas d'affichage d'Erreurs en Production
                                //PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT,
                                PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_OBJ
                       );

    private $db;

    /**
     * Lance la Database à la base de donnée en le mettant
     * dans un objet PDO qui est stocké dans la variable $db
     * @access private
     */
    private function __construct()
    {
        try{
            $this->db = new PDO(
                $this->type.':host='.$this->host.'; dbname='.$this->dbname, 
                $this->username, 
                $this->password,
                $this->options
                // array(PDO::ATTR_PERSISTENT => true)
            );

            $req = "SET NAMES UTF8";
            $result = $this->db->prepare($req);
            $result->execute();
        }
        catch(PDOException $pdoe){
            echo " Erreur de connexion &agrave; la base de données: ". $pdoe->getMessage() . "<br/>";
            die();
        }
    }

    /**
     * Regarde si un objet Database a déjà été instancié,
     * si c'est le cas alors il retourne l'objet déjà existant
     * sinon il en crée un autre.
     * @return $instance
     */
    public static function getInstance()
    {
        if (!self::$instance instanceof self)
        {
            self::$instance = new self;
        }
        return self::$instance;
    }

    /**
     * Permet de récuprer l'objet PDO permettant de manipuler la base de données
     * @return $db
     */
    public function getDb()
    {
        return $this->db;
    }
}

//Appel de cette classe
/*
        $db = Database::getInstance();
        $db->getDb();
        ou
        $db = Database::getInstance()->getDb();
*/
