<?php
// richiamo il core di wordpress per utilizzare le funzioni
require "../../../../wp-load.php";


if (!wp_verify_nonce( $_POST["_wpnonce"], 'password')){
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
if(isset($_SESSION['reset_password'])){
    // deve essere passato un minuto ...
    if(time() - $_SESSION['reset_password'] < 60){
        echo "Attendi un minuto prima di resettare nuovamente la password.";
        die();
    }
} else {
    $_SESSION['reset_password'] = time();
}

// prelevo i dati del form e li sanitizzo
$password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
$repeat_password = filter_var($_POST['repeat_password'], FILTER_SANITIZE_STRING);

if(!checkPassword($password)){
    echo "La password deve essere composta da 8 caratteri comprendenti almeno una lettera maiuscola, una lettera minuscola e un numero.";
    die();
} else {
    // controllo che siano uguali
    if($password != $repeat_password){
        echo "Le password devono coincidere";
        die();
    } else {
        // tutto ok posso aggiornare
        wp_set_password($password, wp_get_current_user()->ID);
        echo "ok";
        die();
    }
}


function checkPassword($str){
   // at least one number, one lowercase and one uppercase letter
   // at least six characters
   $re = '/(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{10,}/';
   if(preg_match($re,$str) == 1){
       return TRUE;
   } else {
       return FALSE;
   }
 }
