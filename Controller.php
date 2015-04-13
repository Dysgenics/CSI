<?php

abstract class Controller {
	
	// Tableau des differentes méthodes disponibles
	protected $tab; 
	
	public function __construct(){
	}
	
	/*
	 * Si les parametres ne sont pas nuls &
	 * Si param[a] n'est pas nul &
	 * Si la valeur dans le tableau correspondant à param[a] n'est pas nul
	 *
	 * Sinon on execute la methode par défaut
	*/
	public function callAction($param=null){	
		if ($param != null && $param['act'] != null && $this->tab[$param['act']] != null){	
			$nom = $this->tab[$param['act']];
			$this->$nom($param);
		}else $this->pardef();		
	}
	
	public abstract function pardef ();
}