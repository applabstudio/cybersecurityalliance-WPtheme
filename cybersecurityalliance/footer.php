<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package cybersecurityalliance
 */

?>

<?php
// escludo il footer dalla pagina di login
if(!is_page(224)){
?>
<hr>
    <div id="footer-box" style="border-top:1px solid #eee;font-size:12px" class="text-center">
        <div style="padding:20px;">
            <img src="<?=site_url()?>/wp-content/uploads/2018/09/stemma_araldico.png" style="height:60px;margin:0 10px 20px 0">
            <img src="<?=site_url()?>/wp-content/uploads/2018/09/logo-assolombarda.png" style="height:60px;margin:0 10px 20px 0">
            <p style="font-family: 'Lato';
font-style: normal;
font-weight: 500;
font-size: 14px;
line-height: 56px;
/* Neutral/Grey_2 */

color: #9D9D9D;">
                Alcune informazioni di sicurezza sono fornite dal Compartimento Polizia Postale e delle Comunicazioni per la Lombardia a seguito del protocollo di collaborazione del 27 Febbraio 2017
            </p>
        </div>
        <div class="text-center" style="background:;border-top:1px solid #CDCDCD;padding:20px; font-family: 'Lato';
font-style: normal;
font-weight: 500;
font-size: 14px;
line-height: 56px;
/* Neutral/Grey_2 */

color: #9D9D9D;">
            @ Copyright <?=date('Y')?> Assolombarda - Designed by <a href="http://www.dglen.it" target="_blank" style="
            /* Neutral/Grey_2 */

color: #9D9D9D;">dglen srl</a>
        </div>
    </div>
<?php
}

?>

</body>
</html>
