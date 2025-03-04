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

// ottengo le categirie che l'utente può vedere
$enabled_categories = get_field('filtro_categorie', 'user_' . get_current_user_id());

if (is_array($enabled_categories)) {
	if (!in_array(get_queried_object()->term_id, $enabled_categories)) {
		die('Non puoi visualizzare gli articoli di questa categoria');
	}
}

get_header();

?>
    <style>
        .cat-all-<?= strtolower(single_cat_title()); ?>{
            font-weight: 700!important;
            font-family: 'Lato', serif;
            font-style: normal;
            color: #333333;
        }
    </style>
<div class="section" id="top_banner" style="height: 380px;position: relative;display:flex;flex-direction: column;align-items: center;justify-content: center;background-image: url('<?= get_template_directory_uri() ?>/assets/images/code-bg-top.png')">
	<a href="<?= site_url() ?>">
		<div style="display: flex;align-items: center;position: relative">
			<img src="<?php echo get_template_directory_uri() ?>/assets/images/logo-cybersecurity-alliance.png" style="height:80px">
			<span style="color:white;font-size:57px;font-weight: 700;margin-left:15px">Cybersecurity Alliance</span>
		</div>
		<p style="text-decoration: none;color: #FFFFFF;font-size: 18px;font-weight: bold;position: relative">
			Al servizio delle aziende per combattere le problematiche legate alla cybersecurity
		</p>
	</a>
</div>
<div class="section">
	<div class="container">
		<h1>
			Articoli - <span class="c-blue"><?= single_cat_title() ?></span>
		</h1>
		<br>
		<div class="row gx-4 gy-4">
			<!-- <div class="col-xs-12" style="margin-bottom:25px">
				<h5>CATEGORIE</h5>
				<a style="padding:0 5px 0 0" href="<?= site_url() ?>">Tutti</a>
				<?php

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
			</div> -->
			<div class="searchbox-container">
				<div class="title-col">
					<h2 class="main-title">Categorie</h2>
					<a style="padding:0 5px 0 0" href="<?= site_url() ?>">Tutti</a>
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
						<a class="cat-all-<?= ($t->name) ?>" style="padding:0 5px" href="<?= site_url() ?>/category/<?= $t->slug ?>"><?= $t->name ?></a>
					<?php
					}
					?>
				</div>
				<div class="search-col">
					<!-- Create the search form -->
					<form method="get" action="<?php echo esc_url(home_url()); ?>">
						<div class="search-box">
							<input type="text" id="search-input" class="search-input" placeholder="Cerca…" name="s">
							<span class="search-icon"><img src="<?php echo get_template_directory_uri() ?>/assets/images/search.png" alt=""></span>
							<span class="clear-icon"><img src="<?php echo get_template_directory_uri() ?>/assets/images/close.png" alt=""></span>
						</div>
					</form>
				</div>
			</div>
			<!-- articoli loop -->
			<?php
			if (is_administrator()) {
				$args = array(
					"post_type" => "post",
					"posts_per_page" => 12,
					'tax_query' => array(
						array(
							'taxonomy' => 'category',
							'field' => 'slug',
							'terms' => get_queried_object()->slug
						)
					)
				);
			} else {
				$args = array(
					"post_type" => "post",
					"posts_per_page" => 12,
					"meta_query" => array(
						'relation' => 'OR', // Optional, defaults to "AND"
						array(
							'key'     => 'tutte_territoriali',
							'value'   => 'Si',
							'compare' => '='
						),
						array(
							'key'     => 'territoriale',
							'value'   => $_SESSION['territoriale'],
							'compare' => 'IN'
						),
					),
					'tax_query' => array(
						array(
							'taxonomy' => 'category',
							'field' => 'slug',
							'terms' => get_queried_object()->slug
						)
					)
				);
			}
			$result = new WP_Query($args);
			if ($result->have_posts()) :
				/* Start the Loop */
				while ($result->have_posts()) :
					$result->the_post();
			?>
					<div class="col-md-6 col-lg-4 col-12 col-sm-6">
						<div class="card p-3  normal-posts h-100">
							<div class="cat-meta d-flex justify-content-between mb-4">
								<p class="cat-badge m-0 p-0" style="background-color: <?php echo $color; ?>;"> <?php the_category(", ", "single") ?></p>
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
							<div class="author">
								<h5><?php // Get the author name for the current post
									$author_name = get_the_author();

									// Display the author name
									if (!empty($author_name)) {
										echo '<div class="post-author">';
										//echo  $author_name;
										echo '</div>';
									}; ?>
								</h5>
								<p class="p-0 m-0 text-white">| <?php blogpress_posted_on() ?></p>
							</div>
						</div>
					</div>
				<?php
				endwhile;
				?>
				<div class="mainpagination d-flex align-items-center justify-content-center mt-5">
					<?php
					echo get_the_posts_pagination()
					?>
				</div>
			<?php
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
