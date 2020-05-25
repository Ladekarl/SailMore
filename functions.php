<?php
add_action('wp_enqueue_scripts', 'my_theme_enqueue_styles');
function my_theme_enqueue_styles()
{
	$parent_style = 'parent-style';

	wp_enqueue_style($parent_style, get_template_directory_uri() . '/style.css');
	wp_enqueue_style(
		'child-style',
		get_stylesheet_directory_uri() . '/style.css',
		array($parent_style),
		wp_get_theme()->get('Version')
	);
}

function my_theme_scripts_function()
{
	wp_enqueue_script('sailmore-um', get_stylesheet_directory_uri() . '/js/sailmore-um.js');
}

function sm_rewrite_rules_gast($rules)
{
	$newrules = array();

	$newrules['um-download/([^/]+)/([^/]+)/([^/]+)/([^/]+)/?$'] = 'index.php?um_action=download&um_form=$matches[1]&um_field=$matches[2]&um_user=$matches[3]&um_verify=$matches[4]';


	// Server page id: 2710
	// $user_page_id = 198;
	$user_page_id = 2710;
	$user = get_post($user_page_id);

	if (isset($user->post_name)) {

		$user_slug = $user->post_name;

		$add_lang_code = '';
		$language_code = '';

		if (function_exists('icl_object_id') || function_exists('icl_get_current_language')) {

			if (function_exists('icl_get_current_language')) {
				$language_code = icl_get_current_language();
			} elseif (function_exists('icl_object_id') && defined('ICL_LANGUAGE_CODE')) {
				$language_code = ICL_LANGUAGE_CODE;
			}

			// User page translated slug
			$lang_post_id = icl_object_id($user->ID, 'post', FALSE, $language_code);
			$lang_post_obj = get_post($lang_post_id);
			if (isset($lang_post_obj->post_name)) {
				$user_slug = $lang_post_obj->post_name;
			}

			if ($language_code != icl_get_default_language()) {
				$add_lang_code = $language_code;
			}
		}

		$newrules[$user_slug . '/([^/]+)/?$'] = 'index.php?page_id=' . $user_page_id . '&um_user=$matches[1]&lang=' . $add_lang_code;
	}

	return $newrules + $rules;
}

function sm_rewrite_rules_skipper($rules)
{
	$newrules = array();

	$newrules['um-download/([^/]+)/([^/]+)/([^/]+)/([^/]+)/?$'] = 'index.php?um_action=download&um_form=$matches[1]&um_field=$matches[2]&um_user=$matches[3]&um_verify=$matches[4]';


	// Server page id: 2777
	// $user_page_id = 2634;
	$user_page_id = 2777;
	$user = get_post($user_page_id);

	if (isset($user->post_name)) {

		$user_slug = $user->post_name;

		$add_lang_code = '';
		$language_code = '';

		if (function_exists('icl_object_id') || function_exists('icl_get_current_language')) {

			if (function_exists('icl_get_current_language')) {
				$language_code = icl_get_current_language();
			} elseif (function_exists('icl_object_id') && defined('ICL_LANGUAGE_CODE')) {
				$language_code = ICL_LANGUAGE_CODE;
			}

			// User page translated slug
			$lang_post_id = icl_object_id($user->ID, 'post', FALSE, $language_code);
			$lang_post_obj = get_post($lang_post_id);
			if (isset($lang_post_obj->post_name)) {
				$user_slug = $lang_post_obj->post_name;
			}

			if ($language_code != icl_get_default_language()) {
				$add_lang_code = $language_code;
			}
		}

		$newrules[$user_slug . '/([^/]+)/?$'] = 'index.php?page_id=' . $user_page_id . '&um_user=$matches[1]&lang=' . $add_lang_code;
	}

	return $newrules + $rules;
}

function sm_query_vars($aVars)
{
	$aVars[] = "skipper";
	$aVars[] = "past";
	return $aVars;
}

function sm_rewrite_rules_query($aRules)
{
	$aNewRules = array('sejltogter/?$' => 'index.php?pagename=sejltogter&skipper=$matches[1]');
	$aRules = $aNewRules + $aRules;
	return $aRules;
}

//Handle data retrieved from a social network profile
function oa_social_login_store_extended_data($user_data, $identity)
{
	// $user_data is an object that represents the newly added user
	// The format is similar to the data returned by $user_data = get_userdata ($user_id);

	// $identity is an object that contains the full social network profile

	//Example to store the gender
	update_user_meta($user_data->ID, 'gender', $identity->gender);
}

//Use the email address as user_login
function oa_social_login_set_email_as_user_login($user_fields)
{
	if (!empty($user_fields['user_email'])) {
		if (!username_exists($user_fields['user_email'])) {
			$user_fields['user_login'] = $user_fields['user_email'];
		}
	}
	return $user_fields;
}

//Set custom roles for new users
function oa_social_login_set_new_user_role_url_based($user_role)
{
	//Read the current url
	$current_url = oa_social_login_get_current_url();

	//For example: https://www.your-website.com/employer-signup/
	if (strpos($current_url, '/registrer-som-gast') !== false) {
		return 'gast';
	}

	//For example: http://www.your-website.com/candidate-signup/
	if (strpos($current_url, '/registrer-skipper') !== false) {
		return 'skipper';
	}

	//Default
	return $user_role;
}


