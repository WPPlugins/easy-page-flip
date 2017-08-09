<?php
/*
	Plugin Name: Easy Page Flip
	Version: 1.2.1.1
	Description: Easy Page Flip is a plugin where you create a Virtual Magazine in few clicks, this plugin has with base <a href="http://builtbywill.com/code/booklet/" target="_blank">jQuery Booklet</a> and is compatible with <a href="http://wordpress.org/plugins/wp-pagenavi/" target="_blank">WP-PageNavi</a>
	Author: CHR Designer
	Author URI: http://www.chrdesigner.com
	Plugin URI: http://www.chrdesigner.com/plugin/easy-pageflip.zip
	License: A slug describing license associated with the plugin (usually GPL2)
	Text Domain: easy-page-flip
	Domain Path: /languages/
*/

load_plugin_textdomain( 'easy-page-flip', false, plugin_basename( dirname( __FILE__ ) ) . '/languages/' );

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

add_image_size( 'chr-imagem-revista', 280, 380, true  );

add_filter( 'use_default_gallery_style', '__return_false' );


/**
 * Register default styles and scripts
 */

// Script
wp_register_script('script-easing', plugin_dir_url( __FILE__ ) . 'assets/js/jquery.easing.min.js', array('jquery', 'jquery-ui-core', 'jquery-ui-draggable'), '1.4.0', true );
wp_register_script('script-booklet', plugin_dir_url( __FILE__ ) . 'assets/js/jquery.booklet.latest.min.js', array('jquery'), '1.4.4', true);

// Style
wp_register_style( 'style-booklet', plugin_dir_url( __FILE__ ) . 'assets/css/jquery.booklet.latest.css' );
wp_register_style( 'style-easy-pageflip', plugin_dir_url( __FILE__ ) . 'assets/css/style-easy-pageflip.css' );
wp_register_style( 'style-easy-pageflip-admin', plugin_dir_url( __FILE__ ) . 'admin/assets/css/style.min.css' );
wp_register_style( 'style-epc-admin', plugin_dir_url( __FILE__ ) . 'admin/assets/css/style.epc.admin.css' );

// Add Action
add_action( 'wp_enqueue_scripts', 'load_epf_scripts');

function load_epf_scripts() {

	global $post;

    if ( !is_admin() || is_singular('pageflip') ) {
    	
    	// jQuery Easing Plugin - http://gsgd.co.uk/sandbox/jquery/easing
		wp_enqueue_script('script-easing');
		
		// Booklet - https://github.com/builtbywill/Booklet
		wp_enqueue_script('script-booklet');
		wp_enqueue_style( 'style-booklet' );

		// Default Style
		wp_enqueue_style( 'style-easy-pageflip' );

	}

}

/**
 * Create the Post Type(s)
 */

require_once('includes/custom_post_easy_pageflip.php');
require_once('includes/pageflip_meta_box.php');

function easy_pageflip_edit_columns( $columns ) {
    $columns = array(
        'cb' 				=> '<input type="checkbox" />',
        'featured_image'	=> __( 'Featured Image', 'easy-page-flip' ),
        'title'				=> __( 'Title', 'easy-page-flip' ),
        'pageflip_gallery'	=> __( 'Gallery', 'easy-page-flip' ),
    );
    return $columns;
}
add_filter( 'manage_edit-pageflip_columns', 'easy_pageflip_edit_columns' );

/**
 * Promotor custom columns content.
 */
function easy_pageflip_posts_columns( $column, $post_id ) {
    global $post;
    switch ( $column ) {
        case 'featured_image':
            $sc_carousel_thumb = get_the_post_thumbnail(  $post_id, 'thumbnail' );
            echo sprintf( '<a href="%1$s" title="%2$s">%3$s</a>', admin_url( 'post.php?post=' . $post_id . '&action=edit' ), get_the_title(), $sc_carousel_thumb );
            break;

        case 'pageflip_gallery' :
        	$chr_get_ids = get_the_content( $post_id );
			preg_match('/\[gallery.*ids=.(.*).\]/', $chr_get_ids, $chr_ids);
			echo '<dl class="gallery-pageflip">';
			foreach ( explode( ',', $chr_ids[1] ) as $image_id ) {
				echo '<dd><figure>' . wp_get_attachment_image( $image_id, 'thumbnail' ) . '</figure></dd>';
			}
			echo '</dl>';
			break;
    }
}
add_action( 'manage_posts_custom_column', 'easy_pageflip_posts_columns', 1, 2 );

/**
 * Create Page/Single to Front-end
 */

require plugin_dir_path( __FILE__ ) . 'includes/content-pageflip-single.php';
require plugin_dir_path( __FILE__ ) . 'includes/content-pageflip-list.php';

/*
 * Add Custom CSS Field in Admin Page and Post Type
 */

add_action('admin_head', 'epf_admin_css');

function epf_admin_css() {
    global $post_type;
    if ( ($_GET['post_type'] == 'pageflip') || ($post_type == 'pageflip') ) :
        wp_enqueue_style( 'style-easy-pageflip-admin' );
    endif;
}

add_action( 'admin_enqueue_scripts', 'chr_admin_style_epc' );

function chr_admin_style_epc() {
    wp_enqueue_style( 'style-epc-admin' );
}

/*
 * Add mce_buttons EPF
 */

function epf_chr_add_buttons($plugin_array) {
	$plugin_array['chrEpf'] = plugins_url( '/admin/assets/tinymce/chrEpf-tinymce.js' , __FILE__ );
	return $plugin_array;
}

function epf_chr_register_buttons($buttons) {
	array_push( $buttons, 'showEpf' );
	return $buttons;
}
add_action( 'init', 'epf_chr_buttons' );

function epf_chr_buttons() {
	add_filter('mce_external_plugins', 'epf_chr_add_buttons');
    add_filter('mce_buttons', 'epf_chr_register_buttons');
}