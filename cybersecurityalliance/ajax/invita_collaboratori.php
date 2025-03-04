<?php
// richiamo il core di wordpress per utilizzare le funzioni
require "../../../../wp-load.php";

if (!wp_verify_nonce( $_POST["_wpnonce"], 'invita')){
	echo "Qualcosa è andato storto, prova più tardi.";
	exit;
}

// Get cURL resource
$curl = curl_init();
// Set some options - we are passing in a useragent too here
curl_setopt_array($curl, array(
	CURLOPT_RETURNTRANSFER => 1,
	CURLOPT_URL => 'https://www.google.com/recaptcha/api/siteverify',
	CURLOPT_POST => 1,
	CURLOPT_POSTFIELDS => array(
		'secret' => '6LcE-XMUAAAAAE-miikreSteKdcrfxnTDitecblh',
		'response' => $_POST['g-recaptcha-response']
	)
));
// Send the request & save response to $resp
$resp = json_decode(curl_exec($curl));
// Close request to clear up some resources
curl_close($curl);

if(!$resp->success){
	echo "reCAPTCHA sbagliato. Riprova!";
	exit;
}


// mi salvo il timestamp dell'ultimo invio di commento
if(isset($_SESSION['invita_collaboratore'])){
    // deve essere passato un minuto ...
    if(time() - $_SESSION['invita_collaboratore'] < 60){
        echo "Attendi un minuto prima di inviare nuovamente il form!";
        die();
    }
} else {
    $_SESSION['invita_collaboratore'] = time();
}

// prelevo i dati del form e li sanitizzo
$nome = filter_var($_POST['nome'], FILTER_SANITIZE_STRING);
$cognome = filter_var($_POST['cognome'], FILTER_SANITIZE_STRING);
$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
$telefono = filter_var($_POST['telefono'], FILTER_SANITIZE_STRING);
$cf = filter_var($_POST['cf'], FILTER_SANITIZE_STRING);

// controllo che sono stati tutti compilati
if($nome!=='' && $cognome!=='' && $email!=='' && $telefono!=='' && $cf!==''){
    // prelevo le informazioni dell'utente che ha fatto la richiesta
    $current_user = wp_get_current_user();
    // prelevo l'azienda
    $azienda = get_user_company();

    if($azienda != FALSE){
        // titolo
        $title = "Richiesta da " . $current_user->user_firstname . " " . $current_user->user_lastname . " di " . $azienda;
        // contenuto
        $content = "Collega:\n\n
            azienda: ".$azienda."
            nome: ".$nome."
            cognome: ".$cognome."
            email: ".$email."
            telefono: ".$telefono."
            codice fiscale: ".$cf;

        // salva la richiesta
        $richiesta = array(
          'post_type' => 'richieste_utenti',
          'post_title'   => $title,
          'post_content' => $content,
          'post_author' => $current_user->ID,
          'post_status' => 'private'
        );
        // Update the post into the database
        $insert = wp_insert_post( $richiesta );
        if($insert){
            update_field('territoriale', $_SESSION['territoriale'][0], $insert);
            echo "ok";
        } else {
            echo "Errore durante l'invio. Riprova!";
        }
        // invio notifica
    } else {
        echo "Non puoi inviare il form perchè non sei il referente di nessuna azienda";
    }
}
