$(document).ready(function() {
    $('#supprimer-compte').on('click', function(e) {
        e.preventDefault();

        // Demande de confirmation
        if (!confirm("Êtes-vous sûr de vouloir supprimer votre compte ? Cette action est irréversible !")) {
            return; // abandon si le client annule
        }

        // Envoi AJAX
        $.ajax({
            url: "supprimer_compte.php",
            type: "POST",
            data: {
                token: $('#token').val()
            },
            success: function(response) {
                if(response === "1") {
                    alert("Votre compte a été supprimé !");
                    window.location.href = "connexion.php";
                } else {
                    alert("Erreur lors de la suppression : " + response);
                }
            }
        });
    });
});
