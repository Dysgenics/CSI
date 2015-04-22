<?php


include_once '..\..\base.php';

class Commande {

    private $id_commande;
	private $id_cli;
	private $id_retrait;
	private $id_magasin;
	private $valide;
	private $dateachat;

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
	
	public static function CreateCommande($id_cl, $id_mag) {
	    $query = "INSERT INTO COMMANDE
			VALUES (0,?,0,?);";
		
        try {   
            $db = Base::getConnection();

            $pp = $db->prepare($query);
			
			//définition des paramètres
			$pp->bindParam(1, $id_cl, PDO::PARAM_INT);
            $pp->bindParam(2, $id_mag, PDO::PARAM_INT);
	
            $pp->execute();
        } catch (PDOException $e) {
            echo $query . "<br>";
            throw new Exception($e->getMessage());
        }
    }
	
    public static function findByIdClient($id_cl) {
        $query = "select * from COMMANDE where id_cli=? AND valide=0";
        try {
            //connexion à la BDD
            $db = Base::getConnection();

            $pp = $db->prepare($query);
            
            //définition des paramètres
            $pp->bindParam(1, $id_cl, PDO::PARAM_INT);
            //rexecution de la requète
            $pp->execute();

            //retourne un tableau d'objets commande
            $rep = $pp->fetchAll(PDO::FETCH_OBJ);
			
            //création du tableau de réponse
            $liste_commande = array();
            //pour chaque produit renvoyé par la requète on va l'ajouter dans le tableau

            foreach ($rep as $row) {
                //une produit est représentée par un tableau
                $commande = array(
                    'id_commande' => $row->ID_CLI,
                    'id_cli' => $row->ID_RETRAIT,
					'id_magasin' => $row->ID_MAGASIN,
					'valide' => $row->VALIDE,
					'dateachat' => $row->DATEACHAT,
                );
                //ajout de la catégorie au tableau
                $liste_commande[] = $commande;
            }
        } catch (PDOException $e) {
            echo $query . "<br>";
            throw new Exception($e->getMessage());
        }
        return $liste_commande;
    }

}