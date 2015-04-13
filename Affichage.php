<?php
  
 include_once 'Base.php';
include_once 'Theme.php';
include_once 'Restaurant.php';
include_once 'SiteController.php';

if(!isset($_SESSION)) 
{ 
session_start(); 
}
  

  
  
  
class Affichage {
      
    /**
     * Tableau des possiblités
     */
    private $tab;
      
    /**
     * Donnée à afficher
     */
    private $donnee;
      
    public function __construct($param = null){
        $this->tab['resto'] = 'bloc_Plats';
        $this->tab['panier'] = 'bloc_panier';
        $this->tab['theme'] = 'bloc_Theme';
        $this->tab['inscr'] = 'inscriAction';
		$this->tab['cont'] = 'contAction';
          
        $this->donnee = $param;
          
    }
      
      
    public function body($param = null){
          
    echo "<!DOCTYPE php>
<php lang=\"en\">
     <head>
     <title>Home</title>
     <meta charset=\"utf-8\">
     <link rel=\"stylesheet\" href=\"css/style.css\">
     <script src=\"js/jquery.js\"></script>
     <script src=\"js/jquery-migrate-1.1.1.js\"></script>
     <script src=\"js/jquery.equalheights.js\"></script>
     <script src=\"js/jquery.ui.totop.js\"></script>
     <script src=\"js/jquery.easing.1.3.js\"></script>
     <script src=\"js/jquery.tabs.min.js\"></script>
     <script src=\"js/touchTouch.jquery.js\"></script>
 	 <script>
        $(document).ready(function(){

          $().UItoTop({ easingType: 'easeOutQuart' });
         $('.gallery a.gal').touchTouch();
         
       }) 
     </script>


    
     <!--[if lt IE 8]>
       <div style=\" clear: both; text-align:center; position: relative;\">
         <a href=\"http://windows.microsoft.com/en-US/internet-explorer/products/ie/home?ocid=ie6_countdown_bannercode\">
           <img src=\"http://storage.ie6countdown.com/assets/100/images/banners/warning_bar_0000_us.jpg\" border=\"0\" height=\"42\" width=\"820\" alt=\"You are using an outdated browser. For a faster, safer browsing experience, upgrade for free today.\" />
         </a>
    <![endif]-->
    <!--[if lt IE 9]>
      
      <script src=\"js/php5shiv.js\"></script>
      <link rel=\"stylesheet\" media=\"screen\" href=\"css/ie.css\">
    <![endif]-->
    <!--[if lt IE 10]>
      <link rel=\"stylesheet\" media=\"screen\" href=\"css/ie1.css\">
    <![endif]-->
      
     </head>
     <body class=\"page1\">
  
<!--==============================header=================================-->
 <header> 
  <div class=\"container_12\">
   <div class=\"grid_12\"> 
    <h1><a href=\"index.php\"><img src=\"images/logo.png\" alt=\"Boo House\"></a> </h1>
    <div class=\"menu_block\">
  
  
    <nav id=\"bt-menu\" class=\"bt-menu\">
        <a href=\"#\" class=\"bt-menu-trigger\"><span>Menu</span></a>
        <ul>
         <li class=\"current bt-icon\"><a href=\"index.php\">Home</a></li>
         <li class=\"bt-icon\"><a href=\"index2.php?act=theme&id=0\">Restaurants</a></li>
          <li class=\"bt-icon\"><a href=\"index.php\"></a></li>
         <li class=\"bt-icon\"><a href=\"index2.php?act=panier&id=0\">";
		 
		if (isset($_SESSION['liste'])){
			$int = count($_SESSION['liste']);
			echo "Panier (".$int.")";
		}else echo "Panier";
		 
		 echo"</a></li>
         <li class=\"bt-icon\"><a href=\"index2.php?act=cont&id=0\">Contact</a></li>
         <li class=\"bt-icon\"><a href=\"index.php\"></a></li>
         <li class=\"bt-icon\"><a href=\"index.php\"></a></li>
        </ul>
      </nav>
      
 <div class=\"clear\"></div>
</div>
<div class=\"clear\"></div>
          </div>
      </div>
</header>
  
<div class=\"content\"><div class=\"ic\"></div>
  <div class=\"container_12\">

  
        ";
          
         // Choisit quel méthode appeller
  
      if ($param != null && $this->tab[$param] != null){
            $nom = $this->tab[$param];
            echo $this->$nom();
        }else{
            echo $this->bloc_theme();
        }
    $this->footer();
    }
      
	  
	 public function bloc_Plats(){
		$resto = Restaurant::findById($this->donnee[0]->id_resto);
		
		$theme = Theme::findById($resto->id_theme);
		
		
		$ret = "<div class=\"grid_12\">
					<h3 class=\"head2\">Nos plats $theme->nom</h3>
				</div> <div class=tabs tb gallery>
             <div class=div-nav >
             <div class=grid_12>
                 <ul class=nav>";

		$ret = $ret . "<div class=ntm> ".$theme->nom."</div>";
		
		$plat = Plats::findByIdResto($this->donnee[0]->id_resto);
		
		
		$Resto =  Restaurant::findById($this->donnee[0]->id_resto);
		
			$ret = $ret . "<li class=\"selected\" ><a href=#>".$Resto->nom."</a>
                        </li>
						<li><a href=\"index2.php?act=theme&id=0\">Les autres restaurants</a>
                        </li>";
		
		$ret = $ret."</ul></div></div> <div class=\"div-tabs\">";
			
		
	
			foreach($plat as $tab){
	
			$ret = $ret . "<div class=\"grid_3\">
                    <a href=\"ajoutPanier.php?id=".$tab->id."\" class=\"gal\"><img src=image/originales/".$tab->photo." style = \" width : 200px; height : 150px; border: 1px solid #000000;\"><span></span></a>
                    <div class=\"col2\"><span class=\"col3\"><a href=\"#\">".$tab->nom." ". "</br>(".$tab->prix ." €".")"."</a></span></div>
					</div>";
			}
		// $ret = $ret."</div>";
		
		$ret = $ret."</div></div></div></div>";
		return $ret;
	 
	 }
      
