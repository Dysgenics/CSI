<?php 

include_once 'Plats.php';
include_once 'Base.php';

if(!isset($_SESSION)) 
{ 
	session_start(); 
}

if(isset($_GET['id']) && $_GET['id'] != null){
	$plat = Plats::findById($_GET['id']);

	$i = count ($_SESSION['liste']);
	
	if($i == 0){
		$ligne['plat']=$plat;
		$ligne['qte'] = 1;
		$_SESSION['liste'][0] = $ligne;
		
		header("location:". $_SERVER['HTTP_REFERER']);
	}else{
	
		foreach($_SESSION['liste'] as $j){
			if ($j['plat']->id == $_GET['id']){
				$j['qte'] +=1;
				echo't';
				header("location:". $_SERVER['HTTP_REFERER']);
			}
		
			
			
		$ligne['plat']=$plat;
		$ligne['qte'] = 1;
		$_SESSION['liste'][$i] = $ligne;
		header("location:". $_SERVER['HTTP_REFERER']);
		}
	}
}




?>