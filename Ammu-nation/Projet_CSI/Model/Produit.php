<?php


include_once '../../base.php';

class Produit {

    private $id_produit;
	private $id_categorie;
	private $nom_produit;
	private $prix;
	private $libelle;
	private $img_url;

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
    * Trouver un produit par son ID
    * 
    * Retourne la ligne de la table correspondant à l'ID passé en paramètre
    * @param int $id
    * @return le produit sous forme d'un tableau
    */
    public static function findById($id) {
        $query = "select * from PRODUIT where id_produit=?";
        try {
            //connexion à la BDD
            $db = Base::getConnection();

            $pp = $db->prepare($query);
            
            //définition des paramètres
            $pp->bindParam(1, $id, PDO::PARAM_INT);
            //rexecution de la requète
            $pp->execute();

            //retourne un tableau d'objets produit
            $row = $pp->fetch(PDO::FETCH_OBJ);
            //création du tableau de réponse
            $produit = array();

           
                $produit = array(
                    'id_produit' => $row->ID_PRODUIT,
                    'id_categorie' => $row->ID_CATEGORIE,
					'nom_produit' => $row->NOM_PRODUIT,
					'prix' => $row->PRIX,
					'libelle' => $row->LIBELLE,
					'img_url' => $row->IMG_URL
                );
                
        } catch (PDOException $e) {
            echo $query . "<br>";
            throw new Exception($e->getMessage());
        }
        return $produit;
    }

    /**
     * Retourne tous les produits contenus dans la BDD
	 * @param int $id_magasin
     */
    public static function findAll($id_magasin) {
        $query = "SELECT * from PRODUIT, PROPOSE 
				WHERE PRODUIT.id_produit = PROPOSE.id_produit
				AND PROPOSE.id_magasin = ?";
        try {   
            $db = Base::getConnection();

            $pp = $db->prepare($query);
			
			//définition des paramètres
            $pp->bindParam(1, $id_magasin, PDO::PARAM_INT);
			
            $pp->execute();

            //retourne un tableau d'objets produit
            $rep = $pp->fetchAll(PDO::FETCH_OBJ);
            //création du tableau de réponse
            $liste_produit = array();

            //pour chaque produit renvoyé par la requète on va l'ajouter dans le tableau
            foreach ($rep as $row) {
                //une produit est représentée par un tableau
                $produit = array(
                    'id_produit' => $row->ID_PRODUIT,
                    'id_categorie' => $row->ID_CATEGORIE,
					'nom_produit' => $row->NOM_PRODUIT,
					'prix' => $row->PRIX,
					'libelle' => $row->LIBELLE,
					'img_url' => $row->IMG_URL
                );
                //ajout de la catégorie au tableau
                $liste_produit[] = $produit;
            }
        } catch (PDOException $e) {
            echo $query . "<br>";
            throw new Exception($e->getMessage());
        }

        return $liste_produit;
    }
	
	/**
     * Retourne tous les produits d'une catégorie contenus dans la BDD 
	 * @param int $id_categ
	 * @param int $id_magasin
     */
    public static function findByCateg($id_magasin, $id_categ) {
        $query = "select * from PRODUIT, PROPOSE 
				WHERE PRODUIT.id_produit = PROPOSE.id_produit
				AND PROPOSE.id_magasin = ?
				AND PRODUIT.id_categorie = ?";
		
        try {   
            $db = Base::getConnection();

            $pp = $db->prepare($query);
			
			//définition des paramètres
			$pp->bindParam(1, $id_magasin, PDO::PARAM_INT);
            $pp->bindParam(2, $id_categ, PDO::PARAM_INT);
			
            $pp->execute();

            //retourne un tableau d'objets produit
            $rep = $pp->fetchAll(PDO::FETCH_OBJ);
            //création du tableau de réponse
            $liste_produit = array();

            //pour chaque produit renvoyé par la requète on va l'ajouter dans le tableau
            foreach ($rep as $row) {
                //une produit est représentée par un tableau
                $produit = array(
                    'id_produit' => $row->ID_PRODUIT,
                    'id_categorie' => $row->ID_CATEGORIE,
					'nom_produit' => $row->NOM_PRODUIT,
					'prix' => $row->PRIX,
					'libelle' => $row->LIBELLE,
					'img_url' => $row->IMG_URL
                );
                //ajout de la catégorie au tableau
                $liste_produit[] = $produit;
            }
        } catch (PDOException $e) {
            echo $query . "<br>";
            throw new Exception($e->getMessage());
        }

        return $liste_produit;
    }
}