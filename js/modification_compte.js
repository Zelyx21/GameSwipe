$(document).ready(function(){

    var emailDejaValide = false;

    document.querySelectorAll('.bouton-input-modif').forEach(div => {
        const input = div.querySelector('input');
        const btn = div.querySelector('button');

        btn.addEventListener('click', (e) => {
            e.preventDefault();

            if(input.hasAttribute('readonly')) {
                input.removeAttribute('readonly');
                input.focus();
                btn.textContent = 'Enregistrer';
            } else {
                input.setAttribute('readonly', true);
                btn.textContent = 'Modifier';

                const value = input.value.trim();

                if(value === "") {
                    alert("Le champ ne peut pas être vide !");
                    input.removeAttribute('readonly');
                    btn.textContent = 'Enregistrer';
                    return;
                }

                    // Validation email
                    if(input.id === "email") {
                        const regexEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

                        if(!regexEmail.test(value)) {
                            alert("L'adresse email n'est pas valide !");
                            input.removeAttribute('readonly');
                            btn.textContent = 'Enregistrer';
                            return;

                        }
                        // Envoi AJAX pour vérifier l'email
                        $.ajax({
                            url: "mail_existant_verification.php",
                            type: "POST",
                            data: $("#formulaire").serialize(),
                            success: function(response) {

                                // Email déjà utilisé
                                if(response !== "1") {
                                    alert("Compte déjà associé à cette adresse mail !");
                                    input.removeAttribute('readonly');
                                    btn.textContent = 'Enregistrer';
                                } else {
                                    // Email valide donc envoi de modification
                                    $.ajax({
                                        url: "modification_compte.php",
                                        type: "POST",
                                        data: $("#formulaire").serialize(),
                                        success: function(response) {
                                            if(response === "1") {
                                                alert("Modification enregistrée !");
                                            } else {
                                                alert("La modification n'a pas été enregistrée ! Erreur :" + response);
                                            }
                                        }
                                    });
                                }
                            }
                        });
                        emailDejaValide = true;

                    }

                // Validation mot de passe
                if(input.id === "password") {
                    const valeur = input.value;

                    const contientLettre = /[A-Za-z]/.test(valeur);
                    const contientChiffre = /[0-9]/.test(valeur);
                    const contientSpecial = /[!@#$%^&*(),.?":{}|<>]/.test(valeur);

                    if(!contientLettre || !contientChiffre || !contientSpecial) {
                        alert("Le mot de passe doit contenir au moins une lettre, un chiffre et un caractère spécial !");
                        input.removeAttribute('readonly');
                        btn.textContent = 'Enregistrer';
                        return;
                    }
                }


                // Envoi AJAX
                if(!emailDejaValide){
                    $.ajax({
                        url: "modification_compte.php",
                        type: "POST",
                        data: $("#formulaire").serialize(),
                        success: function(response) {
                            if(response === "1"){
                                alert("Modification enregistrée !");
                            } else {
                                alert("Erreur : " + response);
                            }
                        }
                    });
                }
                }
            });
    });


	});
