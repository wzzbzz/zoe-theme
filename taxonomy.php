<?php
global $wp_query;

$term = get_term_by( 'slug' , get_query_var( get_query_var( 'taxonomy' ) ) , get_query_var( 'taxonomy' ) );
$taxonomy = get_taxonomy( get_query_var('taxonomy' ) );

get_header();
?>
<div class="container">
	<div class="title_outer title_without_animation" data-height="200">
		<div class="title title_size_small  position_left " style="height:200px;">
			<div class="image not_responsive"></div>
										<div class="title_holder" style="padding-top:100px;height:100px;">
					<div class="container">
						<div class="container_inner clearfix">
								<div class="title_subtitle_holder">
									<h2><span><?php echo $taxonomy->labels->singular_name . ": " . $term->name;?></span></h2>
									<span class="separator small left"></span>
																	
					</div>
						</div>
					</div>
				</div>
				</div>
			</div>
</div>
<div class="container">
    <div class="container_inner default_template_holder">

		<?php echo bullpen_search_form();?>
		
	</div>
</div>
<div class="container">
    <div class="container_inner default_template_holder">
	<?php
	global $wp_query;
	
	echo bullpen_print_jobs_table( $wp_query );
	?>
</div>
	<!-- necessary for footer colors, integration with bridge theme -->

</div>
<?php get_footer();?>
