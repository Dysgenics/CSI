Fonctions existentes et fonctionnelle:

_ Choix du magasin et stockage de l'id en session 
_ Afficher les catégories
_ Afficher le détail d'un produit 
_ Afficher l'intégralité des produits d'un magasin 
_ Afficher les produits d'une catégorie d'un magasin
_ Ajouter un produit à une commande

_ Récupérer une commande existante
- comparer les mots de passe (fonction de hash en sha512)
-creation de commande a la connexion
- bouton d'ajout au panier avec quantité
_ Afficher le nom du magasin et le nom de la catégorie

<<<<<<< HEAD
_ Création du bilan (voir programmation événementielle mysql)
http://atranchant.developpez.com/mysql/evenement/

Fonctions existentes non fonctionnelle:

_ Create commande : L'insertion ne se fait pas dans la base
_ Connection.php : La comparaison du mot de passe ne fonctionne pas. Problème soit dans connection.php (if $pw == $client->mdp) soit dans CLIENT.php (Récupération des infos depuis la base avec findByEmail)
=======
_ bouton visu panier
>>>>>>> origin/master


_ Afficher le contenu d'une commande (Terminé en partie)
	-> Créer le lien qui redirige vers l'affichage du panier
	-> Afficher le nom du produit
	-> ControllerContient::AfficherPanier($id_com)

Fonctions à réaliser:



_ Partie remise

_ Partie retrait / quai / horaire

Autres:
_ Rapport + Diapos

