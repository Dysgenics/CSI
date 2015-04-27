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
        var_dump($_POST);
        //ControllerContient::reserverHoraire($_POST['jour'], $_POST['heure'], , $_POST['id_com'], , $_POST['id_cli'], $_POST['id_mag'])
        //header('Location: ../View/html/notreDrive.php?validerCom');
    }
}

function addProduitToPanier()
{
   include_once("../Controller/ControllerContient.php");
    $ok = ControllerContient::Ajouterproduit($_GET['id'],$_SESSION['id_com'], $_GET['q'],0,$_GET['prix']);
    //var_dump($ok);
    echo json_encode($ok);
}

?>
