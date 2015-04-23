<?php
session_start();
include 'ControllerContient.php';

$_GET['a']();

function addProduitToPanier()
{
   
    $ok = ControllerContient::Ajouterproduit($_GET['id'],$_SESSION['id_com'], $_GET['q'],0,$_GET['prix']);
    //var_dump($ok);
    echo json_encode($ok);
}

?>
