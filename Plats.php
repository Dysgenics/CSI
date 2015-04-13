<?php

/**
 *  La Classe plats réalise un Active Record sur la table plats
 *  @package blog
 */
class Plats {

  
//  Identifiant du plats
	private $id ; 


//	Libelle du plats
	private $nom;

  
//	Description de plats
    private $description;

// prix du plats
	private $prix;
	
// photo du plats 
	private $photo;

// Identifiant du restaurant du plats
	private $id_resto;

  /**
   *  Constructeur de plats
   *  fabrique une nouvelle plats vide
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
				   description ". $this->description  .":
				   prix ".$this->prix .":
				   photo ".$this->photo .":
				   id_resto ".$this->id_resto ;
				   
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
    	$query = $c->prepare( "update plats set nom=?, description=?, prix=?, photo=?, id_resto=? where id=?");
    
    /* 
     * Liaison des paramêtres : 
    */
    	$query->bindParam (1, $this->nom, PDO::PARAM_STR);
   	 	$query->bindParam (2, $this->description, PDO::PARAM_STR); 
    	$query->bindParam (6, $this->id, PDO::PARAM_INT);
		$query->bindParam (3, $this->prix, PDO::PARAM_INT); 
		$query->bindParam (4, $this->photo, PDO::PARAM_INT); 
		$query->bindParam (5, $this->id_resto, PDO::PARAM_INT); 

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
 	   		$query = $c->prepare( "delete from plats where id=?");
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
		$insert_query = "insert into plats (nom, description, prix, photo, id_resto) values (:nom, :description, :prix, :photo, :id_resto)" ;
		try{
			$stmt = $c->prepare($insert_query);
			$insert = $stmt->execute( array(':nom'=>$this->nom, ':description'=>$this->description, ':prix'=>$this->prix, ':photo'=>$this->photo, ':id_resto'=>$this->id_resto) ) ;
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
   *   @return plats renvoie un objet de type plats
   */
   
	public static function findById($id) {
    	$c = Base::getConnection();
		try{
      		$query = $c->prepare("select * from plats where id=?") ;
      		$query->bindParam(1, $id, PDO::PARAM_INT);
      		$query->execute();

    	  	$rep = $query->fetch(PDO::FETCH_BOTH);
      
			$cat = new Plats();
			$cat->id = $rep['id'];
			$cat->nom = $rep['nom'];
			$cat->prix = $rep['prix'];
			$cat->photo = $rep['photo'];
			$cat->id_resto = $rep['id_resto'];
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
   *   @return plats renvoie un objet de type plats
   */
   
    public static function findByNom($n) {
    	$c = Base::getConnection();
		try{
      		$query = $c->prepare("select * from plats where nom=?") ;
      		$query->bindParam(1, $n, PDO::PARAM_INT);
      		$query->execute();

    		$rep = $query->fetch(PDO::FETCH_BOTH);
      
			$cat = new Plats();
			$cat->id = $rep['id'];
			$cat->nom = $rep['nom'];
			$cat->prix = $rep['prix'];
			$cat->photo = "image/".$rep['photo'];
			$cat->id_resto = $rep['id_resto'];
			$cat->description = $rep['description'];

			return $cat;

	  }catch(BaseException $e){
		return null;
	  }		
	}

	 public static function findByIdResto($id_rest) { 
        $c = Base::getConnection(); 
        try{ 
            $query = $c->prepare("select * from plats where id_resto=?") ; 

            $query->bindParam(1, $id_rest, PDO::PARAM_INT); 

            $query->execute(); 

  
            $rep2 = $query->fetchAll(); 
			
			$j = 0;  
            $tab2 = null; 
              
            foreach($rep2 as $ligne2){ 
                $cat2 = new Plats(); 
                $cat2->id = $ligne2[0]; 
                $cat2->nom = $ligne2[1]; 
                $cat2->description = $ligne2[2]; 
				$cat2->prix = $ligne2[3];
				$cat2->photo = $ligne2[4];
				$cat2->id_resto = $ligne2[5];
                
                $tab2[$j] = $cat2; 
                $j++;    
            } 
            return $tab2; 
      
        }catch(BaseException $e){ 
            return null; 
        }        
    }
    
    /**
     *   Renvoie toutes les lignes de la table plats
     *   sous la forme d'un tableau d'objet
     *  
     *   @return Array renvoie un tableau de plats
     */
    
	public static function findAll() {
		$c = Base::getConnection();
		try{
      		$query = $c->prepare("select * from plats order by nom") ;
      		$query->execute();
    		
			$rep = $query->fetchAll();
      		
			// Créé l'Array $tab avec l'ensemble des lignes
	  		$i = 0;
			$tab = null;
			
	  		foreach($rep as $ligne){
				$cat = new Plats();
			
				
				$cat->id = $ligne['id'];
				$cat->nom = $ligne['nom'];
				$cat->description = $ligne['description'];
				$cat->prix = $ligne['prix'];
				$cat->photo = $ligne['photo'];
				$cat->id_resto = $ligne['id_resto'];
				// var_dump($cat);
				$tab[$i] = $cat;
				$i++;
			}
			return $tab;
	
		}catch(BaseException $e){
			return null;
		}		
    }
	
	public static function findLast(){
		$c = Base::getConnection();
		try{
      		$query = $c->prepare("select * from plats order by id DESC LIMIT 0,4") ;
      		$query->execute();
			$rep = $query->fetchAll();
		
		// Créé l'Array $tab avec l'ensemble des lignes
	  		$i = 0;
			$tab = null;
			
	  		foreach($rep as $ligne){
				$cat = new Plats();
			
				
				$cat->id = $ligne['id'];
				$cat->nom = $ligne['nom'];
				$cat->description = $ligne['description'];
				$cat->prix = $ligne['prix'];
				$cat->photo = $ligne['photo'];
				$cat->id_resto = $ligne['id_resto'];
				// var_dump($cat);
				$tab[$i] = $cat;
				$i++;
			}
			return $tab;
			
		}catch(BaseException $e){
			return null;
		}
	
	
	
	}
}