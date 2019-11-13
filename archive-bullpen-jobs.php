<?php get_header(); ?>
<div class="title_outer title_without_animation" data-height="200">
    <div class="title title_size_small  position_left " style="height:200px;">
        <div class="image not_responsive"></div>
        <div class="title_holder" style="padding-top:100px;height:100px;">
            <div class="container">
                <div class="container_inner clearfix">
                    <div class="title_subtitle_holder">
                        <h2><span>Jobs</span></h2>
                        <span class="separator small left"></span>
                                                                
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="container_inner default_template_holder">
		<div style="">
		<?php echo bullpen_search_form();?>
		</div>
	</div>
</div>
<div class="container">
    <div class="container_inner default_template_holder">
<?php
$atts = shortcode_atts( array(
		'limit'     => 100,
		'show_date' => false,
		'location'  => null,
		'category'  => null,
		'title'     => null,
		'columns'   => null,
		'class'     => null,
	), $atts, 'bullpen_jobs' );

	// Sanitize Inputs for Security Purposes
	$atts['limit']     = absint( $atts['limit'] );
	$atts['show_date'] = (bool) $atts['show_date'];
	$atts['location']  = esc_attr( $atts['location'] );
	$atts['category']  = esc_attr( $atts['category'] );
	$atts['title']     = esc_attr( $atts['title'] );
	$atts['columns']   = absint( $atts['columns'] );		
	$atts['class']     = esc_attr( $atts['class'] );

	// If columns, make a class attribute. Also prevent a 
	// ridiculous number of columns.
	if ( $atts['columns'] && !$atts['class'] ) {
		if ( $atts['columns'] == 2 )
			$atts['class'] = '2-columns';
		if ( $atts['columns'] == 3 )
			$atts['class'] = '3-columns';
		if ( $atts['columns'] > 3 )
			$atts['class'] = '4-columns';
	}

	
echo bullpen_list_jobs( $atts );

?>
    </div>
</div>
<?php get_footer(); ?>