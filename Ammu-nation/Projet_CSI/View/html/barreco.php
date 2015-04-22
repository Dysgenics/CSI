<?php 
session_start();
// Barre de connexion

// Si l'utilisateur est connecté
if (isset($_SESSION['email'])) {
	echo "test2";
    // On affiche un message, son nom d'utilisateur et un bouton pour se déconnecter
    echo "<div class=\"connexion\">\n";
    echo "Vous êtes connectés en tant que " . $_SESSION['email'];
    echo "<form action=\"connection.php\" method=\"GET\">\n";
    echo "<input class=\"bouton\" type=\"submit\" value=\"Se déconnecter\"/>\n";
    echo "</form>\n";
    echo "</div>\n";
    
} else {
	echo "test";
    // Sinon, on affiche des champs et un bouton pour qu'il puisse se connecter
    echo "<div class=\"connexion\">\n";
    echo "<div class=\"input\">\n";
    echo "<form action=\"connection.php\" method=\"POST\">\n";
    echo "<input class=\"champ\" type=\"text\" name=\"email\" value=\"email\" size=\"20\"/>\n";
    echo "<input class=\"champ\" type=\"password\" name=\"mdp\" value=\"mdp\"/>\n";
    echo "<input class=\"bouton\" type=\"submit\" value=\"Se connecter\"/>\n";
    echo "</form>\n";
    echo "</div>\n";
    echo "</div>\n";
    
}

    