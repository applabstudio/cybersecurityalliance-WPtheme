<?php
/*
    Template name: Segnalazione utente
*/

acf_form_head();
get_header();

// assegno la territoriale a tutte le segnalazioni fatte dall'utente loggato

// prelevo la territoriale dell'utente
$current_user = wp_get_current_user();
$territoriale_utente = get_user_meta($current_user->ID,'territoriali',false)[0];

$args = array(
    "post_type" => "segnalazioni_aziende",
    "posts_per_page" => -1,
    "author" => $current_user->ID
);
$segnalazioni = get_posts($args);
foreach($segnalazioni as $s){
    update_field('territoriale', $territoriale_utente[0], $s->ID);
}


?>
    <style>
        .acf-button{
            background-color: #437AD2!important;
            width: 195px!important;
        }
    </style>
<div class="section" id="top_banner"
    style="height: 380px;position: relative;display:flex;flex-direction: column;align-items: center;justify-content: center;background-image: url('<?=get_template_directory_uri()?>/assets/images/code-bg-top.png')">
    <div class="container">
        <a href="<?=site_url()?>">
            <div style="display: flex;align-items: center;position: relative" class="justify-content-center">
                <!--                <img src="-->
                <?//=site_url()?>
                <!--/wp-content/uploads/2018/08/logo-cybersecurity-alliance.png" style="height:80px">-->
                <span style="color:white;font-size:57px;font-weight: 700;margin-left:15px">Fai una segnalazione</span>
            </div>
            <p
                style="text-decoration: none;color: #FFFFFF;font-size: 18px;font-weight: bold;position: relative; text-align:center;">
                Hai subito un attacco informatico? Segnalacelo compilando il form

            </p>
        </a>
    </div>
</div>
<div class="section">
    <div class="container">
        <br>
        <div class="row">
            <div class="col-md-3">
                <div class="panel panel-default" style="padding:30px;background:#f8f8f8">
                    <div class="name d-flex align-items-center p-0 m-0 mb-3">
                        <img src="<?php echo get_template_directory_uri() ?>/assets/images/dateicon.png" alt=""
                            class="me-2">
                        <h4 class="m-0">Dati personali</h4>
                    </div>
                    <div class="meta" style="font-family: 'Lato';
                            font-style: normal;
                            color:  #6C6C6C;
                            font-weight: 700;
                            font-size: 15px;
                            line-height: 29px;">
                        <p>
                            Nome : <span style="font-weight: normal"> <?=$current_user->first_name?></span>
                        </p>
                        <p>
                            Cognome : <span style="font-weight: normal"><?=$current_user->last_name?></span>
                        </p>
                        <p>
                            Email : <span style="font-weight: normal"><?=$current_user->user_email?></span>
                        </p>
                        <p>
                            Telefono : <span style="font-weight: normal"><?=get_user_meta($current_user->ID,'telefono',true)?></span>
                        </p>
                    </div>

                </div>
            </div>
            <div class="col-md-9">
                <?php acf_form('new-segnalazione-azienda'); ?>
                <br><br>
                <h4 style="margin-bottom: 21px">Vuoi fare una denuncia alla Polizia Postale?</h4>
                <a class="btn btn-primary"
                   style="background-color: #4A9BE5!important;width: 195px!important;"
                    href="https://www.commissariatodips.it/area-riservata/accedi.html?sender=editsegnalazioni"
                    target="_blank">
                    Clicca qui
                </a>
            </div>
        </div>



    </div>
</div>

<?php
get_footer();