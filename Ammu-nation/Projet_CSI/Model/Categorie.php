<?php


include_once '../../base.php';

class Categorie {

    private $id_categorie;
	private $libelle_categ;

    /**
     * Constructeur
     */
    public function __construct() {
        
    }

    /**
     * Fonction d'acc�s aux attributs d'un objet
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
     * @param $name le nom de l'attribut � modifier
     * @param $value la valeur de l'attribut � modifier
     */
    public function __set($name, $value) {
        //si l'attribut existe on modifie sa valeur
        if (property_exists(__CLASS__, $name)) {
            $this->$name = $value;
        }
    }

    /**
     * Retourne toutes les cat�gories contenus dans la BDD
     */
    public static function findAll() {
        $query = "select * from CATEGORIE ";
        try {   
            $db = Base::getConnection();

            $pp = $db->prepare($query);
            $pp->execute();

            //retourne un tableau d'objets CATEGORIE
            $rep = $pp->fetchAll(PDO::FETCH_OBJ);
            //cr�ation du tableau de r�ponse
            $liste_categorie = array();

            //pour chaque categorie renvoy� par la requ�te on va l'ajouter dans le tableau
            foreach ($rep as $row) {
                //une categorie est repr�sent�e par un tableau
                $categorie = array(
                    'id_categorie' => $row->ID_CATEGORIE,
                    'libelle_categ' => $row->LIBELLE_CATEG,
                );
                //ajout de la cat�gorie au tableau
                $liste_categorie[] = $categorie;
            }
        } catch (PDOException $e) {
            echo $query . "<br>";
            throw new Exception($e->getMessage());
        }

        return $liste_categorie;
    }
    
    /**
     * retourne une categorie de la bdd en fonction de l'id'
     */
    public static function findById($id) {
        $query = "select * from CATEGORIE where ID_CATEGORIE=?";
        try {   
            //connexion � la BDD
            $db = Base::getConnection();

            $pp = $db->prepare($query);
            
            //d�finition des param�tres
            $pp->bindParam(1, $id, PDO::PARAM_INT);
            //rexecution de la requ�te
            $pp->execute();

            
            $rep = $pp->fetch(PDO::FETCH_OBJ);
            //var_dump($rep);
            //cr�ation du tableau de r�ponse
            $categ = new Categorie();

            $categ->id_categorie = $rep->ID_CATEGORIE;
            $categ->libelle_categ = $rep->LIBELLE_CATEG;
            
            
        } catch (PDOException $e) {
            echo $query . "<br>";
            throw new Exception($e->getMessage());
        }

        return $categ;
    }
}