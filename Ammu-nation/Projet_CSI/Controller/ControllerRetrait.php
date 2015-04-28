<?php

 
class ControllerRetrait {

	
	public static function Ajouterproduit($id_prod, $id_com, $q, $red, $pu) {
	    include_once("../base.php");
		
		$contientDeja = ControllerContient::rechercherProduit($id_prod, $id_com);
		
		//si la commande ne contient pas deja ce produit
		if($contientDeja == false)
		{
		    $query = "INSERT INTO CONTIENT 
			VALUES (?,?,?,?,?);";
			
			try {   
            $db = Base::getConnection();

            $pp = $db->prepare($query);
            
			$id_prod = intval($id_prod);
			$id_com = intval($id_com);
			$q = intval($q);
			
			//définition des paramètres
			$pp->bindParam(1, $id_prod, PDO::PARAM_INT);
            $pp->bindParam(2, $id_com, PDO::PARAM_INT);
			$pp->bindParam(3, $q, PDO::PARAM_INT);
            $pp->bindParam(4, $red, PDO::PARAM_STR);
			$pp->bindParam(5, $pu, PDO::PARAM_STR);		
            $res = $pp->execute();
            
            } catch (PDOException $e) {
                $res = false;
                echo $query . "<br>";
                throw new Exception($e->getMessage());
            }
		}
		else
		{
		    //sinon, il existe deja et on modifie juste la quantite, et la reduction s'il y a
		    $query = "update CONTIENT set QUANTITE=? where ID_PRODUIT=? and ID_COMMANDE=?;";
			
			try {   
            $db = Base::getConnection();

            $pp = $db->prepare($query);
            
			$id_prod = intval($id_prod);
			$id_com = intval($id_com);
			$q = intval($q) + $contientDeja['quantite'];
			
			//définition des paramètres
			$pp->bindParam(1, $q, PDO::PARAM_INT);
            $pp->bindParam(2, $id_prod, PDO::PARAM_INT);
			$pp->bindParam(3, $id_com, PDO::PARAM_INT);
           	
            $res = $pp->execute();
            
            } catch (PDOException $e) {
                $res = false;
                echo $query . "<br>";
                throw new Exception($e->getMessage());
            }
		}
		
        
        
        return $res;
    }
    
    public static function afficherHorairesLibres($id_magasin, $date) {
	    $query = "  select distinct HORAIRE.HEURE
                    from HORAIRE
                    inner join QUAI 
                    where QUAI.ID_MAGASIN = ?
                    and CONCAT(QUAI.ID_QUAI, HORAIRE.HEURE) not in (
                    
                    	select CONCAT(RETRAIT.ID_QUAI, RETRAIT.HEURE) as CQH /* selectionne les quai-horaires reserves pour le jour */
                    	from RETRAIT
                    	inner join QUAI on QUAI.ID_QUAI = RETRAIT.ID_QUAI
                    	where RETRAIT.DATE = ? and QUAI.ID_MAGASIN = ?
                    );";
                    
		//include_once("../base.php");
        try {   
            $db = Base::getConnection();

            $pp = $db->prepare($query);
            
			$id_magasin = intval($id_magasin);
			
			$year = substr($date, -4);
    			$mon = substr($date, 3,2);
    			$day = substr($date, 0,2);
    			$jourSQL = $year . '-' . $mon . '-' . $day;
			
			//définition des paramètres
			$pp->bindParam(1, $id_magasin, PDO::PARAM_INT);
            $pp->bindParam(2, $jourSQL, PDO::PARAM_STR);
            $pp->bindParam(3, $id_magasin, PDO::PARAM_INT);
		
            $res = $pp->execute();
            
            $res = $pp->fetchAll(PDO::FETCH_OBJ);
            
            
            
            
        } catch (PDOException $e) {
            $res = false;
            echo $query . "<br>";
            throw new Exception($e->getMessage());
        }
        
        return $res;
    }
    
