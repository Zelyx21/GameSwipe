$(document).ready(function () {
    $('#btn_submit').click(function (event) {
        event.preventDefault();
        mail_nom = $('#mail_nom').val();
        mdp = $('#mdp').val();
        token = $('#token').val();

        valeurs = { 'mail_nom': mail_nom, 'mdp': mdp, 'token': token };

        $.ajax({
            url: 'connecter.php',
            type: 'POST',
            data: valeurs,
            success: function (response) {
                if (response == "1") {
                    $("#message_form").text("Connexion réussie !").css("color", "green");
                    setTimeout(function () {
                        window.location.href = "../accueil.php";
                    }, 1000);
                }
                else if (response == "0") {
                    $("#message_form").text("Mail, nom ou mot de passe incorrect.").css("color", "red");
                }
                else {
                    $("#message_form").text(response).css("color", "red");
                    setTimeout(function () {
                        window.location.href = "../accueil.php";
                    }, 1000);
                }
            },
            error: function () {
                $("#message_form").text("Erreur lors de la connexion.").css("color", "red");
            }
        });
    })
});