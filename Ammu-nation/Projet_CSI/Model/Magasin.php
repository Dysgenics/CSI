<?php


include_once '../../base.php';

class Magasin {

    private $id_magasin;
	private $nom_magasin;
	private $num_rue;
	private $nom_rue;
	private $ville;
	private $cp;

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
     * Retourne tous les magasins contenus dans la BDD
     */
    public static function findAll() {
        $query = "select * from MAGASIN ";
        try {   
            $db = Base::getConnection();

            $pp = $db->prepare($query);
            $pp->execute();

            //retourne un tableau d'objets MAGASIN
            $rep = $pp->fetchAll(PDO::FETCH_OBJ);
            //création du tableau de réponse
            $liste_magasin = array();

            //pour chaque magasin renvoyé par la requète on va l'ajouter dans le tableau
            foreach ($rep as $row) {
                //un magasin est représenté par un tableau
                $magasin = array(
                    'id_magasin' => $row->ID_MAGASIN,
                    'nom_magasin' => $row->NOM_MAGASIN,
                    'num_rue' => $row->NUM_RUE,
                    'nom_rue' => $row->NOM_RUE,
					'ville' => $row->VILLE,
                    'cp' => $row->CP,
                );
                //ajout du magasin au tableau
                $liste_magasin[] = $magasin;
            }
        } catch (PDOException $e) {
            echo $query . "<br>";
            throw new Exception($e->getMessage());
        }

        return $liste_magasin;
    }
}