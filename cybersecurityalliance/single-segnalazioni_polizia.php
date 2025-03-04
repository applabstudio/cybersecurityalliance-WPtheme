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
    <div class="container">
      
        <div class="singlepost-title">
            <?php the_title( '<h2>', '</h2>' ); ?>
        </div>
        <?php
				while ( have_posts() ) :
					the_post();
					?>
        <div class="author-singlemeta d-flex align-items-center justify-content-center">
           
            <p class="p-0 m-0 text-white">| <?php blogpress_posted_on() ?></p>
        </div>
    </div>
</div>
<div class="section">
    <div class="container">

        <div class="row">
            <div class="col-md-3">
                <div class="create-reporttoarticle bg-white p-3">
                    <?php
					if(get_the_post_thumbnail_url() != FALSE){
						?>
                    <img class="img-thumbnail" src="<?=get_the_post_thumbnail_url()?>" style="width:100%">
                    <br><br>
                    <?php
                                }
                            ?>
                    <?php
                                if(is_administrator() == TRUE || is_territoriale() == TRUE){
                                    if(isset($_POST['crea-articolo'])){
                                        $articolo = array(
                                        'post_type' => 'post',
                                        'post_title'   => get_the_title(),
                                        'post_content' => get_field('descrizione',get_the_ID()),
                                        'post_author' => wp_get_current_user()->ID,
                                        'post_status' => 'draft',
                                        );
                                        // Update the post into the database
                                        $insert = wp_insert_post( $articolo );
                                        if($insert){
                                            update_field('allegati', get_field('allegati',get_the_ID()), $insert);
                                            update_field('territoriale', $_SESSION['territoriale'][0], $insert);
                                            update_field('segnalazione_polizia_postale', get_the_ID(), $insert);

                                            echo "Articolo creato in bozza!<br><br>";
                                            $url = site_url() . "/wp-admin/post.php?post=" . $insert . "&action=edit";
                                            ?>
                    <a href="<?=$url?>" class="btn btn-primary" style="background-color:#4C70BC !important;">Controlla e
                        pubblica</a>
                    <?php
                            }
                        } else {
                            ?>
                    <p>Vuoi creare un articolo partendo da questa segnalazione?</p>
                    <br>
                    <form method="POST">
                        <input type="submit" name="crea-articolo" class="btn btn-primary" value="Crea articolo">
                    </form>
                    <?php
                        }
                    }
                    ?>
                </div>
            </div>
            <div class="col-md-6">
                <div>
                    <h5 class="mb-3">DESCRIZIONE</h5>
                    <?php
						echo get_field('descrizione',get_the_ID());
						?>
                </div>
                <br>
                <div>
                    <?php
                        if(get_field('note',get_the_ID()) !== ''){
                            ?>
                    <h5 class="c-blue">NOTE</h5>
                    <?php
                            echo get_field('note',get_the_ID());
                        }
						?>
                </div>
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
            </div>
        </div>

        <?php
		endwhile; // End of the loop.
		?>
    </div>
</div>
<?php
get_footer();