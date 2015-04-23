function ajouterProduitAuPanier(id_produit,prix)
{
    $.ajax({
        url: 'AJAXController.php', //url du script PHP qu'on appelle
        type: 'GET', // Le type de la requête HTTP, ici  GET
        data: 'a=addProduitToPanier&id='+id_produit+'&q='+quantite+'&prix='+prix, // c = controlleur PHP a executer, a = methode de ce controlleur a executer, q = recherche
        dataType: 'JSON', //on demande du JSON en retour
        success: function (data) {
            
        }
    });
}