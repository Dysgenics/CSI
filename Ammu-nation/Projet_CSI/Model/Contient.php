<?php


include_once '..\..\base.php';


class Contient {

    private $id_produit;
	private $id_commande;
	private $quantite;
	private $reduction;
	private $prix_unitaire;

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
     * Retourne tous les produits contenus dans la BDD
	 * @param int $id_magasin
     */
    public static function findAll($id_com) {
        $query = "SELECT * from CONTIENT
				WHERE id_commande = ?";
        try {   
            $db = Base::getConnection();

            $pp = $db->prepare($query);
			
			//définition des paramètres
            $pp->bindParam(1, $id_com, PDO::PARAM_INT);
			
            $pp->execute();

            //retourne un tableau d'objets produit
            $rep = $pp->fetchAll(PDO::FETCH_OBJ);
            //création du tableau de réponse
            $liste_commande = array();

            //pour chaque produit renvoyé par la requète on va l'ajouter dans le tableau
            foreach ($rep as $row) {
                //une produit est représentée par un tableau
                $produit = array(
                    'id_produit' => $row->ID_PRODUIT,
                    'id_commande' => $row->ID_COMMANDE,
					'quantite' => $row->QUANTITE,
					'reduction' => $row->REDUCTION,
					'prix_unitaire' => $row->PRIX_UNITAIRE
                );
                //ajout de la catégorie au tableau
                $liste_commande[] = $produit;
            }
        } catch (PDOException $e) {
            echo $query . "<br>";
            throw new Exception($e->getMessage());
        }

        return $liste_commande;
    }

}