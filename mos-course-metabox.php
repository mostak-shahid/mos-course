<?php 
function mos_course_metabox () {
	//add_meta_box( $id, $title, $callback, $screen = null, $context = 'advanced', $priority = 'default', $callback_args = null );

	add_meta_box( 
		'_mos_course_metabox', 
		'Course Details', 
		'mos_course_metabox_html', 
		array('course'),
		'normal', //advanced, normal, side
		$priority = 'high' //high, core, low, default
		/*$callback_args = null */
	);
}
add_action( 'add_meta_boxes', 'mos_course_metabox' );

function mos_course_metabox_html ($post) { 
	// Add a nonce field so we can check for it later.
	wp_nonce_field( 'mosacademy_save_custom_metabox', 'mos_course_metabox_nonce' );
	//$basic_field = get_post_meta( $post->id, '_basic_field', true )
	//$basic_field = (get_post_meta( $post->ID, '_basic_field', true )) ? get_post_meta( $post->ID, '_basic_field', true ) : '';
	$course_code = (get_post_meta( $post->ID, '_course_code', true )) ? get_post_meta( $post->ID, '_course_code', true ) : '';
	$course_time = (get_post_meta( $post->ID, '_course_time', true )) ? get_post_meta( $post->ID, '_course_time', true ) : '';
	$link = (get_post_meta( $post->ID, '_link', true )) ? get_post_meta( $post->ID, '_link', false ) : '';	
	?>
	<!-- <div class="unit">
		<label class="post-attributes-label" for="basic_field">Basic Field</label>
		<input class="widefat" type="text" id="basic_field" name="_basic_field" placeholder="Basic Field" value="<?php echo $basic_field; ?>">		
	</div> -->
	<div class="unit">
		<div class="grid">
			<label class="post-attributes-label" for="course_code">Course Code</label>
			<input class="widefat" type="text" id="course_code" name="_course_code" placeholder="Course Code" value="<?php echo $course_code; ?>">
		</div>	
	</div>
	<div class="unit">
		<div class="grid">
			<label class="post-attributes-label" for="course_time">Course Start From</label>
			<input class="widefat" type="datetime-local" id="course_time" name="_course_time" placeholder="Course Code" value="<?php echo $course_time; ?>">
		</div>	
	</div>
	<div class="unit unit-0">
		<div class="grid">
			<label class="post-attributes-label" for="link_title">Link Title</label>
			<input class="widefat" type="text" id="link_title_0" name="_link[0][title]" placeholder="Link Title" value="<?php echo @$link[0][0][title]; ?>">			
		</div>
		<div class="grid">
			<label class="post-attributes-label" for="link_url">Link URL</label>
			<input class="widefat" type="text" id="link_url_0" name="_link[0][url]" placeholder="Link URL" value="<?php echo @$link[0][0][url]; ?>">			
		</div>
		<!-- <div class="grid action">
					<label class="post-attributes-label" for="remove">Remove</label>
					<a class="link-remove" data-id="0" id="0" href="javascript:void(0)"><i class="dashicons dashicons-no"></i></a>
				</div> -->		
	</div>
	<div class="unit unit-1">
		<div class="grid">
			<label class="post-attributes-label" for="link_title">Link Title</label>
			<input class="widefat" type="text" id="link_title_1" name="_link[1][title]" placeholder="Link Title" value="<?php echo @$link[0][1][title]; ?>">			
		</div>
		<div class="grid">
			<label class="post-attributes-label" for="link_url">Link URL</label>
			<input class="widefat" type="text" id="link_url_1" name="_link[1][url]" placeholder="Link URL" value="<?php echo @$link[0][1][url]; ?>">			
		</div>	
		<!-- <div class="grid action">
				<label class="post-attributes-label" for="remove">Remove</label>
				<a class="link-remove" data-id="1" id="1" href="javascript:void(0)"><i class="dashicons dashicons-no"></i></a>
			</div> -->	
	</div>
	<!-- <div class="unit">
		<div class="grid">
			<input name="save" type="button" class="button button-primary button-large" id="link-add" value="Add More">
		</div>	
	</div> -->
	<?php
}
function mos_course_metabox_update ($post_ID) {

	if ( ! isset( $_POST['mos_course_metabox_nonce'] ) ) {
		return;
	}

	if ( ! wp_verify_nonce( $_POST['mos_course_metabox_nonce'], 'mosacademy_save_custom_metabox' ) ) {
		return;
	}

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

 	// Check the user's permissions.
	if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {

		if ( ! current_user_can( 'edit_page', $post_id ) ) {
			return;
		}

	} else {

		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}
	}

	//$basic_field = sanitize_text_field( $_POST['_basic_field'] );
	$course_code = sanitize_text_field( $_POST['_course_code'] );
	$course_time = $_POST['_course_time'];
	$link = $_POST['_link'] ;

	//update_post_meta( $post_ID, '_basic_field', $basic_field );
	update_post_meta( $post_ID, '_course_code', $course_code );
	update_post_meta( $post_ID, '_course_time', $course_time );
	update_post_meta( $post_ID, '_link', $link );
}
add_action( 'save_post', 'mos_course_metabox_update' );