$(document).ready(function () {
    $('#btn_submit').click(function (event) {
        event.preventDefault();

        nom = $('#nom').val();
        mail = $('#mail').val();
        mdp1 = $('#mdp1').val();
        mdp2 = $('#mdp2').val();
        token = $('#token').val();

        valeurs = { 'nom': nom, 'mail': mail, 'mdp1': mdp1, 'mdp2': mdp2,'token':token };

        $.ajax({
            url: '../inscrire.php',
            type: 'POST',
            data: valeurs,
            success: function (response) {
                if (response == '1') {
                    $('#message_form').text("Création de compte réussie.").css('color','');
                    window.location.href = "../accueil.php";
                }else if (response == 'Erreur de token.'){
                    $('#message_form').text(response).css('color','red');
                    setTimeout(function(){
                        window.location.href ="../accueil.php";
                    }, 2000);
                }
                else {
                    $('#message_form').text(response).css('color','red');
                }
            },
            error: function () {
                $('#message_form').text("Erreur lors de la création du compte. Veuillez réessayer.").css('color','red');
            }
        })
    })
})