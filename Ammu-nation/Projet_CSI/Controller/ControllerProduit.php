<?php

include_once '..\..\Model\Produit.php';

/*
* Controleur d'un produit
* Appelle les fonctions liées à un produit
*/
 
class ControllerProduit {

	/**
    * Recherche toutes les produits vendus par le magasin
    * Renvoit une liste de produit
    */
	public static function AfficherProduit($mag) {
			$r = Produit::findAll($mag);
			$output = '<tr>';
			foreach ($r as $row) {
				$output .= '<td>'.'<img src=# width=150px height=110px;/>'.'</td><td><a href=#>' .$row['nom_produit'] . '</a></td>';
			}
			
			// <a href="?prod='. $row['id_produit'] .'">
			$output .= '</tr>';
			
			echo $output;
	}
	
	
	/**
    * Recherche toutes les produits vendus par le magasin
    * Renvoit une liste de produit
    */
	public static function AfficherProduitCateg($mag, $cat) {
		$r = Produit::findByCateg($mag, $cat);
		$output = '<table>';
		foreach ($r as $row) {
			$output .= '<tr><td class="ListeProduits_td_img">'.'<img src='.$row['img_url'] .' width=150px height=110px;/>'.'</td><td class="ListeProduits_desc">' .$row['nom_produit'] . '</td></tr>';
		}
		$output .= '</table>';
		echo $output;
	}
	
	public static function DetailProduit($id_prod) {
		$r = Produit::findById($id_prod);
		$output = '<div class="test">';
		foreach ($r as $row) {
			$output .= '<p> Libellé:'. $row['libelle'] .'</p><p> Afficher le reste </p>';
		}
		$output .= '</div>';
		echo $output;
	}
}
?>