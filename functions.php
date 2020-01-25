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

function sm_query_vars( $aVars )
{
	$aVars[] = "skipper";
	return $aVars;
}

function sm_rewrite_rules_query( $aRules )
{
	$aNewRules = array( 'sejltogter/?$' => 'index.php?pagename=sejltogter&skipper=$matches[1]' );
	$aRules = $aNewRules + $aRules;
	return $aRules;
}

//Handle data retrieved from a social network profile
function oa_social_login_store_extended_data( $user_data, $identity )
{
	// $user_data is an object that represents the newly added user
	// The format is similar to the data returned by $user_data = get_userdata ($user_id);

	// $identity is an object that contains the full social network profile

	//Example to store the gender
	update_user_meta( $user_data->ID, 'gender', $identity->gender );
}

//Use the email address as user_login
function oa_social_login_set_email_as_user_login( $user_fields )
{
	if ( !empty ( $user_fields['user_email'] ) ) {
		if ( !username_exists( $user_fields['user_email'] ) ) {
			$user_fields['user_login'] = $user_fields['user_email'];
		}
	}
	return $user_fields;
}

//Set custom roles for new users
function oa_social_login_set_new_user_role_url_based( $user_role )
{
	//Read the current url
	$current_url = oa_social_login_get_current_url();

	//For example: https://www.your-website.com/employer-signup/
	if ( strpos( $current_url, '/registrer-som-gast' ) !== false ) {
		return 'gast';
	}

	//For example: http://www.your-website.com/candidate-signup/
	if ( strpos( $current_url, '/registrer-skipper' ) !== false ) {
		return 'skipper';
	}

	//Default
	return $user_role;
}


add_filter( 'query_vars', 'sm_query_vars' );
add_filter( 'rewrite_rules_array', 'sm_rewrite_rules_query' );
add_action( 'wp_enqueue_scripts', 'my_theme_scripts_function' );
add_filter( 'rewrite_rules_array', 'sm_rewrite_rules_gast', 10, 10 );
add_filter( 'rewrite_rules_array', 'sm_rewrite_rules_skipper', 10, 10 );

//This action is called whenever Social Login adds a new user
add_action( 'oa_social_login_action_after_user_insert', 'oa_social_login_store_extended_data', 10, 2 );
//This filter is applied to new users
add_filter( 'oa_social_login_filter_new_user_fields', 'oa_social_login_set_email_as_user_login' );
//This filter is applied to the roles of new users
add_filter( 'oa_social_login_filter_new_user_role', 'oa_social_login_set_new_user_role_url_based' );