    // Affiche toutes les catégories
    public function bloc_theme(){
          
        $ret = " <div class=\"grid_12\">
    		 <h3 class=\"head2\">Nos thèmes</h3>
   			 </div>
			 <div class=tabs tb gallery>
             <div class=div-nav >
             <div class=grid_12>
                 <ul class=nav>";
                      
        $all = Theme::findAll();
      $k = 1;
        foreach ($all as $i) {
			if ($k==1){
				$ret = $ret."
                   <li class=\"selected\"><a href=#tab-".$k." class=\"\">".$i->nom."</a>
                   </li>";
				$k++;
			
			}else{
           		$ret = $ret."
                            <li><a href=#tab-".$k.">".$i->nom."</a>
                        </li>";
						$k++;
			}
        }
          $l=1;
		 
		  $ret = $ret."</ul></div>
		  </div> <div class=\"div-tabs\"></br>";
			for($l;$l<=5;$l++){
			$ret= $ret."<div  id=\"tab-". $l ."\" class=\"tab-content gallery". $l ."\" style=\"display: block;\">
			";
	
					foreach($this->donnee[$l] as $h){

                  $ret = $ret."<div class=\"grid_3\">
				  <a href=\"index2.php?act=resto&id=".$h->id."\" class=\"gal\"><img src=\"images/".$h->image."\" style = \" width : 200px; height : 200px; border: 1px solid #000000;\" alt=\"\"><span></span></a>
				  
                    <div class=\"col2\"><span class=\"col3\"><a href=\"#\">".$h->nom."</a></span></div>
					</div>";
					}
			$ret = $ret."</div>";
			}
			$ret = $ret."</div></div></div></div>";
        return $ret;
    }
      
	  

