$(document).ready(function(){
    $("#deconnecter").click(function(){
        $.ajax({
            url: "/GameSwipe/compte/deconnecter.php",
            method: "POST",
            success: function(response){
                if(response == "1"){
                    window.location.href = "/GameSwipe/accueil.php";
                } else {
                    alert("Erreur lors de la déconnexion : " + response);
                }
            },
            error: function(){
                alert("Erreur lors de la déconnexion.");
            }
        });
    });
});
