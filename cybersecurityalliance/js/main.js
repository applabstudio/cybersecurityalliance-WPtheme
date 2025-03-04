(function($) {

    $(document).ready(function(){
        var base_url = "https://www.cybersecurityalliance.it";


        // do something....

        // stilo form acf con bootstrap
        $(".acf-input input[type=text], .acf-input textarea").addClass("form-control");
        $(".acf-button").addClass("btn btn-primary");
        $(".acf-field--post-title label").html('Titolo <span class="acf-required">*</span>');
        // nascondo il campo per la scelta della territoriale
        $(".acf-field-5b8e8c4d93a8b").css("display","none");


        $('[data-toggle="tooltip"]').tooltip({container: 'body'});

        // invio form richiesta collaboratore
        $("#invita-collaboratore-form").submit(function(e){
            e.preventDefault();
            // prelevo i campi
            data = {
                nome : $("#nome").val(),
                cognome : $("#cognome").val(),
                email : $("#email").val(),
                telefono : $("#telefono").val(),
                cf : $("#cf").val(),
				'g-recaptcha-response' : $(this).find("[name='g-recaptcha-response']").val(),
				"_wpnonce" : $(this).find("[name='_wpnonce']").val(),
            };
            // controllo sui campi
            if(data.nome == '' || data.cognome == '' || data.email == '' || data.telefono == '' || data.cf == ''){
                alert("I campi contrassegnati dall'asterisco sono obbligatori!");
            } else {
                // chiamata ajax al serever per verifiare il form
                $.ajax({
                    type: "POST",
                    url: "/wp-content/themes/cybersecurityalliance/ajax/invita_collaboratori.php",
                    data: data,
                    dataType: "html",
                    success: function(res){
						console.log("risposta",res)
                        if(res == 'ok'){
                            // pulisco i dati del form
                            $("#nome").val('');
                            $("#cognome").val('');
                            $("#email").val('');
                            $("#telefono").val('');
                            $("#cf").val('');
                            // messaggio di successo
                            alert("Invito inviato correttamente! Il tuo collega sarà contattato dalla territoriale per concludere la procedura di creazione account.");
                        } else {
                            alert(res);
                        }
                    },
                    error: function(x,e){
                        alert("Ajax error!");
                    }
                })
            }

        }); // end invio form Collaboratore

        // gestisco l'invio dei commenti
        $("#invita-commento-form").submit(function(e){
            e.preventDefault();
            // prelevo i dati dal form
            data = {
                "commento" : $("#commento").val(),
                "anonimo" : $('input[name=anonimo]:checked').val(),
                "id_articolo" : $("#articolo").val(),
                "g-recaptcha-response" : $(this).find("[name='g-recaptcha-response']").val(),
                "_wpnonce" : $(this).find("[name='_wpnonce']").val(),
            };
            console.log(data);
            // controlli sul form
            if(data.commento == '' || !data.anonimo){
                alert("Inserisci il tuo commento e decidi se renderlo anonimo.");
            } else {
                $.ajax({
                    type: "POST",
                    url: "/wp-content/themes/cybersecurityalliance/ajax/invia_commento.php",
                    data: data,
                    dataType: "html",
                    success: function(res){
                        if(res == 'ok'){
                            // pulisco i dati del form
                            $("#commento").val('');
                            // messaggio di successo
                            alert("Commento inviato correttamente!");
                            // ricarico la pagina
                            location.reload();
                        } else {
                            alert(res);
                        }
                    },
                    error: function(x,e){
                        alert("Ajax error!");
                    }
                }); // end ajax call
            }
        });

        // invio form cambio password
        $("#reset-password-form").submit(function(e){
            e.preventDefault();
            // prelevo i campi
            data = {
                password : $("#password").val(),
                repeat_password : $("#repeat-password").val(),
				"g-recaptcha-response" : $(this).find("[name='g-recaptcha-response']").val(),
				"_wpnonce" : $(this).find("[name='_wpnonce']").val()
            }
            if(!checkPassword(data.password)){
                alert("La password deve essere composta da 8 caratteri comprendenti almeno una lettera maiuscola, una lettera minuscola e un numero.");
            } else {
                if(data.password != data.repeat_password){
                    alert("Le password devono coincidere!");
                } else {
                    // tutto ok ...passo al server i dati
                    $.ajax({
                        type: "POST",
                        url: "/wp-content/themes/cybersecurityalliance/ajax/reset-password.php",
                        data: data,
                        dataType: "html",
                        success: function(res){
                            if(res == 'ok'){
                                // pulisco i dati del form
                                $("#password").val('');
                                $("#repeat-password").val('');
                                // messaggio di successo
                                alert("Password aggiornata!");
                                // ricarico la pagina
                                location.reload();
                            } else {
                                alert(res);
                            }
                        },
                        error: function(x,e){
                            alert("Ajax error!");
                        }
                    }); // end ajax call
                }
            }
        });

    }); // end document ready

})(jQuery);

function checkPassword(str){
   // at least one number, one lowercase and one uppercase letter
   // at least six characters
   var re = /(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}/;
   return re.test(str);
 }
