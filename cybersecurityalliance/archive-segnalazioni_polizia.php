<?php
// accessibile solo all'admin e alle territoriali
if(!is_administrator()){
    if(!is_territoriale()){
        if(!is_polizia_postale()){
            header("Location:" . site_url());
            die();
        }
    }
}

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
                <span style="color:white;font-size:57px;font-weight: 700;margin-left:15px;">Segnalazioni Polizia
                    Postale</span>
            </div>
        </a>
    </div>

</div>
<div class="section">
    <div class="container">
        <div class="row gx-4 gy-4">
            <!-- loop -->
            <?php
            $authors = get_my_pp_user();
            if(is_administrator()){
                $args = array(
                    "post_type" => "segnalazioni_polizia",
                    "posts_per_page" => 12,
                );
            } else {
                $args = array(
                    "post_type" => "segnalazioni_polizia",
                    "posts_per_page" => 12,
                    "author__in" => $authors
                );
            }
            $result = new WP_Query($args);

		    if ( $result->have_posts() ) :
				/* Start the Loop */
				while ( $result->have_posts() ) :
					$result->the_post();
					?>
            <div class="col-md-6 col-lg-4 col-12 col-sm-6">
                <div class="card normal-posts p-3 h-100">
                    <!-- <div class="cat-meta">
                        <span><img src="<?php echo get_template_directory_uri() ?>/assets/images/Group 14.png" alt="">
                            <?php the_field('segnalazioni_polizia_postale_reading_time'); echo" '" ?>
                        </span>
                    </div> -->
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
                    <div class="author justify-content-end">
                        
                        <p class="p-0 m-0 text-white">| <?php blogpress_posted_on() ?></p>
                    </div>
                </div>
            </div>
            <?php
				endwhile;
				the_posts_navigation();
			else :
				echo "Non ci sono segnalazioni.";
			endif;
			?>
            <!-- end articoli loop -->
        </div>
    </div>
</div>

<?php
get_footer();