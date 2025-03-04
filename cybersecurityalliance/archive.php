<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package cybersecurityalliance
 */

get_header();

?>
<div class="section" id="top_banner"
    style="height: 380px;position: relative;display:flex;flex-direction: column;align-items: center;justify-content: center;background-image: url('<?=get_template_directory_uri()?>/assets/images/code-bg-top.png')">
   
    <div class="container">
        <a href="<?=site_url()?>">
            <div class="text-center">
            <h2 class="main-websitetitle text-center"><?=post_type_archive_title()?></h2>
            </div>
        </a>
    </div>
</div>
<div class="section">
    <div class="container">
        <br>
        <div class="row gx-4 gy-4 card-ki-row">
            <!-- loop -->
            <?php
		    if ( have_posts() ) :
				/* Start the Loop */
				while ( have_posts() ) :
					the_post();
					?>
            <div class="col-md-6 col-lg-4 col-12 col-sm-6">
                <div class="card p-3  normal-posts h-100 justify-content-evenly">
                    <div class="cat-meta mb-4">
                        <span><img src="<?php echo get_template_directory_uri() ?>/assets/images/Group 14.png" alt="">
                        <?php
                                        // print_r(get_field('tempo_lettura'));
                                        if (get_field('tempo_lettura')) {
                                            the_field('tempo_lettura');
                                            echo " '";
                                        } else {
                                            echo "3 '";
                                        }
                                        ?>
                        </span>
                    </div>
                    <div class="normal-title">
                        <h2>
                            <a href="<?php the_permalink() ?>"><?php
									if(strlen(get_the_title()) > 80){
										echo substr(get_the_title(),0,80) . "...";
									} else {
										echo get_the_title();
									}
									?></a>
                        </h2>
                    </div>
                    <div class="content">
                        <?php
					// Get the excerpt for the current post
					$excerpt = get_the_excerpt();

					// Display the excerpt
					if ( ! empty( $excerpt ) ) {
					echo '<div class="post-excerpt">';
					echo $excerpt;
					echo '</div>';
					}  
				   ?>
                    </div>
                  
                </div>
            </div>

            <?php
				endwhile;
				the_posts_navigation();
			else :
				echo "Non ci sono articoli.";
			endif;
			?>
            <!-- end articoli loop -->
        </div>
    </div>
</div>

<?php
get_footer();