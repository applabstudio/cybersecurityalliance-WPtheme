<?php
ini_set('memory_limit',-1);

session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

use function Clue\StreamFilter\fun;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

// salvo in sessione l'id della territoriale dell'utente
$terr = get_user_meta(get_current_user_id(),'territoriali',false)[0];
$_SESSION['territoriale'] = $terr;
/**
 * cybersecurityalliance functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package cybersecurityalliance
 */

if ( ! function_exists( 'cybersecurityalliance_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function cybersecurityalliance_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on cybersecurityalliance, use a find and replace
		 * to change 'cybersecurityalliance' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'cybersecurityalliance', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'menu-1' => esc_html__( 'Primary', 'cybersecurityalliance' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'cybersecurityalliance_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) );
	}
endif;
add_action( 'after_setup_theme', 'cybersecurityalliance_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function cybersecurityalliance_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'cybersecurityalliance_content_width', 640 );
}
add_action( 'after_setup_theme', 'cybersecurityalliance_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function cybersecurityalliance_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'cybersecurityalliance' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'cybersecurityalliance' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'cybersecurityalliance_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function cybersecurityalliance_scripts() {
	
	wp_enqueue_style( 'cybersecurityalliance-style', get_stylesheet_uri() );
	wp_enqueue_style('bootstrap-css', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css');
	wp_enqueue_style('font-awesome-css', get_template_directory_uri(). '/assets/font-awesonme/all.min.css', array(), );
	wp_enqueue_style('custom-styles' , get_template_directory_uri(). '/assets/css/custom-styles.css', array() );
	wp_enqueue_script( 'jquery', 'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js');
	wp_enqueue_script( 'pooper-js', 'https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js');
	wp_enqueue_script( 'bootstrap-js', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js');

	wp_enqueue_script( 'main-js', get_template_directory_uri() . '/js/main.js');

	wp_enqueue_script( 'cybersecurityalliance-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );

	wp_enqueue_script( 'cybersecurityalliance-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );




	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'cybersecurityalliance_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

/* custom post type */
require get_template_directory() . '/custom-post/segnalazioni_polizia_postale.php';
require get_template_directory() . '/custom-post/segnalazioni_aziende.php';
require get_template_directory() . '/custom-post/knowledge_base.php';
require get_template_directory() . '/custom-post/aziende.php';
require get_template_directory() . '/custom-post/richieste_utenti.php';
require get_template_directory() . '/custom-post/commenti_articoli.php';





/* custom taxonomies */
require get_template_directory() . '/custom-taxonomies/territoriali.php';

/* acf form customization */
require get_template_directory() . '/acf-customization/customization.php';

/* custom function  */

// restituisce la territoriale di un utente
function get_user_territoriale(){
	$user = "user_".get_current_user_id();
	$territoriale = get_field('territoriali', $user);
	return $territoriale;
}

// restitusce TRUE se l'utente loggato è un administrator
function is_administrator(){
	$user = get_userdata( get_current_user_id() );
	if(in_array('administrator',$user->roles)){
		return TRUE;
	} else {
		return FALSE;
	}
}

// restitusce TRUE se l'utente loggato è un Territoriale
function is_territoriale(){
	$user = get_userdata( get_current_user_id() );
	if(in_array('territoriale',$user->roles)){
		return TRUE;
	} else {
		return FALSE;
	}
}

// restitusce TRUE se l'utente loggato è un polizia_postale
function is_polizia_postale(){
	$user = get_userdata( get_current_user_id() );
	if(in_array('polizia_postale',$user->roles)){
		return TRUE;
	} else {
		return FALSE;
	}
}

// restitusce TRUE se l'utente loggato è un referente_azienda
function is_referente_azienda(){
	$user = get_userdata( get_current_user_id() );
	if(in_array('referente_azienda',$user->roles)){
		return TRUE;
	} else {
		return FALSE;
	}
}

// restituisce il nome dell'azienda di cui è referente l'utente loggato
function get_user_company(){
    // prelevo le info dell'utente loggato
    $current_user = wp_get_current_user();
    $args = array(
        "post_type" => "aziende",
        "posts_per_page" => -1
    );
    $aziende = get_posts($args);
    // ciclo le aziende
    foreach ($aziende as $azienda){
        $referenti = get_field('referenti',$azienda->ID);
		if(!empty($referenti) || $referenti == ''){
			// ciclo i ferenti per vedere se combacia l'id
			if(is_array($referenti)){
				foreach($referenti as $ref){
	                if($ref->data->ID == $current_user->ID){
	                    return $azienda->post_title;
	                    break;
	                }
	            } // end ciclo referenti
			}
		} else {
			return FALSE;
		}
    } // end ciclo aziende
}

// restituisce il nome dell'azienda di cui è referente l'utente loggato
function get_user_company_by_id($user_id){
	$args = array(
        "post_type" => "aziende",
        "posts_per_page" => -1
    );
    $aziende = get_posts($args);
    // ciclo le aziende
    foreach ($aziende as $azienda){
        $referenti = get_field('referenti',$azienda->ID);
		if(!empty($referenti) || $referenti == ''){
			// ciclo i ferenti per vedere se combacia l'id
			if(is_array($referenti)){
				foreach($referenti as $ref){
	                if($ref->data->ID == $user_id){
	                    return $azienda->post_title;
	                    break;
	                }
	            } // end ciclo referenti
			}
		} else {
			return FALSE;
		}
    } // end ciclo aziende
}

// questo metodo restituisce se un commento può essere pubblicato subito o no...
function get_comment_status_to_send($id_articolo){
    // prelevo tutti i commenti di un utente
    $args = array(
        "post_type" => "commenti_articoli",
        "posts_per_page" => 5,
        "author" => wp_get_current_user()->ID,
		'orderby' => 'publish_date',
		'order' => 'DESC',
        "meta_query" => array(
            array(
                'key'     => 'id_articolo_collegato',
                'value'   => $id_articolo,
                'compare' => '='
            )
        )
    );
    $old_comments = get_posts($args);
    if(count($old_comments) < 5){
        // return privateù
        return 'private';
    } else {
        $count_public = 0;
        // ciclo i commenti per vedere se sono tutti pubblici
        foreach ($old_comments as $c){
            if($c->post_status == 'publish'){
                $count_public++;
            }
        }
        if($count_public == 5){
            return 'publish';
        } else {
            return 'private';
        }
    }
}

// funzione che mi ritorna gli id degli utenti di polizia postale che hanno la mia territoriale
// cosi mostro alla territoriale le segnalazioni corrette e non quelle di altre polizie postali
function get_my_pp_user(){
	// ciclo gli utenti
	$args = array(
		'role'         => 'polizia_postale',
	);
	$users = get_users( $args );
	// cicla
	$response = array();
	if(empty($users)){
		return FALSE;
	} else {
		foreach($users as $u){
			// prelevo il campo territoriale dell'utente
			$terr_utente = get_user_meta($u->ID,'territoriali',false)[0];
			// ciclo le territoriali di pp
			foreach($terr_utente as $t){
				if(in_array($t,$_SESSION['territoriale'])){
					array_push($response,$u->ID);
				}
			}
		}
		// pusho l'admin sempre...
		array_push($response,1);
		return $response;
	}
}


add_action('init', 'myStartSession', 1);
add_action('wp_logout', 'myEndSession');
add_action('wp_login', 'myEndSession');

function myStartSession() {
    if(!session_id()) {
        session_start();
    }
}

function myEndSession() {
    session_destroy ();
}

// custom redirect after logout
add_action('wp_logout','redirect_home_dopo_logout');
function redirect_home_dopo_logout(){
  wp_redirect( site_url()."/login" );
  die();
}


function posts_for_current_author($query) {

    global $pagenow;

    if( 'edit.php' != $pagenow || !$query->is_admin ){
		//return $query;
	} else {
		// filtro solo se  non sono l'admin
		if(is_administrator() == FALSE){
			if(in_array ( $query->get('post_type'), array('post','knowledge_base','aziende', 'richieste_utenti', 'commenti_articoli','segnalazioni_aziende'))){
				global $user_ID;

				$meta_query = $query->get('meta_query')? : [];



		        // append yours
		        $meta_query[] = [
		            'key' => 'territoriale',
					// id della termine della taxonomy territoriali
		            'value' =>  $_SESSION['territoriale'],
		            'compare' => 'IN'
		        ];


		        $query->set('meta_query', $meta_query);
				//return $query;
			} // end if

		} // end if admin
	}

}
add_filter('pre_get_posts', 'posts_for_current_author');

function highlightText($needle, $haystack){
	$ind = stripos($haystack, $needle);
    $len = strlen($needle);
    if($ind !== false){
        return substr($haystack, 0, $ind) . "<mark style='padding:0;background:yellow'>" . substr($haystack, $ind, $len) . "</mark>" .
            highlightText($needle, substr($haystack, $ind + $len));
    } else return $haystack;
}

function no_wordpress_errors(){
	return "Credenziali sbagliate";
}
add_filter( 'login_errors', 'no_wordpress_errors' );

function validate_acf( $value, $post_id, $field  ) {
	
	// override value
	if(is_string($value))
		$value = htmlspecialchars($value);
	else if(is_array($value)){
		foreach ($value as $key=>$item) {
			if(is_string($item))
				$value[$key] = htmlspecialchars($item);
		}
	}
	
	// do something else to the $post object via the $post_id
	
	// return
	return $value;
	
}

// acf/update_value - filter for every field
add_filter('acf/update_value', 'validate_acf', 10, 3);


function worldless_custom_script() {
	?>
	<script>
		jQuery(document).ready(function() {
			jQuery('.pw-weak').remove();
		});
	</script>
	<?php
}
add_action('wp_head','worldless_custom_script');


function load_custom_wp_admin_style() {
	wp_enqueue_script( 'my_custom_script', get_template_directory_uri() . '/js/admin.js' );
}
add_action( 'admin_enqueue_scripts', 'load_custom_wp_admin_style' );



function acf_recaptcha() {
	
	if( isset($_POST['g-recaptcha-response']) ) {
		
		// Get cURL resource
		$curl = curl_init();
		// Set some options - we are passing in a useragent too here
		curl_setopt_array($curl, array(
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_URL => 'https://www.google.com/recaptcha/api/siteverify',
			CURLOPT_POST => 1,
			CURLOPT_POSTFIELDS => array(
				'secret' => '6LcE-XMUAAAAAE-miikreSteKdcrfxnTDitecblh',
				'response' => $_POST['g-recaptcha-response']
			)
		));
		// Send the request & save response to $resp
		//$resp = json_decode(curl_exec($curl));
		$resp = curl_exec($curl);
		//echo curl_error($curl);
		//exit();
		$resp = json_decode($resp);
		// Close request to clear up some resources
		curl_close($curl);
		
		if(!$resp->success)
			acf_add_validation_error( 'my_input', 'reCAPTCHA sbagliato!' );
		
	}
	
}

add_action('acf/validate_save_post', 'acf_recaptcha', 10, 0);


// hook per mandare email a nuova pubblicazione
add_action( 'transition_post_status', 'send_mails_on_publish', 10, 3 );

function send_mails_on_publish( $new_status, $old_status, $post )
{
    if ( 'publish' !== $new_status or 'publish' === $old_status
        or 'post' !== get_post_type( $post ) )
        return;

    $subscribers = get_users();
    //$emails      = array ();

    foreach ( $subscribers as $subscriber ) {
        $destinatario = $subscriber->user_email;
		
		$mail = new PHPMailer(true);                              // Passing `true` enables exceptions
		try {
			//Recipients
			$mail->setFrom('cybersecurityalliance@assolombarda.it', 'Cybersecurity Alliance - Assolombarda');
			$mail->addAddress($destinatario);

			//Content
			$mail->isHTML(true);                                  // Set email format to HTML
			$mail->CharSet = 'UTF-8';
			$mail->Subject = 'Cybersecurity Alliance - ' . get_the_title($post);
			$mail->Body    = "Buongiorno!<br>E' stato pubblicato un nuovo articolo sulla piattaforma Cybersecurity Alliance!<br>Titolo: <a href='". get_the_permalink($post) ."'>" . get_the_title($post) . "</a>";

			$mail->send();
			
		} catch (Exception $e) {
			//echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
		}
		
	} // end foreach
	
}


// hook per mandare email a Miriam quando bozza viene pubblicata
add_action( 'transition_post_status', 'send_mails_on_publish_miriam', 10, 3 );

function send_mails_on_publish_miriam( $new_status, $old_status, $post )
{
    if ( 'publish' !== $new_status or 'publish' === $old_status
        or 'segnalazioni_polizia' !== get_post_type( $post ) )
        return;

    $subscribers = array('miriam.ieraci@assolombarda.it');
    //$emails      = array ();

    foreach ( $subscribers as $subscriber ) {
        $destinatario = $subscriber;
		
		$mail = new PHPMailer(true);                              // Passing `true` enables exceptions
		try {
			//Recipients
			$mail->setFrom('cybersecurityalliance@assolombarda.it', 'Cybersecurity Alliance - Assolombarda');
			$mail->addAddress($destinatario);

			//Content
			$mail->isHTML(true);                                  // Set email format to HTML
			$mail->CharSet = 'UTF-8';
			$mail->Subject = 'Cybersecurity Alliance - Nuova bozza da Polizia Postale - ' . get_the_title($post);
			$mail->Body    = "Buongiorno!<br>E' stata pubblicata una nuova bozza da Polizia Postale sulla piattaforma Cybersecurity Alliance!<br>Titolo: <a href='". get_the_permalink($post) ."'>" . get_the_title($post) . "</a>";

			$mail->send();
			
		} catch (Exception $e) {
			//echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
		}
		
	} // end foreach
	
}

// hook per mandare email a Miriam quando una richiesta di nuovo utente viene inviata
add_action( 'save_post', 'send_mails_on_richiesta_utente_miriam', 10, 3 );

function send_mails_on_richiesta_utente_miriam( $post_id )
{
    if(get_post_type( $post_id ) === 'richieste_utenti'){

		$subscribers = array('miriam.ieraci@assolombarda.it');
		//$emails      = array ();

		foreach ( $subscribers as $subscriber ) {
			$destinatario = $subscriber;
			
			$mail = new PHPMailer(true);                              // Passing `true` enables exceptions
			try {
				//Recipients
				$mail->setFrom('cybersecurityalliance@assolombarda.it', 'Cybersecurity Alliance - Assolombarda');
				$mail->addAddress($destinatario);

				//Content
				$mail->isHTML(true);                                  // Set email format to HTML
				$mail->CharSet = 'UTF-8';
				$mail->Subject = 'Cybersecurity Alliance - Nuova richiesta utente';
				$mail->Body    = "Buongiorno!<br>E' stata richiesta la partecipazione alla piattaforma da parte di un utente.<br><br>" . get_the_title($post_id) . "<br><br>" . get_the_content($post_id);

				$mail->send();
				
			} catch (Exception $e) {
				//echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
			}
			
		} // end foreach
	
	}
	
}

add_filter( 'rest_authentication_errors', function( $result ) {
	if ( ! empty( $result ) ) {
	  return $result;
	}
	if ( ! is_user_logged_in() ) {
	  return new WP_Error( 'Accesso negato', 'Accesso negato', array( 'status' => 401 ) );
	}
	if ( ! current_user_can( 'administrator' ) ) {
	  return new WP_Error( 'Accesso negato', 'Accesso negato', array( 'status' => 401 ) );
	}
	return $result;
});


// aggiungo il referente all'azienda alla creazione / modifica dell'utente
add_action( 'profile_update', 'profile_update_company', 10, 2 );
function profile_update_company( $user_id, $old_user_data ) {
	$user_id = $old_user_data->ID;
	$company_id = get_field('azienda', 'user_' . $user_id);
	if($company_id !== false){
		// prelevo i referenti dell'azienda e li aggiorno
		$referenti = get_field('referenti', $company_id, false);
		if(!is_array($referenti)){
			$referenti = array();
		}
		// add new id to the array
		$referenti[] = $user_id;
		// update the field
		update_field('referenti', $referenti, $company_id);
	}
}

add_action( 'user_register', 'profile_create_company', 10, 2 );
function profile_create_company( $user_id ) {
	$company_id = get_field('azienda', 'user_' . $user_id);
	if($company_id !== false){
		// prelevo i referenti dell'azienda e li aggiorno
		$referenti = get_field('referenti', $company_id, false);
		if(!is_array($referenti)){
			$referenti = array();
		}
		// add new id to the array
		$referenti[] = $user_id;
		// update the field
		update_field('referenti', $referenti, $company_id);
	}
}
function custom_excerpt_length( $length ) {
	return 15;
  }
  add_filter( 'excerpt_length', 'custom_excerpt_length' );

  function gt_get_post_view() {
    $count = get_post_meta( get_the_ID(), 'post_views_count', true );
    return "$count '";
}
function gt_set_post_view() {
    $key = 'post_views_count';
    $post_id = get_the_ID();
    $count = (int) get_post_meta( $post_id, $key, true );
    $count++;
    update_post_meta( $post_id, $key, $count );
}
function gt_posts_column_views( $columns ) {
    $columns['post_views'] = 'Views';
    return $columns;
}
function gt_posts_custom_column_views( $column ) {
    if ( $column === 'post_views') {
        echo gt_get_post_view();
    }
}
add_filter( 'manage_posts_columns', 'gt_posts_column_views' );
add_action( 'manage_posts_custom_column', 'gt_posts_custom_column_views' );
	

	function custom_serach_results($query){
		if($query->is_main_query() && !is_admin() && $query->is_search()){
			$query->set('post_type',array('post'));
			$query->set('posts_per_page', 12);
		}
	}
	add_action('pre_get_posts', 'custom_serach_results');

	if ( ! function_exists( 'blogpress_posted_on' ) ) :
		/**
		 * Prints HTML with meta information for the current post-date/time.
		 */
		function blogpress_posted_on() {
			$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
			if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
				$time_string = '<time class="updated" datetime="%3$s">%4$s</time>';
			}
	
			$time_string = sprintf(
				$time_string,
				esc_attr( get_the_date( DATE_W3C ) ),
				esc_html( get_the_date() ),
				esc_attr( get_the_modified_date( DATE_W3C ) ),
				esc_html( get_the_modified_date() )
			);
	
			$posted_on = sprintf(
				/* translators: %s: post date. */
				esc_html_x( ' %s', 'post date', 'blogpress' ),
				'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
			);
	
			echo '<span class="posted-on">' . $posted_on . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	
		}
	endif;