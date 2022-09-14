<?php
// create new post type for Podcasts, Press Statements
function we_create_init(){
    $labels = array(
		'name'               => __( 'Podcasts', 'we_create' ),
		'singular_name'      => __( 'Podcast', 'we_create' ),
		'menu_name'          => __( 'Podcasts', 'we_create' ),
		'name_admin_bar'     => __( 'Podcasts', 'we_create' ),
		'add_new'            => __( 'Add New', 'we_create' ),
		'add_new_item'       => __( 'Add New Podcast', 'we_create' ),
		'new_item'           => __( 'New Podcast', 'we_create' ),
		'edit_item'          => __( 'Edit Podcast', 'we_create' ),
		'view_item'          => __( 'View Podcast', 'we_create' ),
		'all_items'          => __( 'All Podcasts', 'we_create' ),
		'search_items'       => __( 'Search Podcasts', 'we_create' ),
		'parent_item_colon'  => __( 'Parent Podcasts:', 'we_create' ),
		'not_found'          => __( 'No Podcasts found.', 'we_create' ),
		'not_found_in_trash' => __( 'No Podcasts found in Trash.', 'we_create' )
	);
	$args = array(
		'labels'             => $labels,
        'description'        => __( 'A post type for BFT Podcasts.', 'we_create' ),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
        'show_in_rest'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'podcasts'),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => 4,
        'menu_icon'           =>'dashicons-media-audio',
        'supports'           => array( 'title','thumbnail' ),
        
	);

	
	register_post_type( 'podcast', $args );
    
	$labels = array(
		'name'               => __( 'Statements', 'we_create' ),
		'singular_name'      => __( 'Statement', 'we_create' ),
		'menu_name'          => __( 'Statements', 'we_create' ),
		'name_admin_bar'     => __( 'Statements', 'we_create' ),
		'add_new'            => __( 'Add New', 'we_create' ),
		'add_new_item'       => __( 'Add New Statement', 'we_create' ),
		'new_item'           => __( 'New Statement', 'we_create' ),
		'edit_item'          => __( 'Edit Statement', 'we_create' ),
		'view_item'          => __( 'View Statement', 'we_create' ),
		'all_items'          => __( 'All Statements', 'we_create' ),
		'search_items'       => __( 'Search Statements', 'we_create' ),
		'parent_item_colon'  => __( 'Parent Statements:', 'we_create' ),
		'not_found'          => __( 'No Statements found.', 'we_create' ),
		'not_found_in_trash' => __( 'No Statements found in Trash.', 'we_create' )
	);
	$args = array(
		'labels'             => $labels,
        'description'        => __( 'A post type for BFT Statements.', 'we_create' ),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
        'show_in_rest'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'statements','with_front' => false ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => 4,
        'menu_icon'           =>'dashicons-media-document',
        'supports'           => array( 'title','thumbnail' ),
        
	);

	
	register_post_type( 'statement', $args );

	
	


    }
    
    add_action( 'init', 'we_create_init' );

	