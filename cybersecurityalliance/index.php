<?php
/*$json = json_decode(file_get_contents("/Users/francescoscotti/Documents/Lavoro/sicurezza/cybersec/wp-content/themes/cybersecurityalliance/uniconail.min.json"));

foreach ($json as $azienda){
	$my_post = array(
		'post_title' => $azienda->Ragione_Sociale,
		'post_status' => 'publish',
		'post_author' => wp_get_current_user()->ID,
		'post_type' => 'aziende',
	);
	$newpost_id=wp_insert_post($my_post);
	if($newpost_id != 0){
		foreach($azienda as $field=>$value){
			update_field($field, $value, $newpost_id);
		}
	}
}

echo "<h1>FINITO!</h1>";

exit;*/



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
    style="height: 380px;position: relative;display:flex;flex-direction: column;align-items: center;justify-content: center;background-image: url('<?= get_template_directory_uri() ?>/assets/images/code-bg-top.png')">
    <div class="container ">
        <a href="<?= site_url() ?>">
            <div style="display: flex;align-items: center;position: relative"
                class="text-center justify-content-center">
                <img src="<?php echo get_template_directory_uri() ?>/assets/images/logo-cybersecurity-alliance.png"
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
<div class="section">

    <div class="container">
        <h2 class="main-title" style="
        font-family: 'Lato';
font-style: normal;
font-weight: 700;
font-size: 40px;
line-height: 47px;">Le ultime news dalla community</h2>
        <h5 class="sub-title">In evidenza</h5>
        <div class="row gx-2 gy-2 mb-2">
            <?php
            $args = array('post_type' => 'post', 'post_status' => 'publish', 'posts_per_page' => 3,);
            // The Query
            $featured = new WP_Query($args);
            $fi = 1;
            // The Loop
            if ($featured->have_posts()) {



                while ($featured->have_posts()) {
                    $featured->the_post();

            ?>
            <div class="col-md-6 col-lg-4 col-12 col-sm-6">
                <div class="card p-3 featured-posts h-100 justify-content-evenly">
                    <div class="card-body">
                        <div class="cat-meta d-flex justify-content-between align-items-center mb-4">
                            <?php    // get the current taxonomy term
                                    //  $term = get_queried_object();
                                    // print_r();
                                    $cat_id = get_the_category(get_the_ID())[0]->term_id;
                                    global $wpdb;
                                    $result = $wpdb->get_results("SELECT meta_value FROM wp_termmeta WHERE term_id = " . $cat_id . " and meta_key = 'bg_color_of_category'");
                                    $color = $result[0]->meta_value;
                                    // vars

                                    //  print_r($color);
                                    ?>
                            <p class="cat-badge m-0 p-0" style="background-color: <?php echo $color; ?>;">

                                <?php the_category(", ", "single") ?></p>
                            <span><img src="<?php echo get_template_directory_uri() ?>/assets/images/Group 14.png"
                                    alt="">
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
                        <div class="featurepost-title">
                            <h2>
                                <a href="<?php the_permalink() ?>"><?php the_title() ?></a>
                                <?php the_field('hellotext', $term_id_prefixed); ?>
                            </h2>
                        </div>
                        <div class="content">
                            <?php
                                    // Get the excerpt for the current post
                                    $excerpt = get_the_excerpt();

                                    // Display the excerpt
                                    if (!empty($excerpt)) {
                                        echo '<div class="post-excerpt">';
                                        echo $excerpt;
                                        echo '</div>';
                                    }
                                    ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php
                }
            } else {
                // no posts found
            }
            /* Restore original Post Data */
            wp_reset_postdata();
            ?>
        </div>
    </div>
    <div class="category-post-container container mt-5">
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
                <form method="get" action="<?php echo esc_url(home_url()); ?>">
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
            $args = array('post_type' => 'post', 'post_status' => 'publish', 'paged' => $paged,);
            // The Query
            $featured = new WP_Query($args);
            $fi = 1;
            // The Loop
            ?>
            <?php
            // $background_colors = ['#FFD96D', '#EF719A', '#A578DC', '#33C481', '#23ABF2'];
            if ($featured->have_posts()) {
                while ($featured->have_posts()) {
                    $featured->the_post();
            ?>
            <div class="col-md-6 col-lg-4 col-12 col-sm-6">

                <div class="card p-3  normal-posts h-100">
                    <div class="cat-meta d-flex justify-content-between mb-4">
                        <?php    // get the current taxonomy term
                                    //  $term = get_queried_object();
                                    // print_r();
                                    $cat_id = get_the_category(get_the_ID())[0]->term_id;
                                    global $wpdb;
                                    $result = $wpdb->get_results("SELECT meta_value FROM wp_termmeta WHERE term_id = " . $cat_id . " and meta_key = 'bg_color_of_category'");
                                    $color = $result[0]->meta_value;
                                    // vars

                                    //  print_r($color);
                                    ?>
                        <p class="cat-badge  p-0" style="background-color:<?php echo $color; ?>;">
                            <?php the_category(", ", "single") ?></p>
                        <span><img src="<?php echo get_template_directory_uri() ?>/assets/images/Group 14.png" alt="">
                            <?php if (get_field('tempo_lettura')) {
                                        the_field('tempo_lettura');
                                        echo " '";
                                    } else {
                                        echo "3 '";
                                    } ?>
                        </span>
                    </div>
                    <div class="catfeaturepost-title">
                        <h2>
                            <a href="<?php the_permalink() ?>"><?php
                                                                        if (strlen(get_the_title()) > 80) {
                                                                            echo substr(get_the_title(), 0, 80) . "...";
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
                                if (!empty($excerpt)) {
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
                }
                ?>
            <div class="mainpagination d-flex align-items-center justify-content-center mt-5">
                <?php
                    echo get_the_posts_pagination()
                    ?>
            </div>
            <?php
            }
            ?>

        </div>
    </div>

</div>

<?php
get_footer();