$(document).ready(function () {
    $('#nom').on('input', function () {
        if (!/^[A-Za-z]+$/.test($('#nom').val())) {
            $('#message_nom').text("Le nom doit être valide.");
            $nom_valide = false;
        } else {
            $('#message_nom').text("");
            $nom_valide = true;
        }
    })

    $('#mail').on('input', function () {
        if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test($('#mail').val())) {
            $('#message_mail').text("Le mail doit être valide.");
            $mail_valide = false;
        } else {
            $('#message_mail').text("");
            $mail_valide = true;
        }
    })

    $('#mdp1').on('input', function () {
        valeur = $(this).val();
        testLettre = /[A-Za-z]/.test(valeur);
        testChiffre = /[0-9]/.test(valeur);
        testSpecial = /[!@#$%^&*(),.?":{}|<>]/.test(valeur);

        if (!testLettre || !testChiffre || !testSpecial) {
            $('#message_mdp1').text("Le mot de passe doit contenir des lettres, au minimum un chiffre et un caractère spécial.");
            $mdp1_valide = false;
        } else {
            $('#message_mdp1').text("");
            $mdp1_valide = true;
        }
    })

    $('#mdp2').on('input', function () {
        if ($('#mdp2').val() != $('#mdp1').val()) {
            $('#message_mdp2').text("Les mots de passe doivent être identiques.");
            $mdp2_valide = false;
        } else {
            $('#message_mdp2').text("");
            $mdp2_valide = true;
        }
    })

    $('#btn_submit').click(function (event) {
        event.preventDefault();
        if ($nom_valide && $mail_valide && $mdp1_valide && $mdp2_valide) {
            nom = $('#nom').val();
            mail = $('#mail').val();
            mdp1 = $('#mdp1').val();
            mdp2 = $('#mdp2').val();
            token = $('#token').val();

            valeurs = { 'nom': nom, 'mail': mail, 'mdp1': mdp1, 'mdp2': mdp2, 'token': token };

            $.ajax({
                url: 'inscrire.php',
                type: 'POST',
                data: valeurs,
                success: function (response) {
                    if (response == '1') {
                        $('#message_form').text("Création de compte réussie.").css('color', '');
                        setTimeout(function(){
                            window.location.href = "/GameSwipe/accueil.php";
                        },1000);
                    } else if (response == 'Erreur de token.') {
                        $('#message_form').text(response).css('color', 'red');
                        setTimeout(function () {
                            window.location.href = '/GameSwipe/accueil.php';
                        }, 1000);
                    }
                    else {
                        $('#message_form').text(response).css('color', 'red');
                    }
                },
                error: function () {
                    $('#message_form').text("Erreur lors de la création du compte. Veuillez réessayer.").css('color', 'red');
                }
            });
        }else{
            $('#message_form').text("Veuillez remplir correctement tout le formulaire.").css('color', 'red');
        }
    });
});