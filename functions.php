<?php
add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );
function my_theme_enqueue_styles()
{
	$parent_style = 'parent-style';

	wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
	wp_enqueue_style( 'child-style',
		get_stylesheet_directory_uri() . '/style.css',
		array( $parent_style ),
		wp_get_theme()->get( 'Version' )
	);
}

function my_theme_scripts_function()
{

	wp_enqueue_script( 'sailmore-um', get_stylesheet_directory_uri() . '/js/sailmore-um.js' );

}

function sm_rewrite_rules_gast( $rules )
{
	$newrules = array();

	$newrules['um-download/([^/]+)/([^/]+)/([^/]+)/([^/]+)/?$'] = 'index.php?um_action=download&um_form=$matches[1]&um_field=$matches[2]&um_user=$matches[3]&um_verify=$matches[4]';


	// Server page id: 2710
	// $user_page_id = 198;
	$user_page_id = 2710;
	$user = get_post( $user_page_id );

	if ( isset( $user->post_name ) ) {

		$user_slug = $user->post_name;

		$add_lang_code = '';
		$language_code = '';

		if ( function_exists( 'icl_object_id' ) || function_exists( 'icl_get_current_language' ) ) {

			if ( function_exists( 'icl_get_current_language' ) ) {
				$language_code = icl_get_current_language();
			} elseif ( function_exists( 'icl_object_id' ) && defined( 'ICL_LANGUAGE_CODE' ) ) {
				$language_code = ICL_LANGUAGE_CODE;
			}

			// User page translated slug
			$lang_post_id = icl_object_id( $user->ID, 'post', FALSE, $language_code );
			$lang_post_obj = get_post( $lang_post_id );
			if ( isset( $lang_post_obj->post_name ) ) {
				$user_slug = $lang_post_obj->post_name;
			}

			if ( $language_code != icl_get_default_language() ) {
				$add_lang_code = $language_code;
			}

		}

		$newrules[$user_slug . '/([^/]+)/?$'] = 'index.php?page_id=' . $user_page_id . '&um_user=$matches[1]&lang=' . $add_lang_code;
	}

	return $newrules + $rules;
}

function sm_rewrite_rules_skipper( $rules )
{
	$newrules = array();

	$newrules['um-download/([^/]+)/([^/]+)/([^/]+)/([^/]+)/?$'] = 'index.php?um_action=download&um_form=$matches[1]&um_field=$matches[2]&um_user=$matches[3]&um_verify=$matches[4]';


	// Server page id: 2777
	// $user_page_id = 2634;
	$user_page_id = 2777;
	$user = get_post( $user_page_id );

	if ( isset( $user->post_name ) ) {

		$user_slug = $user->post_name;

		$add_lang_code = '';
		$language_code = '';

		if ( function_exists( 'icl_object_id' ) || function_exists( 'icl_get_current_language' ) ) {

			if ( function_exists( 'icl_get_current_language' ) ) {
				$language_code = icl_get_current_language();
			} elseif ( function_exists( 'icl_object_id' ) && defined( 'ICL_LANGUAGE_CODE' ) ) {
				$language_code = ICL_LANGUAGE_CODE;
			}

			// User page translated slug
			$lang_post_id = icl_object_id( $user->ID, 'post', FALSE, $language_code );
			$lang_post_obj = get_post( $lang_post_id );
			if ( isset( $lang_post_obj->post_name ) ) {
				$user_slug = $lang_post_obj->post_name;
			}

			if ( $language_code != icl_get_default_language() ) {
				$add_lang_code = $language_code;
			}

		}

		$newrules[$user_slug . '/([^/]+)/?$'] = 'index.php?page_id=' . $user_page_id . '&um_user=$matches[1]&lang=' . $add_lang_code;
	}

	return $newrules + $rules;
}

add_action( 'wp_enqueue_scripts', 'my_theme_scripts_function' );
add_filter( 'rewrite_rules_array', 'sm_rewrite_rules_gast', 10, 10 );
add_filter( 'rewrite_rules_array', 'sm_rewrite_rules_skipper', 10, 10 );



