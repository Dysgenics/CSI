<?php
session_start();



if(isset($_GET['a'])){
    $_GET['a']();
}
else if(isset($_POST['action'])){
    if($_POST["action"] == "changerJour"){
        //var_dump($_POST);
        $jour = str_replace("/", "-", $_POST['jour']);
        header('Location: ../View/html/notreDrive.php?choixHoraire&date=' . $jour);
    }
    else if($_POST["action"] == "reserverHoraire"){
        include_once("../Controller/ControllerRetrait.php");
        //var_dump($_POST);
        $quaiReserve = ControllerRetrait::reserverHoraire($_POST['jour'], $_POST['heure'], $_POST['id_cli'], $_POST['id_mag'],  $_POST['id_com']);
        //$quaiLibre = ControllerRetrait::rechercherQuaiLibre($_POST['heure'],$_POST['jour'],$_POST['id_mag']);
        			
        if($quaiReserve != false)
            header('Location: ../View/html/notreDrive.php?validerCom&jour='. $_POST['jour'] . '&heure='. $_POST['heure'] . '&quai=' . $quaiReserve->NUMQUAI . '&com=' . $_POST['id_com']);
    }
}

function addProduitToPanier()
{
   include_once("../Controller/ControllerContient.php");
    $ok = ControllerContient::Ajouterproduit($_GET['id'],$_SESSION['id_com'], $_GET['q'],0,$_GET['prix']);
    //var_dump($ok);
    echo json_encode($ok);
}

function validerCom()
{
    include_once("../Controller/ControllerCommande.php");
    include_once("../Controller/ControllerRetrait.php");
    $id_com = intval($_GET["id_com"]);
    
    //verifier que le retrait existe tjr 
    $retrait = ControllerRetrait::getRetraitByCom($id_com);
    
    if($retrait == false)
    {
        //le retrait n'existe plus, il faut a nouveau reserver l'horaire
        $quaiReserve = ControllerRetrait::reserverHoraire($_GET['jour'], $_GET['heure'], $_SESSION['id_cli'], $_SESSION['id_mag'],  $id_com);
    }
    
    $ok = ControllerCommande::validerCommande($id_com);
    
    if($ok == true)
    {
        $retrait = ControllerRetrait::getRetraitByCom($id_com);
        $quai = ControllerRetrait::getQuaiById($retrait->ID_QUAI);
        ControllerCommande::creerNouveauPanier($_SESSION['id_cli'], $_SESSION['mag']['id_magasin']);
        header('Location: ../View/html/notreDrive.php?comValidee&jour='. $retrait->DATE . '&heure='. $retrait->HEURE . '&quai=' . $quai->NUMQUAI . '&com=' . $retrait->ID_COMMANDE);
    }
}

?>
