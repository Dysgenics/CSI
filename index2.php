<?php

include 'Controller.php';
include 'Plats.php';
include 'SiteController.php';

if(!isset($_SESSION)) 
{ 
session_start(); 
}


$c=new SiteController() ;

/* Récupération des attributs donnée en lien
 * Toutes URL contiendra un a = .. et un id = ..
 * 
 * Si 'a' ou 'id' n'apparait pas c'est que l'utilisateur 
 * a modifié l'URL on appelle la methode par défaut
 */

if (isset($_GET['act']) && isset($_GET['id'])){
	$var1 = $_GET['act'];
	$var2 = $_GET['id'];
	$c->callAction(array('act'=> $var1, 'id'=>$var2)) ;
}else{
	$c->callAction() ;	
}