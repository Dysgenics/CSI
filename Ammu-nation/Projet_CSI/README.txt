Fonctions existentes et fonctionnelle:

_ Choix du magasin et stockage de l'id en session 
_ Afficher les cat�gories
_ Afficher le d�tail d'un produit 
_ Afficher l'int�gralit� des produits d'un magasin 
_ Afficher les produits d'une cat�gorie d'un magasin
_ Ajouter un produit � une commande

_ R�cup�rer une commande existante

Fonctions existentes non fonctionnelle:

_ Create commande : L'insertion ne se fait pas dans la base
_ Connection.php : La comparaison du mot de passe ne fonctionne pas. Probl�me soit dans connection.php (if $pw == $client->mdp) soit dans CLIENT.php (R�cup�ration des infos depuis la base avec findByEmail)

Fonctions � r�aliser:

_ Cr�er un bouton d'ajout au panier + bouton visu panier
_ Afficher le nom du magasin et le nom de la cat�gorie

_ Afficher le contenu d'une commande (Termin� en partie)
	-> Cr�er le lien qui redirige vers l'affichage du panier
	-> Afficher le nom du produit
	-> ControllerContient::AfficherPanier($id_com)

_ Partie remise

_ Partie retrait / quai / horaire

_ Cr�ation du bilan (voir programmation �v�nementielle mysql)
http://atranchant.developpez.com/mysql/evenement/

Autres:
_ Rapport + Diapos

