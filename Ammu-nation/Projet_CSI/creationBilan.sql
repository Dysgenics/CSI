/* La requête suivante donne à l'utilisateur UTILISATEUR les droits de créer un évènement */
GRANT EVENT ON BILAN.* TO root;

/* La requête active le service */
SET GLOBAL event_scheduler = 1 ;

/* Création du bilan chaque jour à 'Choisir heure'
 * Pour le cas réel, remplacer EVERY 1 DAY par EVERY 1 MONTH
 * Modifier le script de création de base pour auto-incrémenter l'id_bilan de bilan
 * Réalise un bilan sur l'intervalle d'un mois
 * Il faut un Event par magasin (Voir si c'est possible d'améliorer)
 * Ne prend en compte que les commandes validées (valide = 1)
 */
CREATE EVENT ins_bilan 
ON SCHEDULE EVERY 1 DAY STARTS '2015-04-25 21:02:00'
DO INSERT INTO BILAN
SELECT 0, 1, NOW() - INTERVAL 1 MONTH, NOW(), SUM(QUANTITE), SUM(TOTAL)
FROM COMMANDE, CONTIENT
WHERE COMMANDE.ID_COMMANDE = CONTIENT.ID_COMMANDE
AND COMMANDE.VALIDE=1
AND COMMANDE.ID_MAGASIN = 1;
