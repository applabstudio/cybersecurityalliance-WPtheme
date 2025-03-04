<?php
/*
    Template name: Invita collaboratori
*/

acf_form_head();
get_header();


?>
<div class="section" id="top_banner"
    style="height: 380px;position: relative;display:flex;flex-direction: column;align-items: center;justify-content: center;background-image: url('<?=get_template_directory_uri()?>/assets/images/code-bg-top.png')">
    <div class="container">
        <a href="<?=site_url()?>">
            <h2 class="main-websitetitle text-center">Invita collega</h2>
            <p class="text-white text-decoration-none text-center" style="font-size: 24px;"> Richiedi un altro account
                aziendale di accesso alla piattaforma per un collega. L’Associazione esaminerà la
                richiesta e risponderà quanto prima.</p>
        </a>
    </div>
</div>
<div class="section">
    <div class="container m-auto">
        <div class="row m-auto">
            <div class="col-12 m-auto" style="width: 842px!important;">
                <form id="invita-collaboratore-form">
                    <label>Nome </Label>
                    <input type="text" id="nome" class="form-control"
                        placeholder="Scrivi il titolo della segnalazione" />
                    <br>
                    <label>Cognome </Label>
                    <input type="text" id="cognome" class="form-control"
                        placeholder="Indica la tipologia della segnalazione" />
                    <br>
                    <label>Email </Label>
                    <input type="email" id="email" class="form-control"
                        placeholder="Indica la tipologia della segnalazione" />
                    <br>
                    <label>Telefono </Label>
                    <input type="text" id="telefono" class="form-control"
                        placeholder="Indica la tipologia della segnalazione" />
                    <br>
                    <label>Codice Fiscale </Label>
                    <input type="text" id="cf" class="form-control"
                        placeholder="Indica la tipologia della segnalazione" />
                    <br><br>
                    <div class="g-recaptcha" data-sitekey="6LcE-XMUAAAAAEpa_Epg6QphAPNz6QYpQ2M0UMBE"></div>
                    <?php wp_nonce_field( 'invita' ); ?>
                    <input type="submit" value="Invita" class="btn btn-invite">
                </form>
            </div>
        </div>


    </div>
</div>

<?php
get_footer();