    public static function AfficherPanierReduit($id_com) {
	    	
		//on recherche toutes les catégories
		include_once("../../base.php");
	
		$query = "select HEURE, ID_QUAI from RETRAIT where DATE=CURRENT_DATE();";
		
			try{
			
				$db = Base::getConnection();

				$pp = $db->prepare($query);
				
				$id_prod = intval($row['id_produit']);
				$pp->bindParam(1, $id_prod, PDO::PARAM_INT);
				$pp->execute();
				$res = $pp->fetch(PDO::FETCH_OBJ);
				$ligne_tot = (intval($row["quantite"]) * doubleval($row['prix_unitaire']) );
			    $nb_prod = $nb_prod + intval($row['quantite']);
				$tot = $tot + $ligne_tot;
				
			}   catch (PDOException $e) {
				$res = false;
				echo $query . "<br>";
				throw new Exception($e->getMessage());
			}
	
		$output = '<p><a class="aBtn" href="notreDrive.php?panier">Panier : ' . $nb_prod . ' produits. TOTAL : ' . $tot . '</a></p>';
		
		echo $output;
		//var_dump($output);
	}
    
	
	/* 
	 * 
	*/
	public static function AfficherPanier($id_com) {
	    	
		//on recherche toutes les catégories
		include_once("../../base.php");
		$id_com = intval($id_com);
        $r = Contient::findAll($id_com);
        //var_dump($r);
		$output = '<table><tr><td> PRODUIT </td><td> QUANTITE </td><td> PRIX UNITAIRE </td><td> PRIX TOTAL </td></tr>';
		$tot = 0;
        foreach ($r as $row) {
		$query = "SELECT * FROM PRODUIT where ID_PRODUIT=?;";
		
			try{
			
				$db = Base::getConnection();

				$pp = $db->prepare($query);
				
				$id_prod = intval($row['id_produit']);
				$pp->bindParam(1, $id_prod, PDO::PARAM_INT);
				$pp->execute();
				$res = $pp->fetch(PDO::FETCH_OBJ);
				$ligne_tot = (intval($row["quantite"]) * doubleval($row['prix_unitaire']) );
				$output .= '<tr><td>'.$res->NOM_PRODUIT .'</td><td> ' . $row["quantite"] . ' </td><td> ' . $row['prix_unitaire'] . ' </td><td> ' . $ligne_tot  . ' </td><td> (bouton pour retirer un ou plusieurs produits) </td></tr>';
				$tot = $tot + $ligne_tot;
				
			}   catch (PDOException $e) {
				$res = false;
				echo $query . "<br>";
				throw new Exception($e->getMessage());
			}
		}
		$output .= '<tr><td>TOTAL</td><td></td><td></td><td>' . $tot .'</td></tr></table>';
		$output .= '<p><a class="aBtn" href="?choixHoraire">Valider la commande</a></p>';
		
		echo $output;
		//var_dump($output);
	}
	
	public static function reserverHoraire($jour, $heure, $id_cli, $id_mag, $id_com) {
	
	include_once("../base.php");
	
	 $quaiLibre = ControllerRetrait::rechercherQuaiLibre($heure, $jour, $id_mag);
	    //$quaiLibre = false;
	        //si il y a encore un quai de libre pour l'horaire
			if($quaiLibre != false)
    		{
    		    $query = "INSERT INTO RETRAIT(`ID_QUAI`,`ID_COMMANDE`,`HEURE`,`DATE`)
    			VALUES (?,?,?,?);";
    			
    			try {   
                $db = Base::getConnection();
    
                $pp = $db->prepare($query);
                
    			$id_mag = intval($id_mag);
    			$id_com = intval($id_com);
    			$id_quai = intval($quaiLibre->ID_QUAI);
    			
    			$year = substr($jour, -4);
    			$mon = substr($jour, 3,2);
    			$day = substr($jour, 0,2);
    			$jourSQL = $year . '-' . $mon . '-' . $day;
    			
    			//définition des paramètres
    			$pp->bindParam(1, $id_quai, PDO::PARAM_INT);
                $pp->bindParam(2, $id_com, PDO::PARAM_INT);
    			$pp->bindParam(3, $heure, PDO::PARAM_STR);	
    			$pp->bindParam(4, $jourSQL, PDO::PARAM_STR);	
                $res = $pp->execute();
                $id_retrait = $db->lastInsertId(); 
                
                
                
                } catch (PDOException $e) {
                    $res = false;
                    echo $query . "<br>";
                    throw new Exception($e->getMessage());
                }
                
                //si l'insertion s'est bien faite, on créé l'evenement de verouillage temporel
                
                if($res == true)
                {
                    $query = "  SET GLOBAL event_scheduler = ON;
                                CREATE EVENT verrou_retrait_?
                                ON SCHEDULE AT ?
                                DO
                                	DELETE FROM RETRAIT WHERE RETRAIT.ID_RETRAIT = ? AND RETRAIT.ID_COMMANDE NOT IN (
                                	
                                	    SELECT ID_COMMANDE
                                	    FROM COMMANDE
                                	    WHERE COMMANDE.ID_CLI = ? AND COMMANDE.VALIDE = 0
                                	)
                                ;";
        			
        			try {   
                    $db = Base::getConnection();
        
                    $pp = $db->prepare($query);
                    
        			$id_retrait = intval($id_retrait);
        			
        			$date_deverouillage = new DateTime('NOW');
        			date_add($date_deverouillage, date_interval_create_from_date_string('20 minutes'));
        			$date_deverouillage = $date_deverouillage->format('Y-m-d H:i:s');
        			//on ajoute que 20min, pas 2h20 puisque MySQL est reglé sur GMC+0000
        			$id_cli = intval($id_cli);
        			
        			//définition des paramètres
        			$pp->bindParam(1, $id_retrait, PDO::PARAM_INT);
                    $pp->bindParam(2, $date_deverouillage, PDO::PARAM_STR);
        			$pp->bindParam(3, $id_retrait, PDO::PARAM_INT);	
        			$pp->bindParam(4, $id_cli, PDO::PARAM_INT);	
                    
                    $res = $pp->execute();
                   
                    
                    } catch (PDOException $e) {
                        $res = false;
                        echo $query . "<br>";
                        throw new Exception($e->getMessage());
                    }
                    
                    return $quaiLibre;
                }
                
                return $res;
    		}
    		else{
    		    //sinon on retournes au choix des horaires
    		    $jour = str_replace("/", "-", $jour);
    		    header('Location: ../View/html/notreDrive.php?choixHoraire&date=' . $jour . '&retry');
    		}
    	
    	
    }

