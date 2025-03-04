<?php
// funzione che filtra le territoriali in base all'utente
function my_taxonomy_query( $args, $field, $post_id ) {

    // filtro solo per chi non è amministratore
    if(is_administrator() == FALSE){
        // permetto di scegliere solo le territoriali collegati all'utente...
        $res = array();
        $territoriali = $_SESSION['territoriale'];
        foreach($territoriali as $t){
            array_push($res, get_term($t)->slug);
        }
        // modify args
        $args['slug'] = $res;
    }

    // return
    return $args;
}

add_filter('acf/fields/taxonomy/query/name=territoriale', 'my_taxonomy_query', 10, 3);
add_filter('acf/fields/taxonomy/query/name=territoriali', 'my_taxonomy_query', 10, 3);


// -----------------------------------------------------------------------------

acf_register_form(array(
	'id'		=> 'new-segnalazione-azienda',
	'post_id'	=> 'new_post',
	'new_post'	=> array(
		'post_type'		=> 'segnalazioni_aziende',
		'post_status'	=> 'publish'
	),
	'post_title'=> true,
    'updated_message' => "<div class='alert alert-success'>Segnalazione inviata!</div>",
    'submit_value' => "Invia segnalazione",
	'html_submit_button'	=> '<div class="g-recaptcha" data-sitekey="6LcE-XMUAAAAAEpa_Epg6QphAPNz6QYpQ2M0UMBE"></div><input type="submit" class="acf-button button button-primary button-large" value="%s" />',
));
