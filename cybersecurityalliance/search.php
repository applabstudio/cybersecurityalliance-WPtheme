<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package cybersecurityalliance
 */
get_header();

?>
<div class="section" id="top_banner"
    style="height: 380px;position: relative;display:flex;flex-direction: column;align-items: center;justify-content: center;background-image: url('<?=get_template_directory_uri()?>/assets/images/code-bg-top.png')">
    <div class="container ">
        <a href="<?=site_url()?>">
            <div style="display: flex;align-items: center;position: relative"
                class="text-center justify-content-center">
                <img src="<?=site_url()?>/wp-content/uploads/2018/08/logo-cybersecurity-alliance.png"
                    style="height:80px">
                <h2 class="main-websitetitle">Cybersecurity Alliance</h2>
            </div>
            <p style="text-decoration: none;color: #FFFFFF;font-size: 18px;font-weight: bold;position: relative; text-align:center;"
                class="mt-2">
                Al servizio delle aziende per combattere le problematiche legate alla cybersecurity
            </p>
        </a>
    </div>
</div>
<div class="container">
    <h1 class="page-title mt-5 mb-4">
        <?php
		/* translators: %s: search query. */
		printf( esc_html__( 'Risultati di ricerca per : "%s"', 'blogpress' ), '<span>' . get_search_query() . '</span>' );
		?>
    </h1>
    <div class="searchbox-container">
        <div class="title-col">
            <h2 class="main-title">Categorie</h2>
            <div class="links mt-4">
                    <a style="padding:0 5px 0 0; color:#333333;" href="<?= site_url() ?>">Tutti</a>
                                <?php

                            // ottengo le categirie che l'utente può vedere
                            $enabled_categories = get_field('filtro_categorie', 'user_' . get_current_user_id());

                            $args_cat = array(
                                'taxonomy' => 'category',
                                'hide_empty' => true,
                            );

                            if ($enabled_categories !== false) {
                                $args_cat['include'] = $enabled_categories;
                            }

                            $terms = get_terms($args_cat);
                            foreach ($terms as $t) {
                            ?>
                    <a style="padding:0 5px" href="<?= site_url() ?>/category/<?= $t->slug ?>"><?= $t->name ?></a>
                        <?php
                    }
                    ?>
                </div>
        </div>
        <div class="search-col">
            <!-- Create the search form -->
            <form method="get" action="<?php echo esc_url( home_url() ); ?>">
                <div class="search-box">
                    <input type="text" id="search-input" class="search-input" placeholder="Cerca…" name="s">
                    <span class="search-icon"><img
                            src="<?php echo get_template_directory_uri() ?>/assets/images/search.png" alt=""></span>
                    <span class="clear-icon"><img
                            src="<?php echo get_template_directory_uri() ?>/assets/images/close.png" alt=""></span>
                </div>
            </form>
        </div>
    </div>
    <div class="row category-postrow gx-4 gy-4 mb-4">
        <?php
                if(have_posts()){
                while(have_posts()){
                    the_post();
                

                
	            ?>
        <div class="col-md-6 col-lg-4 col-12 col-sm-6">
            <div class="card p-3  normal-posts h-100">
                <div class="card-body">
                    <div class="cat-meta d-flex justify-content-between mb-4">
                        <p class="cat-badge p-0 m-0" style="background-color: ;"> <?php the_category(", ", "single") ?></p>
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
                    <div class="catfeaturepost-title">
                        <h2>
                            <a href="<?php the_permalink() ?>"><?php the_title() ?></a>
                            <?php the_field( 'hellotext', $term_id_prefixed ); ?>
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
<!--                    <div class="author">-->
<!--                        <h5>--><?php //// Get the author name for the current post
//					$author_name = get_the_author();
//
//					// Display the author name
//					if ( ! empty( $author_name ) ) {
//					echo '<div class="post-author">';
//					echo  'By : '.$author_name;
//					echo '</div>';
//					}; ?>
<!--                        </h5>-->
<!--                    </div>-->
                </div>
            </div>
        </div>

        <?php
                }?>
      <div class="mainpagination d-flex align-items-center justify-content-center mt-5">
                <?php
         echo get_the_posts_pagination()
            ?>
            </div>
        <?php
             }
                else {
                    echo "<h2 class='text-center'>Sorry No Posts Found Againest Your Search Keyword</h2>";
                }
	
	            ?>
    </div>
</div>
<?php


get_footer();