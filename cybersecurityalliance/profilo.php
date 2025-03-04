<?php
/*
    Template name: Profilo
*/

get_header();
?>
<div class="section" id="top_banner"
    style="height: 380px;position: relative;display:flex;flex-direction: column;align-items: center;justify-content: center;background-image: url('<?=get_template_directory_uri()?>/assets/images/code-bg-top.png')">
   <div class="container">
   <a href="<?=site_url()?>" class="text-decoration-none">
        <h2 class="text-center text-white" style="font-size:50px;">Profilo personale</h2>
        <p class="text-center"
            style="text-decoration: none;color: #FFFFFF;font-size: 18px;font-weight: bold;position: relative">
            Vedi le tue informazioni personali
        </p>
    </a>
   </div>
</div>
<div class="section">
    <div class="container">

        <?php
        $current_user = wp_get_current_user();
        ?>
        <div class="row">
            <div class="col-md-3">
                <div class="panel panel-default" style="padding:15px;background:#f8f8f8">
                <div class="name d-flex align-items-center p-0 m-0 mb-3">
                        <img src="<?php echo get_template_directory_uri() ?>/assets/images/dateicon.png" alt=""
                            class="me-2">
                        <h4 class="m-0">Dati personali</h4>
                    </div>
                    <div class="data" style="font-family: 'Lato';
                            font-style: normal;
                            font-weight: 700;
                            color:#6C6C6C;
                            font-size: 15px;
                            line-height: 29px;">
                        <p> Nome : <span style="font-weight: normal"> <?=$current_user->first_name?> </span></p>
                        <p> Cognome : <span style="font-weight: normal"> <?=$current_user->last_name?> </span></p>
                        <p> Email : <span style="font-weight: normal"> <?=$current_user->user_email?> </span></p>
                        <p> Telefono : <span style="font-weight: normal">  <?=get_user_meta($current_user->ID,'telefono',true)?> </span></p>
                    </div>
                </div>
            </div>
            <div class="col-md-7">
                <h4 style="margin-top:0" class="mb-4">
                    Cambia password
                </h4>
                <form id="reset-password-form">
                    <label>Inserisci nuova password</Label>
                    <input type="password" id="password" class="form-control" placeholder="Scrivi il titolo della segnalazione"/>
                    <br>
                    <label>Ripeti nuova password</Label>
                    <input type="password" id="repeat-password" class="form-control" placeholder="Indica la tipologia della segnalazione"/>
                    <br><br>
                    <div class="g-recaptcha" data-sitekey="6LcE-XMUAAAAAEpa_Epg6QphAPNz6QYpQ2M0UMBE"></div>
                    <?php wp_nonce_field( 'password' ); ?>
                    <input type="submit" value="Aggiorna password" class="btn btn-primary" style="background-color: #437AD2 !important;">
                </form>
            </div>
        </div>

    </div>
</div>

<?php
get_footer();