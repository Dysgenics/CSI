<?php

if(!isset($_SESSION)) 
{ 
session_start(); 
}

include_once 'Affichage.php' ;
include_once 'Theme.php';
include_once 'Restaurant.php';
include_once 'Controller.php';
include_once 'Plats.php';

class SiteController extends Controller {
	
	// Constructeur
	public function __construct(){
		parent::__construct();
		$this->tab['resto'] = 'restoAction';
		$this->tab['panier'] = 'neutreAction';
		$this->tab['theme'] = 'themeAction';
		$this->tab['inscr'] = 'neutreAction';
		$this->tab['cont'] = 'neutreAction';
	}
	
	
	// Affiche les restaurant d'un theme
	public function themeAction($param=null){
		$theme = Theme::findAll();	
		$donne = array('resto'=> $theme);
		
		$int = 1;
		foreach ($theme as $i){
		$resto = Restaurant::findByIdTheme($i->id);
		$donne[$int]=$resto;
		$int++;
		}
		
		$a = new Affichage($donne);
		$a->body($param['act']);
	}
	
	public function restoAction($param){

		$plat = Plats::findByIdResto($param['id']);
	
		$resto = Restaurant::findById($param['id']);
		
		if($plat != null) {
			$plat['resto'] = $resto;			
		}else{
			$plat = array('resto'=> $resto);	
		}
		
		$a = new Affichage($plat);
		$a->body($param['act']);
		
	
	}

	// Inscription 
	public function neutreAction($param){
		$a = new Affichage($param);
		$a->body($param['act']);
	}

	
	// Lance la méthode par défault
	public function pardef(){
		$this->themeAction();
	}
}