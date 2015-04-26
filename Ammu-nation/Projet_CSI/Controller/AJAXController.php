<?php
session_start();



if(isset($_GET['a']))
    $_GET['a']();

function addProduitToPanier()
{
   include_once("../Controller/ControllerContient.php");
    $ok = ControllerContient::Ajouterproduit($_GET['id'],$_SESSION['id_com'], $_GET['q'],0,$_GET['prix']);
    //var_dump($ok);
    echo json_encode($ok);
}

?>
