<?php
//Courses
add_action( 'init', 'mos_course_init' );
function mos_course_init() {
	$labels = array(
		'name'               => _x( 'Courses', 'post type general name', 'excavator-template' ),
		'singular_name'      => _x( 'Course', 'post type singular name', 'excavator-template' ),
		'menu_name'          => _x( 'Courses', 'admin menu', 'excavator-template' ),
		'name_admin_bar'     => _x( 'Course', 'add new on admin bar', 'excavator-template' ),
		'add_new'            => _x( 'Add New', 'course', 'excavator-template' ),
		'add_new_item'       => __( 'Add New Course', 'excavator-template' ),
		'new_item'           => __( 'New Course', 'excavator-template' ),
		'edit_item'          => __( 'Edit Course', 'excavator-template' ),
		'view_item'          => __( 'View Course', 'excavator-template' ),
		'all_items'          => __( 'All Courses', 'excavator-template' ),
		'search_items'       => __( 'Search Courses', 'excavator-template' ),
		'parent_item_colon'  => __( 'Parent Courses:', 'excavator-template' ),
		'not_found'          => __( 'No Courses found.', 'excavator-template' ),
		'not_found_in_trash' => __( 'No Courses found in Trash.', 'excavator-template' )
	);

	$args = array(
		'labels'             => $labels,
        'description'        => __( 'Description.', 'excavator-template' ),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'course' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => 6,
		'menu_icon' => 'dashicons-book',
		'supports'           => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields', ),
	);

	register_post_type( 'course', $args );
}
add_action( 'after_switch_theme', 'flush_rewrite_rules' );