  public function inscriAction(){
	$ret = "<div class=\"content\"><div class=\"ic\"></div>
  <div class=\"container_12\">
    <div class=\"grid_8\">
      <h3>Inscription</h3>";
	  
	  if (isset($_SESSION['tmpi'])){
     	if($_SESSION['tmpi']=='email'){
       		 $ret = $ret."Erreur de mot de passe";
        }else{
    		$ret = $ret."Erreur de mot de passe";
      }
	  }
	  
	  $ret = $ret . "<div id ='Inscription'>
			<form method='post' action='Inscription.php'>
				<fieldset>
					<div id=\"bouton\">
						<label class=\"float\"> Entrez votre email :</label> <input type='text' name='email'/> <br/>
					</div>
					<div id=\"bouton\">
						<label class=\"float\"> Entrez votre password : </label> <input type='password' name='password'/> <br/>
					</div>
					<div id=\"bouton\">
						<label class=\"float\"> Confirmez votre password : </label> <input type='password' name='password2'/> <br/>
					</div>
					<div id=\"bouton\">
						<label class=\"float\"> Entrez votre nom : </label> <input type='varchar' name='nom'/> <br/>
					</div>
					<div id=\"bouton\">
						<label class=\"float\"> Entrez votre prenom : </label> <input type='varchar' name ='prenom'/> <br/>
					</div>
					<div id=\"bouton\">
						<label class=\"float\"> Entrez le nom de votre societe :</label> <input type='varchar' name ='societe'/> <br/>
					</div>
					<div id=\"bouton\">
						<label class=\"float\"> Entrez votre adresse : </label> <input type='text' name='adresse'/> <br/>
					</div>
					<div id=\"bouton\">
						<label class=\"float\"> Entrez votre numero de tel : </label> <input type='int' name='numtel'/> <br/>
					</div>
                    </br> </br>
						<input type='submit' class= \"bouton_submit\" name='submit' value='Terminer'/>
		</form></div>
    </div>
   <div class=\"grid_4\">
      <div class=\"hours\">
        <div class=\"title\">Connect</div>
        <div>";
		
		  if (isset($_SESSION['tmp'])){
     	if($_SESSION['tmp']=='mdp'){
       		 $ret = $ret."Erreur de mot de passe";
        }else{
    		$ret = $ret."Erreur de login";
      } }
	  
	  
	  $ret= $ret . "<form method='post' action='log.php'>
			Entrez votre email : <input type='text' name='login_signin'/> <br/>
			Entrez votre password : <input type='password' name='password_signin'/> <br/>
			<input type='submit' class=formbutton name='form_login_submit' value='Terminer'/>
			</br></br>
			</form>
        </div>
      </div>
    </div>
  </div>
</div>";
	
	return $ret;  
  }

