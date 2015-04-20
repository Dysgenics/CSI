<?php

include_once '../Base.php';

/**
 * Représente un client
 * Les attributs sont les mêmes que les colonnes de la table client dans la BDD
 */
class Client {

    private $id_cli; 
    private $nom_cli;
    private $prenom_cli; 
    private $adresse_cli;
	private $mdp_cli;
	private $email_cli;
	private $tel_cli;

    /**
     * Constructeur
     */
    public function __construct() {
        
    }

    /**
     * Fonction d'accès aux attributs d'un objet
     * @param $name le nom de l'attribut
     * @return la valeur de l'attribut
     */
    public function __get($name) {
        //si l'attribut existe on retourne sa valeur
        if (property_exists(__CLASS__, $name)) {
            return $this->$name;
        }
    }

    /**
     * Fonction de modification des attributs d'un objet
     * @param $name le nom de l'attribut à modifier
     * @param $value la valeur de l'attribut à modifier
     */
    public function __set($name, $value) {
        //si l'attribut existe on modifie sa valeur
        if (property_exists(__CLASS__, $name)) {
            $this->$name = $value;
        }
    }

    /**
     * Trouver un client par son ID (TEST)
     * 
     * Retourne la ligne de la table correspondant à l'ID passé en paramètre
     * @param int $id
     */
    public static function findById($id) {
        //requête
        $query = "select * from CLIENT where id_cli=?";
        try {
            //connexion à la BDD
            $db = Base::getConnection();

            $pp = $db->prepare($query);
            
            //définition des paramètres
            $pp->bindParam(1, $id, PDO::PARAM_INT);
            //execution de la requète
            $pp->execute();

            //retourne un tableau indexé par les noms de colonnes 
            $rep = $pp->fetch(PDO::FETCH_ASSOC);
			
			 foreach ($rep as $row) {
				 print($row);
			 }
            
        } catch (PDOException $e) {
            echo $query . "<br>";
            throw new Exception($e->getMessage());
        }
    }
	
}
?>