    public static function rechercherQuaiLibre($heure, $date, $id_mag) {
	    $query = "SELECT ID_QUAI, NUMQUAI FROM QUAI
					WHERE QUAI.ID_QUAI not in (
                    
                    	select RETRAIT.ID_QUAI /* selectionne les quai reserves pour l'horaire a tel magasin */
                    	from RETRAIT
                    	inner join QUAI on QUAI.ID_QUAI = RETRAIT.ID_QUAI
                    	where RETRAIT.DATE = ? and QUAI.ID_MAGASIN = ? and RETRAIT.HEURE = ?
                    )
                    ORDER BY NUMQUAI
                    LIMIT 1;";
					
					
		include_once("../base.php");
        try {   
            $db = Base::getConnection();

            $pp = $db->prepare($query);
            
			$id_mag = intval($id_mag);
		
			$year = substr($date, -4);
    			$mon = substr($date, 3,2);
    			$day = substr($date, 0,2);
    			$jourSQL = $year . '-' . $mon . '-' . $day;
    			
			//définition des paramètres
			$pp->bindParam(1, $jourSQL, PDO::PARAM_STR);
            $pp->bindParam(2, $id_mag, PDO::PARAM_INT);
            $pp->bindParam(3, $heure, PDO::PARAM_STR);
		
            $res = $pp->execute();
            
            $res = $pp->fetch(PDO::FETCH_OBJ);
            
            if($res != false)
            {
               
                return $res;
            }
            
            
        } catch (PDOException $e) {
            $res = false;
            echo $query . "<br>";
            throw new Exception($e->getMessage());
        }
        
        return $res;
    }
    
    
    public static function getRetraitByCom($id_com) {
	    $query = "SELECT * FROM RETRAIT WHERE ID_COMMANDE=?;";
					
					
		include_once("../base.php");
        try {   
            $db = Base::getConnection();

            $pp = $db->prepare($query);
            
			$id_com = intval($id_com);
		
		
			$pp->bindParam(1, $id_com, PDO::PARAM_INT);
            
		
            $res = $pp->execute();
            
            $res = $pp->fetch(PDO::FETCH_OBJ);
            
             
                return $res;
            
            
            
        } catch (PDOException $e) {
            $res = false;
            echo $query . "<br>";
            throw new Exception($e->getMessage());
        }
        
        return $res;
    }
    
    public static function getQuaiById($id_quai) {
	    $query = "SELECT * FROM QUAI WHERE ID_QUAI=?;";
					
					
		include_once("../base.php");
        try {   
            $db = Base::getConnection();

            $pp = $db->prepare($query);
            
			$id_quai = intval($id_quai);
		
		
			$pp->bindParam(1, $id_quai, PDO::PARAM_INT);
            
		
            $res = $pp->execute();
            
            $res = $pp->fetch(PDO::FETCH_OBJ);
            
             
                return $res;
            
            
            
        } catch (PDOException $e) {
            $res = false;
            echo $query . "<br>";
            throw new Exception($e->getMessage());
        }
        
        return $res;
    }
}
?>