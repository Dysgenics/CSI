function ajouterProduitAuPanier(id_produit,prix)
{
    
    var quantite = $("#inputQuantite").val();
    
    
    $.ajax({
        url: '../../Controller/AJAXController.php', //url du script PHP qu'on appelle
        type: 'GET', // Le type de la requête HTTP, ici  GET
        data: 'a=addProduitToPanier&id='+id_produit+'&q='+quantite+'&prix='+prix, // c = controlleur PHP a executer, a = methode de ce controlleur a executer, q = recherche
        dataType: 'JSON', //on demande du JSON en retour
        success: function (data) {
            console.log(data);
            if(data == false){
                $("#addToPanierBtn").notify("Erreur d'ajout", {
                            elementPosition: 'right', className: "error", hideDuration: 4000});
            }
            else
            {
                $("#addToPanierBtn").notify("Produit ajouté au panier", {
                            elementPosition: 'right', className: "success", hideDuration: 4000});
            }
        }
    });
}