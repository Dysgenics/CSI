<?php

/**
 *  La Classe theme réalise un Active Record sur la table theme
 *  @package blog
 */
class Theme {

  
//  Identifiant de theme
	private $id ; 


//	Nom du theme
	private $nom;

  
//	Description de theme
    private $description;


  /**
   *  Constructeur de theme
   *  fabrique une nouvelle theme vide
   */
  
	public function __construct() {
    }


  /**
   *  Fonction Magic retournant une chaine de caracteres
   *
   *  @return String
   */
   
	public function __toString() {
    	return "[". __CLASS__ . "] id : ". $this->id . ":
				   nom  ". $this->nom  .":
				   description ". $this->description  ;
    }
  

  /**
   *   Fonction d'acces aux attributs d'un objet.
   *   Recoit en parametre le nom de l'attribut
   *   et retourne sa valeur.
   *  
   *   @param String $attr_name attribute name 
   *   @return mixed
   */
   
	public function __get($attr_name) {
		if (property_exists( __CLASS__, $attr_name)) { 
        	return $this->$attr_name;
    	} 
    	$emess = __CLASS__ . ": unknown member $attr_name (getAttr)";
    	throw new Exception($emess, 45);
  	}

  
  /**
   *   Fonction de modification des attributs d'un objet.
   *   Recoit en parametre le nom de l'attribut modifie et la nouvelle valeur
   *  
   *   @param String $attr_name attribute name 
   *   @param mixed $attr_val attribute value
   *   @return mixed new attribute value
   */
   
	public function __set($attr_name, $attr_val) {
    	if (property_exists( __CLASS__, $attr_name)) { 
     		$this->$attr_name = $attr_val;
		}else{
   			throw new Exception("Attribut invalide");
		}
	}
	

  /**
   *   Sauvegarde l'objet courant dans la base en faisant un update
   *   l'identifiant de l'objet doit exister (insert obligatoire auparavant)
   *
   *   @return int nombre de lignes mises à jour
   */
   
	public function update() {
	    if (!isset($this->id)) {
    		throw new Exception(__CLASS__ . ": Primary Key undefined : cannot update");
    	} 

   		$c = Base::getConnection();
    	$query = $c->prepare( "update Theme set nom=?, description=? where id=?");
    
    /* 
     * Liaison des paramêtres : 
    */
    	$query->bindParam (1, $this->nom, PDO::PARAM_STR);
   	 	$query->bindParam (2, $this->description, PDO::PARAM_STR); 
    	$query->bindParam (3, $this->id, PDO::PARAM_INT); 

    /*
     * Exécution de la requête
     */
    	return $query->execute();
  	}


  /**
   *   Supprime la ligne dans la table corrsepondant à l'objet courant
   */
   
	public function delete() {
    	$c = Base::getConnection();
		if (!isset($this->id)) {
			throw new MyException(__CLASS__ . ": ID inexistant");
		}
		
		try{
 	   		$query = $c->prepare( "delete from theme where id=?");
   	   		$query->bindParam (1, $this->id, PDO::PARAM_INT);
		}catch(BaseException $e){
  			return 0;
		}
    	
		return $query->execute();
  }
		
		
  /**
   *   Insère l'objet comme une nouvelle ligne dans la table
   *
   *   @return int nombre de lignes insérées
   */	
   								
	public function insert() {  
		$c = Base::getConnection();
		$insert_query = "insert into Theme (nom, description) values (:nom, :description)" ;
		try{
			$stmt = $c->prepare($insert_query);
			$insert = $stmt->execute( array(':nom'=>$this->nom, ':description'=>$this->description) ) ;
			$this->id = $c->LastInsertId('id');
			return $insert;
		}
		catch(BaseException $e){
			return null;
		}		
  	}


 /**
   *   Retrouve la ligne de la table correspondant au ID passé en paramètre,
   *   retourne un objet
   *  
   *   @param integer $id OID to find
   *   @return theme renvoie un objet de type theme
   */
   
	public static function findById($id) {
    	$c = Base::getConnection();
		try{
      		$query = $c->prepare("select * from theme where id=?") ;
      		$query->bindParam(1, $id, PDO::PARAM_INT);
      		$query->execute();

    	  	$rep = $query->fetch(PDO::FETCH_BOTH);
      
			$cat = new theme();
			$cat->id = $rep['id'];
			$cat->nom = $rep['nom'];
			$cat->description = $rep['description'];

			return $cat;

	  }catch(BaseException $e){
		return null;
	  }
	}
	
	
 /**
   *   Retrouve la ligne de la table correspondant au Tire passé en paramètre,
   *   retourne un objet
   *  
   *   @static
   *   @param integer $id OID to find
   *   @return theme renvoie un objet de type theme
   */
   
    public static function findByNom($nom) {
    	$c = Base::getConnection();
		try{
      		$query = $c->prepare("select * from theme where nom=?") ;
      		$query->bindParam(1, $nom, PDO::PARAM_INT);
      		$query->execute();

    		$rep = $query->fetch(PDO::FETCH_BOTH);
      
			$cat = new theme();
			$cat->id = $rep['id'];
			$cat->nom = $rep['nom'];
			$cat->description = $rep['description'];

			return $cat;

	  }catch(BaseException $e){
		return null;
	  }		
	}

    
    /**
     *   Renvoie toutes les lignes de la table theme
     *   sous la forme d'un tableau d'objet
     *  
     *   @return Array renvoie un tableau de theme
     */
    
	public static function findAll() {
		$c = Base::getConnection();
		try{
      		$query = $c->prepare("select * from theme order by nom") ;
      		$query->execute();
    		
			$rep = $query->fetchAll();
      		
			// Créé l'Array $tab avec l'ensemble des lignes
	  		$i = 0; 
			$tab = null;
			
	  		foreach($rep as $ligne){
				$cat = new theme();
				$cat->id = $ligne[0];
				$cat->nom = $ligne[1];
				$cat->description = $ligne[2];
				
				$tab[$i] = $cat;
				$i++;	
			}
			return $tab;
	
		}catch(BaseException $e){
			return null;
		}		
    }
}