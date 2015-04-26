<?php

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
	
	public static function findByEmail($email) {
        try {
			// Création de la requête préparée
            $query = "SELECT * FROM CLIENT WHERE EMAIL = ?";
            // Récupération d'une connexion à la base
            $db = base::getConnection();

            $statement = $db->prepare($query);

			$statement->bindParam(1, $email, PDO::PARAM_INT);
            // Exécution de la requête préparée
            $statement->execute();

            // Récupération du tuple correspondant à l'id en paramètre
            $row = $statement->fetch(PDO::FETCH_ASSOC);

            // Remplissage d'un objet Client avec les emailrmations contenues dans le tuple
            $client = new Client("","","","","","","");
            $client->id_cli = $row['ID_CLI'];
            $client->nom_cli = $row['NOM_CLI'];
			$client->prenom_cli = $row['PRENOM_CLI'];
			$client->adresse_cli = $row['ADRESSE_CLI'];
            $client->mdp = $row['MDP'];
            $client->email = $row['EMAIL'];
			$client->telephone = $row['TELEPHONE'];

            // Retour du tableau de tracks
            return $client;
        } catch (Exception $e) {
            $trace = $e->getTrace();
            echo "Erreur pendant findByEmail: $trace";
		}
	}
}
?>