add_filter('query_vars', 'sm_query_vars');
add_filter('rewrite_rules_array', 'sm_rewrite_rules_query');
add_action('wp_enqueue_scripts', 'my_theme_scripts_function');
add_filter('rewrite_rules_array', 'sm_rewrite_rules_gast', 10, 10);
add_filter('rewrite_rules_array', 'sm_rewrite_rules_skipper', 10, 10);

//This action is called whenever Social Login adds a new user
add_action('oa_social_login_action_after_user_insert', 'oa_social_login_store_extended_data', 10, 2);
//This filter is applied to new users
add_filter('oa_social_login_filter_new_user_fields', 'oa_social_login_set_email_as_user_login');
//This filter is applied to the roles of new users
add_filter('oa_social_login_filter_new_user_role', 'oa_social_login_set_new_user_role_url_based');


/**
 * Add new predefined field "Profile Photo" in UM Form Builder.
 */
add_filter("um_predefined_fields_hook", "um_predefined_fields_hook_profile_photo", 99999, 1);
function um_predefined_fields_hook_profile_photo($arr)
{


	$arr['profile_photo'] = array(
		'title' => __('Profile Photo', 'ultimate-member'),
		'metakey' => 'profile_photo',
		'type' => 'image',
		'label' => __('Change your profile photo', 'ultimate-member'),
		'upload_text' => __('Upload your photo here', 'ultimate-member'),
		'icon' => 'um-faicon-camera',
		'crop' => 1,
		'max_size' => (UM()->options()->get('profile_photo_max_size')) ? UM()->options()->get('profile_photo_max_size') : 999999999,
		'min_width' => str_replace('px', '', UM()->options()->get('profile_photosize')),
		'min_height' => str_replace('px', '', UM()->options()->get('profile_photosize')),
	);

	$arr['cover_photo'] = array(
		'title' => __('Cover Photo', 'ultimate-member'),
		'metakey' => 'cover_photo',
		'type' => 'image',
		'label' => __('Change your cover photo', 'ultimate-member'),
		'upload_text' => __('Upload your photo here', 'ultimate-member'),
		'icon' => 'um-faicon-camera',
		'crop' => 1,
		'max_size' => (UM()->options()->get('cover_photo_max_size')) ? UM()->options()->get('cover_photo_max_size') : 999999999,
		'min_width' => str_replace('px', '', UM()->options()->get('cover_photosize')),
		'min_height' => str_replace('px', '', UM()->options()->get('cover_photosize')),
	);

	return $arr;
}

/**
 *  Multiply Profile Photo with different sizes
 */
add_action('um_registration_set_extra_data', 'um_registration_set_profile_photo', 9999, 2);
function um_registration_set_profile_photo($user_id, $args)
{

	if (empty($args['custom_fields'])) return;

	if (!isset($args['form_id'])) return;

	if (!isset($args['profile_photo']) || empty($args['profile_photo'])) return;

	// apply this to specific form
	//if( $args['form_id'] != 12345 ) return; 


	$files = array();

	$fields = unserialize($args['custom_fields']);

	$user_basedir = UM()->uploader()->get_upload_user_base_dir($user_id, true);

	$profile_photo = get_user_meta($user_id, 'profile_photo', true);
	$cover_photo = get_user_meta($user_id, 'cover_photo', true);

	$image_path = $user_basedir . DIRECTORY_SEPARATOR . $profile_photo;
	$image_path_cover = $user_basedir . DIRECTORY_SEPARATOR . $cover_photo;
	$image = wp_get_image_editor($image_path);
	$image_cover = wp_get_image_editor($image_path_cover);
	$file_info = wp_check_filetype_and_ext($image_path, $profile_photo);
	$file_info_cover = wp_check_filetype_and_ext($image_path_cover, $cover_photo);
	$ext = $file_info['ext'];
	$ext_cover = $file_info_cover['ext'];
	$new_image_name = str_replace($profile_photo,  "profile_photo." . $ext, $image_path);
	$new_image_name_cover = str_replace($cover_photo,  "cover_photo." . $ext_cover, $image_path_cover);

	$sizes = UM()->options()->get('photo_thumb_sizes');

	$quality = UM()->options()->get('image_compression');

	if (!is_wp_error($image)) {

		$max_w = UM()->options()->get('image_max_width');
		if ($src_w > $max_w) {
			$image->resize($max_w, $src_h);
		}

		$image->save($new_image_name);

		$image->set_quality($quality);

		$sizes_array = array();

		foreach ($sizes as $size) {
			$sizes_array[] = array('width' => $size);
		}

		$image->multi_resize($sizes_array);

		delete_user_meta($user_id, 'synced_profile_photo');
		update_user_meta($user_id, 'profile_photo', "profile_photo.{$ext}");
		@unlink($image_path);
	}

	if (!is_wp_error($image_cover)) {

		$max_w = UM()->options()->get('image_max_width');
		if ($src_w > $max_w) {
			$image_cover->resize($max_w, $src_h);
		}

		$image_cover->save($new_image_name_cover);

		$image_cover->set_quality($quality);

		$sizes_array = array();

		foreach ($sizes as $size) {
			$sizes_array[] = array('width' => $size);
		}

		$image_cover->multi_resize($sizes_array);

		delete_user_meta($user_id, 'synced_cover_photo');
		update_user_meta($user_id, 'cover_photo', "cover_photo.{$ext_cover}");
		@unlink($image_path_cover);
	}
}
