<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package cybersecurityalliance
 */

get_header();
?>
<div class="section" id="top_banner"
    style="height: 380px;position: relative;display:flex;flex-direction: column;align-items: center;justify-content: center;background-image: url('<?=get_template_directory_uri()?>/assets/images/code-bg-top.png')">
    <div class="singlecat-meta mb-4">
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
        <p class="cat-badge" style="background-color: <?php $color; ?>;"> <?php the_category(", ", "single") ?></p>
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
    <div class="singlepost-title">
        <?php the_title( '<h2>', '</h2>' ); ?>
    </div>
    <?php
				while ( have_posts() ) :
					the_post();
					?>
    <div class="author-singlemeta d-flex align-items-center mt-4">
<!--        <h5 class="m-0 p-0">--><?php //// Get the author name for the current post
//					$author_name = get_the_author();
//
//					// Display the author name
//					if ( ! empty( $author_name ) ) {
//					echo '<div class="post-author">';
//					echo  $author_name;
//					echo '</div>';
//					}; ?>
<!--        </h5>-->
        <p class="p-0 m-0 text-white"><?php blogpress_posted_on() ?></p>
    </div>
</div>
<div class="container m-auto">
    <div class="row ">
        <div class="single-template-box">
            <?php
	            the_content();
	        ?>
            <div class="attachments mt-5">
                <img src="<?php echo get_template_directory_uri() ?>/assets/images/attachment_icon.png" alt="">
                <h3 class="panel-title mt-3">Allegati</h3>
                <div class="attachment-links mt-3">
                    <?php
							$allegati = get_field('allegati',get_the_ID());
							if(empty($allegati)){
								echo "<p class='not-found-attachment'>Non ci sono allegati.</p>";
							} else {
								echo "<ol style='margin:0;padding-left:15px'>";
								foreach($allegati as $a){
									?>
                    <li>
                        <a href="<?=$a['file']['url']?>" target="_blank">
                            <?=$a['titolo']?>
                        </a>
                    </li>
                    <?php
								}
								echo "</ol>";
							}
							?>
                </div>
            </div>
            <div class="comments mt-5">
                <div>
                    <?php
						if(get_post_type() == 'post' && !is_polizia_postale()){
							?>
                    <h4>Commenti</h4>
                    <hr class="comment-border-bottom">
                    <?php
						// prelevo i commenti per quell'articolo pubblici
						$args = array(
							"post_type" => "commenti_articoli",
							"posts_per_page" => -1,
							"status" => "public",
							"meta_query" => array(
							    array(
									'key'     => 'id_articolo_collegato',
									'value'   => get_the_ID(),
									'compare' => '='
								)
							)
						);
						$commenti = array_reverse(get_posts($args));
							if(count($commenti)>0){
								foreach ($commenti as $c){
									$autore = get_userdata($c->post_author);
									$azienda_autore = get_user_company_by_id($c->post_author);
									$anonimo = get_post_meta($c->ID,'anonimo',false)[0][0];
									if($anonimo == 'No'){
										?>
                    <p>
                        <b><?=$autore->first_name?> <?=$autore->last_name?></b> di <b><?=$azienda_autore?></b> ha
                        scritto:
                    </p>
                    <?php
					    } else {
					?>
                    <p>Un <b>Utente</b> ha scritto:</p>
                    <?php
						}
					?>
                    <div
                        style="padding:10px;background:#eeeeee;border-radius:10px;margin-bottom:20px;display:inline-block;">
                        <?=$c->post_content?>
                    </div>
                    <?php
								}
							} else {
								echo "<p>Non ci sono commenti al momento.</p>";
							}
							?>
                    <form id="invita-commento-form">
                        <br>
                        <label>Commenta</Label>
                        <textarea id="commento" class="form-control" rows="10" style="resize:none;"></textarea>
                        <br>

                        <div class="radio-button">
                            Vuoi rendere anonimo questo commento?
                            <br>
                            <input type="radio" name="anonimo" value="Si"> Si
                            <br>
                            <input type="radio" name="anonimo" value="No" checked> No
                            <br><br>
                            <input type="hidden" id="articolo" value="<?=get_the_ID()?>">
                            <div class="g-recaptcha" data-sitekey="6LcE-XMUAAAAAEpa_Epg6QphAPNz6QYpQ2M0UMBE"></div>
                            <?php wp_nonce_field( 'commento' ); ?>
                            <input type="submit" value="Invia" class="btn btn-primary">
                        </div>

                    </form>
                    <?php
						}
						?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
		endwhile; // End of the loop.
		?>
<?php
get_footer();