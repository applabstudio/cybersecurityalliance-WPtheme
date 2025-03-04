<?php
/* Template name: Login */

// se ho inviato il form...
if(isset($_POST['login'])){
	// aumento di 1 ad ogni tentativo
	/*
	if(isset($_SESSION['login_number'])){
		if($_SESSION['login_number'] > 3 ){
			// blocco il login e setto expire
			if(!isset($_SESSION['login_retry'])){
				$_SESSION['login_retry'] = time() + 60;
			}
			if( time() > $_SESSION['login_retry'] ){
				// puoi riprovare
				$_SESSION['login_number'] = 1;
				unset($_SESSION['login_retry']);
			} else {
				exit('Riprova tra 1 minuto...');
			}
		} else {
			$_SESSION['login_number'] = $_SESSION['login_number'] + 1;
		}
	} else {
		$_SESSION['login_number'] = 1;
	}
	*/

	// errori form
	$errors = array();

	// prelevo i valori del form

	$userid = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
	$password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);

	if($userid == '' || $password == ''){
		array_push($errors,'Campi obbligatori');
	} else {
		
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
		//$resp = json_decode(curl_exec($curl));
		$resp = curl_exec($curl);
		//echo curl_error($curl);
		//exit();
		$resp = json_decode($resp);
		// Close request to clear up some resources
		curl_close($curl);
		
		if($resp->success){
			// tutto sbagliato
			// controllo se è un utente locale di wordpress
			$creds = array(
				'user_login'    => $userid,
				'user_password' => $password,
				'remember'      => true
			);
			
			$user = wp_signon( $creds, true );
			
			if ( is_wp_error( $user ) ) {
				array_push($errors,'Username e Password errati. Riprova!');
			} else {
				header("location:" . site_url());
				die();
			}
		}
		else
			array_push($errors,'reCAPTCHA sbagliato. Riprova!');
		
	}
} // end press login button

get_header('login');

?>

<!-- maschera di sfondo con gradiente blu viola-->
<!-- <div class="bg-blue" style="z-index:-1;width:100%;height:100%;position:fixed;top:0;left:0"></div> -->

<!-- Mostro le aree tematiche -->
<style>
.form-signin {
    max-width: 550px;
    padding: 15px;
    margin: 0px auto;
}

.form-signin .form-floating:focus-within {
    z-index: 2;
}

.form-signin input[type="email"] {
    margin-bottom: -1px;
    border-bottom-right-radius: 0;
    border-bottom-left-radius: 0;
}

.form-signin input[type="password"] {
    margin-bottom: 10px;
    border-top-left-radius: 0;
    border-top-right-radius: 0;
}

.bg-blured {
    background: rgba(0, 56, 123, 0.3);
    border: 1px solid #144580;
    box-shadow: 0px 12px 24px 30px rgba(0, 0, 0, 0.05);
    backdrop-filter: blur(10px);
	width: 900px;
}

.main-loginlogo {
    font-family: 'Lato', sans-serif;
    font-style: normal;
    font-size: 40px;
    line-height: 47px;
    color: #F9F9F9;
}

.sub-title {
    font-style: normal;
    font-weight: 700;
    font-size: 24px;
    line-height: 31px;
    color: #F9F9F9;
}

.form-signin form label {
    color: #F9F9F9;
}
.form-signin form input{
	font-size: 16px;
}
.form-signin form button {
    background-color: #00387B !important;
}

.form-signin form small a{
    font-family: 'Lato', sans-serif;
    font-style: normal;
    font-weight: 400;
    font-size: 14px;
    line-height: 56px;
    color: #F9F9F9;
}
</style>
<div class="container-fluid login-form-main-div" style="background-image: url('<?=get_template_directory_uri()?>/assets/images/code-bg-top.png');    background-repeat: no-repeat;
    background-size: cover;
    background-position: center center; padding:150px;">
    <div class="content container bg-blured">
        <div class="inner-content">
            <div class="px-4 py-5 my-5 text-center">
                <img class="d-block mx-auto mb-4"
                    src="<?=site_url()?>/wp-content/uploads/2018/08/logo-cybersecurity-alliance.png" alt="">
                <h1 class="display-5 fw-bold main-loginlogo">Cybersecurity Alliance</h1>
                <h4 class="sub-title">Accedi all’account</h4>
            </div>
            <div class="form-signin">
                <form method="post" id="" action="#">

                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Email address</label>
                        <input type="text" class="form-control auth-login-input"id="username" name="username"  placeholder="mario_rossi">
                    </div>
					<div style="color:red;">
						<?php
						if(isset($errors) && !empty($errors)){
							for($i=0;$i<count($errors);$i++){
								echo "<p>".$errors[$i]."</p>";
							}
						}
						?>
					</div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Password</label>
                        <input type="password" class="form-control auth-login-input"  placeholder="********" name="password" id="password">
                    </div>
                    <input type="hidden" value="<?=get_template_directory_uri()?>" id="template_url">
                    <div class="g-recaptcha" data-sitekey="6LcE-XMUAAAAAEpa_Epg6QphAPNz6QYpQ2M0UMBE"></div>
                    <input class="w-100 btn btn-lg btn-primary" type="submit" value="Sign in" name="login">
                    <small> <a href="<?=site_url()?>/wp-login.php?action=lostpassword">Hai dimenticato la password? </a> </small>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
<!-- <div class="container page">

	<div class="row" style="margin-top:70px">

			<div class="col-xs-12 col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4" style="padding:20px">

				<div style="height:70px;display:table;margin-bottom:30px;">
					<div style="display:table-cell;vertical-align:middle">
						<img src="<?=site_url()?>/wp-content/uploads/2018/08/logo-cybersecurity-alliance.png" style="height:70px;">
					</div>
					<div style="display:table-cell;vertical-align:middle;padding-left:15px;" class="c-white">
						<h4 style="color:white">
							CYBERSECURITY<br>
							ALLIANCE
						</h4>
					</div>
				</div>
				<form method="post" id="" action="#">
					<div style="color:red;">
						<?php
						if(isset($errors) && !empty($errors)){
							for($i=0;$i<count($errors);$i++){
								echo "<p>".$errors[$i]."</p>";
							}
						}
						?>
					</div>
					<div class="input-group" style="margin-bottom:10px;">
						<div class="input-group-addon auth-addon"><i class="zmdi zmdi-account"></i></div>
						<input type="text" class="form-control auth-login-input" id="username" name="username" placeholder="Email o Username">
					</div>
					<div class="input-group">
						<div class="input-group-addon auth-addon"><i class="zmdi zmdi-key"></i></div>
						<input type="password" name="password" class="form-control auth-login-input" id="password" placeholder="Password">
					</div>
					<br>
					<input type="hidden" value="<?=get_template_directory_uri()?>" id="template_url">
					<div class="g-recaptcha" data-sitekey="6LcE-XMUAAAAAEpa_Epg6QphAPNz6QYpQ2M0UMBE"></div>
					<input type="submit" name="login" class="btn btn-success btn-block" value="Accedi">
				</form>
				<p class="text-center" style="margin-top:25px;font-size:13px;">
					<a href="<?=site_url()?>/wp-login.php?action=lostpassword" style="color:white !important;">
						Hai dimenticato la password?
					</a>
				</p>
			</div>


	</div> 
</div>  -->

<!-- fine aree tematiche -->



<?php
get_footer();