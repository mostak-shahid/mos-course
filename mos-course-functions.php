<?php
function mos_course_enqueue_scripts () {		
	wp_enqueue_style( 'timeTo', plugins_url( 'plugins/time-to/timeTo.css', __FILE__ ) );
	wp_enqueue_script( 'jquery.time-to.min', plugins_url( 'plugins/time-to/jquery.time-to.min.js', __FILE__ ), array('jquery') );

	wp_enqueue_style( 'style', plugins_url( 'css/style.css', __FILE__ ) );
	wp_enqueue_script( 'mos-course', plugins_url( 'js/mos-course.js', __FILE__ ), array('jquery') );
}
add_action( 'wp_enqueue_scripts', 'mos_course_enqueue_scripts' );
function mos_course_admin_enqueue_scripts () {
	global $pagenow, $typenow;
	// var_dump($pagenow); //post.php
	// var_dump($typenow); //course
	if ($pagenow == 'post.php' || $pagenow == 'post-new.php' || $pagenow == 'course') {
		wp_enqueue_style( 'mos-course', plugins_url( 'css/mos-course.css', __FILE__ ) );
		wp_enqueue_script( 'mos-course', plugins_url( 'js/mos-course.js', __FILE__ ), array('jquery') );
	}
}
add_action( 'admin_enqueue_scripts', 'mos_course_admin_enqueue_scripts' );

function mos_course_admin_notice__success() {
	global $pagenow, $typenow;
	// var_dump($pagenow); //edit.php
	// var_dump($typenow); //course
	if ($pagenow == 'edit.php' AND $typenow == 'course') :
    ?>
    <div class="notice notice-success is-dismissible">
        <p><strong>For using courses in your post or page use this shortcode</strong><br />[mos_course limit="-1/any_number" offset="0/any_number" category="blank/category ids seperate by ," tag="blank/category ids seperate by ," orderby="blank/DESC,ASC" order="blank/ID,author,title,name,type,date,modified,parent,rand,comment_count" author="1/any_number" container="1/0" container_class="blank/any_string" class="blank/any_string" singular="0/1" pagination="0/1"]</p>
    </div>
    <?php endif;
}
add_action( 'admin_notices', 'mos_course_admin_notice__success' );

function mos_course_func( $atts = array(), $content = '' ) {
	$html = '';
	$atts = shortcode_atts( array(
		'limit'				=> -1,
		'offset'			=> 0,
		'category'			=> '',
		'tag'				=> '',
		'orderby'			=> '',
		'order'				=> '',
		'author'			=> 1,
		'container'			=> 1,
		'container_class'	=> '',
		'class'				=> '',
		'singular'			=> 0,
		'pagination'		=> 0,
	), $atts, 'mos_course' );

	$cat = ($atts['category']) ? preg_replace('/\s+/', '', $atts['category']) : '';
	$tag = ($atts['tag']) ? preg_replace('/\s+/', '', $atts['tag']) : '';

	$args = array( 
		'post_type' 		=> 'course',
		'paged' => get_query_var('paged') ? get_query_var('paged') : 1,
	);
	if ($atts['limit'] AND $atts['limit'] != '-1') $args['posts_per_page'] = $atts['limit'];
	if ($atts['offset']) $args['offset'] = $atts['offset'];

	if ($atts['category'] OR $atts['tag']) {
		$args['tax_query'] = array();
		if ($atts['category'] AND $atts['tag']) {
			$args['tax_query']['relation'] = 'OR';
		}
		if ($atts['category']) {
			$args['tax_query'][] = array(
					'taxonomy' => 'course-category',
					'field'    => 'term_id',
					'terms'    => explode(',', $cat),
				);
		}
		if ($atts['tag']) {
			$args['tax_query'][] = array(
					'taxonomy' => 'course-tag',
					'field'    => 'term_id',
					'terms'    => explode(',', $tag),
				);
		}
	}
	if ($atts['orderby']) $args['orderby'] = $atts['orderby'];
	if ($atts['order']) $args['order'] = $atts['order'];
	if ($atts['author']) $args['author'] = $atts['order'];


	$query = new WP_Query( $args );


	if ( $query->have_posts() ) :
		if ($atts['container']) $html .= '<div class="mos-course-container ' . $atts['container_class'] . '">';
		while ( $query->have_posts() ) : $query->the_post();
			$coure_code = get_post_meta( get_the_ID(), '_course_code', true );
			$course_time = get_post_meta( get_the_ID(), '_course_time', true );
			$links = get_post_meta( get_the_ID(), '_link', true );
			$html .= '<div class="mos-course-unit ' . $atts['class'] . '">';
			$html .= '<div class="mos-course-wrapper">';
			if ($coure_code)
				$html .= '<div class="mos-course-code">' . $coure_code . '</div><!--/.mos-course-code-->';
			$html .= '<div class="mos-course-title">' . get_the_title() . '</div><!--/.mos-course-title-->';
			if (has_post_thumbnail()):
				$html .= '<div class="mos-course-image">' . get_the_post_thumbnail() . '</div><!--/.mos-course-image-->';
			endif;
			$html .= '<div class="mos-course-content">' . get_the_content() . '</div><!--/.mos-course-content-->';
			if ($atts['singular']) 
				$html .= '<a class="course-link" href="'.get_the_permalink().'">Read More</a>';
			if ($links) : 
				$html .= '<div class="mos-course-link">';
				 //var_dump($links);
				foreach ($links as $link) {
					if ($link[url] AND $link[title]) {
						$html .= '<a class="course-link" href="'.$link[url].'">'.$link[title].'</a>';
					}
				}
				$html .= '</div><!--/.mos-course-link-->';
			endif;
			if ($course_time)
				$html .= '<div class="mos-course-time">' . $course_time . '</div><!--/.mos-course-time-->';			
			$html .= '</div><!--/.mos-course-wrapper-->';
			$html .= '</div><!--/.mos-course-unit-->';
		endwhile;
		if ($atts['container']) $html .= '</div><!--/.mos-course-container-->';
		wp_reset_postdata();
		if ($atts['pagination']) :
		    $html .= '<div class="pagination-wrapper course-pagination">'; 
		        $html .= '<nav class="navigation pagination" role="navigation">';
		            $html .= '<div class="nav-links">'; 
		            $big = 999999999; // need an unlikely integer
		            $html .= paginate_links( array(
		                'base' => str_replace( $big, '%#%', get_pagenum_link( $big ) ),
		                'format' => '?paged=%#%',
		                'current' => max( 1, get_query_var('paged') ),
		                'total' => $query->max_num_pages,
		                'prev_text'          => __('Prev'),
		                'next_text'          => __('Next')
		            ) );
		            $html .= '</div>';
		        $html .= '</nav>';
		    $html .= '</div>';
		endif;
	endif;


	//var_dump($args);
	return $html;
}
add_shortcode( 'mos_course', 'mos_course_func' );