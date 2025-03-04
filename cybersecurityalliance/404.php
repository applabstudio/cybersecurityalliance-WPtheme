<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package cybersecurityalliance
 */

get_header();
?>

<div class="section">
	<div class="container text-center">
		<h1>OPS!</h1>
		<h4>Pagina non trovata!</h4>
		<br><br>
		<a href="<?=site_url()?>" class="btn btn-primary btn-lg">
			Torna alla home
		</a>
	</div>
</div>

<?php
get_footer();
