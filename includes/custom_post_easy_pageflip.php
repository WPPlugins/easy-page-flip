<?php

	// Register - Post Type | Page Flip

	function cpt_easy_pageflip() {
		$labels = array(
			'name' 					=> __( 'Magazines' , 'easy-page-flip' ),
			'singular_name' 		=> __( 'Magazine' , 'easy-page-flip'  ),
			'add_new' 				=> __( 'Add New' , 'easy-page-flip'  ),
			'add_new_item'			=> __( 'Add New Magazine' , 'easy-page-flip'  ),
			'edit_item' 			=> __( 'Edit Magazine' , 'easy-page-flip'  ),
			'new_item' 				=> __( 'Add New Magazine' , 'easy-page-flip'  ),
			'view_item' 			=> __( 'View Magazine' , 'easy-page-flip'  ),
			'search_items' 			=> __( 'Search Magazines' , 'easy-page-flip'  ),
			'not_found' 			=> __( 'Not found' , 'easy-page-flip'  ),
			'not_found_in_trash' 	=> __( 'Not found in Trash' , 'easy-page-flip'  )
		);
		$args = array(
			'label'                 => __( 'Magazines' , 'easy-page-flip' ),
			'labels'                => $labels,
			'supports'              => array( 'title', 'editor', 'thumbnail'),
			'hierarchical'          => false,
			'public'                => true,
			'show_ui'               => true,
			'show_in_menu'          => true,
			'menu_position'         => 5,
			'register_meta_box_cb'	=> 'pageflip_meta_box',
			'menu_icon'             => 'dashicons-media-interactive',
			'show_in_admin_bar'     => true,
			'show_in_nav_menus'     => true,
			'can_export'            => true,
			'has_archive'           => false,		
			'exclude_from_search'   => true,
			'publicly_queryable'    => true,
			'capability_type'       => 'post',
		);
		register_post_type( 'pageflip', $args );
		flush_rewrite_rules();
	}
	add_action( 'init', 'cpt_easy_pageflip', 0 );