<?php
// richiamo il core di wordpress per utilizzare le funzioni
require "../../../../wp-load.php";


if (!wp_verify_nonce( $_POST["_wpnonce"], 'commento')){
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
if(isset($_SESSION['invio_commento'])){
    // deve essere passato un minuto ...
    if(time() - $_SESSION['invio_commento'] < 60){
        echo "Attendi un minuto prima di inviare un nuovo commento!";
        die();
    }
} else {
    $_SESSION['invio_commento'] = time();
}



// prelevo i dati del form e li sanitizzo
$commento = filter_var($_POST['commento'], FILTER_SANITIZE_STRING);
$anonimo = filter_var($_POST['anonimo'], FILTER_SANITIZE_STRING);
$articolo = filter_var($_POST['id_articolo'], FILTER_SANITIZE_STRING);

// controllo che sono stati tutti compilati
if($commento!=='' && ($anonimo=='Si' || $anonimo=='No') && $articolo!=='' ){
    // prelevo le informazioni dell'utente che ha fatto la richiesta
    $current_user = wp_get_current_user();
    $territoriale_utente = get_user_meta($current_user->ID,'territoriali',false)[0];
    // prelevo l'azienda
    $azienda = get_user_company();
    if($azienda != FALSE){
        // titolo
        $title = "Commento all'articolo: " . get_post($articolo)->post_title;
        // contenuto
        $content = $commento;
        // stato commento
        $status = 'private';
        if(get_comment_status_to_send($articolo) == 'publish'){
            $status = 'publish';
        }
        // salva la richiesta
        $commento = array(
          'post_type' => 'commenti_articoli',
          'post_title'   => $title,
          'post_content' => $content,
          'post_author' => $current_user->ID,
          'post_status' => $status,
        );
        // Update the post into the database
        $insert = wp_insert_post( $commento );
        if($insert){
            // acf update custom field
            update_field('id_articolo_collegato', $articolo, $insert);
            update_field('anonimo', array($anonimo), $insert);
            update_field('territoriale', $territoriale_utente, $insert);
            // aggiorno il timestamp per l'invio del commento...
            $_SESSION['invio_commento'] = time();
            echo "ok";
        } else {
            echo "Errore durante l'invio. Riprova!";
        }
        // invio notifica
    } else {
        echo "Non puoi inviare il form perchè non sei il referente di nessuna azienda";
    }
}
