<?php 
  
/** 
 *  La Classe Restaurant réalise un Active Record sur la table categorie 
 *  @package blog 
 */
class Restaurant { 
  
    
//  Identifiant de categorie 
    private $id ;  
  
  
//  Libelle de categorie 
    private $nom; 
  
    
//  Description de categorie 
    private $description; 
	
// Description d'adresse
	private $adresse;

// Description de contact
	private $contact;
	
// Identifiant du theme
	private $id_theme;
	
	private $image;
  
  
  /** 
   *  Constructeur de Restaurant
   *  fabrique une nouvelle categorie vide 
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
                   description ". $this->description .":
					adresse ". $this->adresse ."
					contact ". $this->contact ."
					id_theme ". $this->id_theme ."
					image ". $this->image; 
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
        $query = $c->prepare( "update restaurant set nom=?, description=?, adresse=?, contact=?, id_theme=?, image=? where id=?"); 
      
    /*  
     * Liaison des paramêtres :  
    */
        $query->bindParam (1, $this->nom, PDO::PARAM_STR); 
        $query->bindParam (2, $this->description, PDO::PARAM_STR);  
        $query->bindParam (3, $this->adresse, PDO::PARAM_STR);  
		$query->bindParam (4, $this->contact, PDO::PARAM_STR);
		$query->bindParam (5, $this->id_theme, PDO::PARAM_INT);
		$query->bindParam (7, $this->id, PDO::PARAM_INT);
		$query->bindParam (6, $this->image, PDO::PARAM_STR);
  
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
            $query = $c->prepare( "delete from restaurant where id=?"); 
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
        $insert_query = "insert into restaurant (nom, description, adresse, contact, id_theme) values (:nom, :description, :adresse, :contact, :id_theme)" ; 
        try{ 
            $stmt = $c->prepare($insert_query); 
            $insert = $stmt->execute( array(':nom'=>$this->nom, ':description'=>$this->description, ':adresse'=>$this->adresse, ':contact'=>$this->contact, ':id_theme'=>$this->id_theme) ) ; 
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
   *   @return Categorie renvoie un objet de type Categorie 
   */
     
    public static function findById($id) { 
        $c = Base::getConnection(); 
        try{ 
            $query = $c->prepare("select * from restaurant where id=?") ; 
            $query->bindParam(1, $id, PDO::PARAM_INT); 
            $query->execute(); 
  
            $rep = $query->fetch(PDO::FETCH_BOTH); 
        
            $cat = new Restaurant(); 
            $cat->id = $rep['id']; 
            $cat->nom = $rep['nom']; 
            $cat->description = $rep['description']; 
			$cat->adresse = $rep['adresse'];
			$cat->contact = $rep['contact'];
			$cat->id_theme = $rep['id_theme'];
			$cat->image = $rep['image'];
            return $cat; 
  
      }catch(BaseException $e){ 
        return null; 
      } 
    } 
      
      public static function countResto($id){
		     $c = Base::getConnection(); 
		
        try{ 
            $query = $c->prepare("select count(id_theme) from restaurant where id_theme=?") ; 
            $query->bindParam(1, $id, PDO::PARAM_STR); 
            $query->execute(); 
			
			$rep = $query->fetch(PDO::FETCH_BOTH); 
			 
			return $rep[0];
			
			 }catch(BaseException $e){ 
        return null; 
      } 
	  
	  }
 /** 
   *   Retrouve la ligne de la table correspondant au Nom passé en paramètre, 
   *   retourne un objet 
   *   
   *   @static 
   *   @param integer $id OID to find 
   *   @return Categorie renvoie un objet de type Categorie 
   */
     
    public static function findNom($nom) { 
        $c = Base::getConnection(); 
        try{ 
            $query = $c->prepare("select * from restaurant where nom=?") ; 
            $query->bindParam(1, $nom, PDO::PARAM_STR); 
            $query->execute(); 
  
            $rep = $query->fetch(PDO::FETCH_BOTH); 
        
            $cat = new Restaurant(); 
            $cat->id = $rep['id']; 
            $cat->nom = $rep['nom']; 
            $cat->description = $rep['description']; 
			$cat->adresse = $rep['adresse'];
			$cat->contact = $rep['contact'];
			$cat->id_theme = $rep['id_theme'];
			$cat->image = $rep['image'];
			
            return $cat; 
  
      }catch(BaseException $e){ 
        return null; 
      }      
    } 
  
      
    /** 
     *   Renvoie toutes les lignes de la table categorie 
     *   sous la forme d'un tableau d'objet 
     *   
     *   @return Array renvoie un tableau de categorie 
     */
      
    public static function findAll() { 
        $c = Base::getConnection(); 
        try{ 
            $query = $c->prepare("select * from restaurant order by nom") ; 
            $query->execute(); 
              
            $rep = $query->fetchAll(); 
              
            // Créé l'Array $tab avec l'ensemble des lignes 
            $i = 0;  
            $tab = null; 
              
            foreach($rep as $ligne){ 
                $cat = new Restaurant(); 
                $cat->id = $ligne[0]; 
                $cat->nom = $ligne[1]; 
                $cat->description = $ligne[2]; 
				$cat->adresse = $ligne[3];
				$cat->contact = $ligne[4];
				$cat->id_theme = $ligne[5];
                  $cat->image = $ligne[6];
                $tab[$i] = $cat; 
                $i++;    
            } 
            return $tab; 
      
        }catch(BaseException $e){ 
            return null; 
        }        
    }
	
/** 
   *   Retrouve la ligne de la table correspondant au id_theme passé en paramètre, 
   *   retourne un objet 
   *   
   *   @static 
   *   @param integer $id OID to find 
   *   @return restaurant renvoie un objet de type Restaurant
   */

    public static function findByIdTheme($id_th) { 
        $c = Base::getConnection(); 
        try{ 
            $query = $c->prepare("select * from restaurant where id_theme=?") ; 
            $query->bindParam(1, $id_th, PDO::PARAM_INT); 
            $query->execute(); 
  
            $rep2 = $query->fetchAll(); 
			
			$j = 0;  
            $tab2 = null; 
              
            foreach($rep2 as $ligne2){ 
                $cat2 = new Restaurant(); 
                $cat2->id = $ligne2[0]; 
                $cat2->nom = $ligne2[1]; 
                $cat2->description = $ligne2[2]; 
				$cat2->adresse = $ligne2[3];
				$cat2->contact = $ligne2[4];
				$cat2->id_theme = $ligne2[5];
                  $cat2->image = $ligne2[6];
                $tab2[$j] = $cat2; 
                $j++;    
            } 
            return $tab2; 
      
        }catch(BaseException $e){ 
            return null; 
        }        
    }
   
}