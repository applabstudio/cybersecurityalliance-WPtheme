<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package cybersecurityalliance
 */

get_header();
?>
    <div class="section" id="top_banner" style="height: 380px;position: relative;display:flex;flex-direction: column;align-items: center;justify-content: center;background-image: url('<?=get_template_directory_uri()?>/assets/images/code-bg-top.png')">
		<div class="container">
        <a href="<?=site_url()?>">
            <div class="text-center">
                <span style="color:white;font-size:57px;font-weight: 700;margin-left:15px;">S<?=get_the_title()?></span>
            </div>
        </a>
    </div>
    </div>
<div class="section">
	<div class="container">
		<?php
		while ( have_posts() ) :
			the_post();

			?>
			<div class="row">
				<div class="col-xs-12">
					<h1 style="margin-top:0;">
						<?=get_the_title()?>
					</h1>
					<br>
					<div>
						<?php
						the_content();
						?>
					</div>
				</div>
			</div>
			<?php

		endwhile; // End of the loop.
		?>
	</div>
</div>
<?php
get_footer();
