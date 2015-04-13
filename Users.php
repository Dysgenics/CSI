<?php

/**
 * Classe representant un Utilisateur du blog
 */
 class users {
	
	private $id, $email, $passwd, $nom, $prenom, $societe, $adresse, $numtel;
	
	// Constructeur vide
	public function _construct(){
	}
	
  /**
   *   Fonction d'acces aux attributs d'un objet.
   *   Recoit en parametre le nom de l'attribut accede
   *   et retourne sa valeur.
   */
	public function __get($attr_name) {
    	if (property_exists( __CLASS__, $attr_name)) { 
    		return $this->$attr_name;
    	}else{
    		$emess = __CLASS__ . ": unknown member $attr_name (getAttr)";
    		throw new Exception($emess, 45);
		}
  	}
	
  /**
   *   Fonction de modification des attributs d'un objet.
   *   Recoit en parametre le nom de l'attribut modifie et la nouvelle valeur
   */
   
	public function __set($attr_name, $attr_val) {
    	if (property_exists( __CLASS__, $attr_name)) { 
     		$this->$attr_name = $attr_val;
		}else{
   			throw new Exception("Attribut invalide");
		}
	}
	
	
	// Cherche un utilisateur grâce à son ID.
	public static function findById($param){
		$c = Base::getConnection();
		try{
      		$query = $c->prepare("select * from users where id =?") ;
			$query->bindParam(1, $param, PDO::PARAM_INT); 
      	    $query->execute();

    	    $rep = $query->fetch(PDO::FETCH_BOTH);
      
			$user = new users();
			$user->id = $rep['id'];
			$user->nom = $rep['nom'];
			$user->prenom = $rep['prenom'];
			$user->email = $rep['email'];		
			$user->passwd = $rep['passwd'];
			$user->adresse = $rep['adresse'];
			$user->numtel = $rep['numtel'];
			$user->societe = $rep['societe'];
			
			return $user;

		}catch(BaseException $e){
			return null;
	    }	
	}
	
	// Cherche un utilisateur grâce à son ID.
	public static function findAll(){
		$c = Base::getConnection();
		try{
      		$query = $c->prepare("select *  from users") ;
      	    $query->execute();
    	    $rep = $query->fetchAll();
			
			$int = 0; 
			$tab=null;
	  		foreach($rep as $ligne){
      
			$user = new users();
			$user->id = $ligne['id'];
			$user->email = $ligne['email'];
			$user->prenom = $ligne['prenom'];
			$user->nom = $ligne['nom'];		
			$user->societe = $ligne['societe'];
			$user->passwd = $ligne['passwd'];
			$user->numtel = $ligne['numtel'];
			
				$tab[$int]=$user;
				$int++;
			}
			
			return $tab;

		}catch(BaseException $e){
			return null;
	    }	
	}
	
	
	// Retourne le login correspond à l'ID
	public static function getemail($id) {
		$c = Base::getConnection();
		try{
      		$query = $c->prepare("select email from users where id=?") ;
			$query->bindParam(1, $id, PDO::PARAM_INT); 
			
      	    $query->execute();
    	   	$rep = $query->fetch(PDO::FETCH_BOTH);
			
			return $rep['email'];
			
		}catch(BaseException $e){
			return null;
	    }	
	}
	
	
	// Insère un nouvel utilisateur dans la base
	public function insert() { 
		$c = Base::getConnection();
		$insert_query = "insert into users (email, passwd ,nom, prenom, adresse, societe, numtel ) values (:email, :passwd, :nom, :prenom, :adresse, :societe, :numtel)" ;
		try{
			$stmt = $c->prepare($insert_query);
			$rep = $stmt->execute( array(':email'=>$this->email, ':passwd'=>$this->passwd, ':nom'=>$this->nom, ':prenom'=>$this->prenom, ':adresse'=>$this->adresse, ':societe'=>$this->societe, ':numtel'=>$this->numtel));
					
		}catch(BaseException $e){
			return null;
	    }	
	}
	
	// Supprime l'utilisateur d'ID $id
	public function delete() {
    	$c = Base::getConnection();
		if (!isset($this->id)) {
			throw new MyException("ID inexistant ");
		}	
		try{
 		    $query = $c->prepare( "delete from users where id=?");
   			$query->bindParam (1, $this->id, PDO::PARAM_INT);
			
			return $query->execute();
			
		}catch(BaseException $e){
	  		return 0;
		}
  	}
 }