	public function contAction(){
	 echo" <script src=\"js/TMForm.js\"></script>
     <script src=\"js/jquery.easing.1.3.js\"></script>
     <script type=\"text/javascript\" src=\"https://maps.google.fr/maps/ms?msa=0&msid=202742999222153972536.0004b3969760d9f54b561&ie=UTF8&t=m&source=embed&ll=48.682758,6.161957&spn=0.004958,0.00912&z=16&output=embed;sensor=false\"></script>

		
<div class=\"content contact\">
  <div class=\"container_12\">
      <div class=\"clear\"></div>
        <h3 class=\"head3\">Adresse</h3>
              <div class=\"map\">
			  	<div class=\"part1\">
				<iframe width=\"450\" height=\"350\" frameborder=\"0\" scrolling=\"no\" marginheight=\"0\" marginwidth=\"0\" src=\"https://maps.google.fr/maps?f=q&amp;source=s_q&amp;hl=fr&amp;geocode=&amp;q=2+ter+Boulevard+Charlemagne,+Nancy&amp;aq=0&amp;oq=2+ter&amp;sll=48.687901,6.178265&amp;sspn=0.081253,0.209255&amp;ie=UTF8&amp;hq=&amp;hnear=2+ter+Boulevard+Charlemagne,+54000+Nancy,+Meurthe-et-Moselle,+Lorraine&amp;t=m&amp;z=14&amp;ll=48.683079,6.16175&amp;output=embed\"></iframe><br /><small><a href=\"https://maps.google.fr/maps?f=q&amp;source=embed&amp;hl=fr&amp;geocode=&amp;q=2+ter+Boulevard+Charlemagne,+Nancy&amp;aq=0&amp;oq=2+ter&amp;sll=48.687901,6.178265&amp;sspn=0.081253,0.209255&amp;ie=UTF8&amp;hq=&amp;hnear=2+ter+Boulevard+Charlemagne,+54000+Nancy,+Meurthe-et-Moselle,+Lorraine&amp;t=m&amp;z=14&amp;ll=48.683079,6.16175\" style=\"color:#0000FF;text-align:left\">Agrandir le plan</a></small>	
				</div>
				<div class=\"part2\">


                <address>
                              <dl>
                                  <dt>IUT Nancy Charlemagne <br>
                                      2 ter Boulevard Charlemagne<br>
                                      54000 Nancy
                                  </dt>
                                  <dd><span>Telephone:</span>03.54.50.38.00</dd>
                </address>
                           <p><h2>A pied</h2>

							L'IUT se trouve à 15 minutes à pied de la gare SNCF

								<h2>En bus - Réseau Stanbus</h2>

							Les lignes 3 (arrêt Médreville) et 6 (arrêt Charlemagne) desservent l'IUT

							Consultez le plan du réseau Stanbus

								<h2>En vélo ou en voiture</h2>

							L'institut dispose d'un garage à vélo fermé à clefs et d'un parking pour les voitures réservé aux étudiants ( environ 100 places).

								<h2>Personnels en situation de handicap</h2>

								L’IUT est accessible aux personnes handicapées avec des aménagements spécifiques : ascenseurs, amphithéâtres, toilettes
				</div>
            </div>
  </div>
</div>
	";
	}

	 public function bloc_panier(){
		
		$ret = "<div class=\"content\"><div class=\"ic\"></div>
					<div class=\"container_12\">
					<div class=\"grid_8\">
						<h3>Affichage de votre panier</h3>
						  <div class=\"extra_wrapper\">";
							
		$tot =0;
		if(isset($_SESSION['liste'])){
			$ret = $ret . "<div class=panier>";
			foreach ($_SESSION['liste'] as $ligne){
				$tot = $tot + ($ligne['plat']->prix * $ligne['qte']);
				$ret = $ret ."".$ligne['plat']->nom." Qte : ".$ligne['qte']." Prix : ".$ligne['plat']->prix." Total :".($ligne['plat']->prix * $ligne['qte'])."</br>";		
			}
		
		$ret =$ret ." <div>Montant total $tot</div>
		<form method='post' action='index2.php?act=inscr&id=0'>
		</br>
		<input type='submit' name='submit' class='submit' value='Continuer'/>
		</form> 
					</div>

					  </div>
					</div>
				  </div>";
				  
				  
		echo $ret;
	 
		}
		else {
			echo $ret;
			echo "Aucun article dans le panier";
			}
	 }
  public function footer(){
  
  
  $footer= "
<!--==============================footer=================================-->
  
<footer>    
  <div class=\"container_12\">
    <div class=\"grid_6 prefix_3\">
      <a href=\"index.php\" class=\"f_logo\"><img src=\"images/logo.png\"></a>
      <div class=\"copy\">
      &copy; Chaboissier Maxime - Cuny Kilian - Joly Nicolas - Le clouërec Pierrick <br>
      </div>
    </div>
  </div>
</footer>
     <script>
      $(document).ready(function(){ 
         $(\".bt-menu-trigger\").toggle( 
          function(){
            $('.bt-menu').addClass('bt-menu-open'); 
          }, 
          function(){
            $('.bt-menu').removeClass('bt-menu-open'); 
          } 
        ); 
      }) 
    </script>
</body>
</php>";

	echo $footer;
}
}
