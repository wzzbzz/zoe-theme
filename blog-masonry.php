<?php 
/*
Template Name: Blog Masonry
*/ 
?>
<?php get_header(); ?>
<?php
$qode_template_name = bridge_qode_return_template_name();
$bridge_qode_id = bridge_qode_get_page_id();
$qode_template_name = get_page_template_slug($bridge_qode_id);
$bridge_qode_category = get_post_meta($bridge_qode_id, "qode_choose-blog-category", true);
$bridge_qode_post_number = get_post_meta($bridge_qode_id, "qode_show-posts-per-page", true);
$bridge_qode_page_object = get_post( $bridge_qode_id );
$bridge_qode_content = $bridge_qode_page_object->post_content;
$bridge_qode_content = apply_filters( 'the_content', $bridge_qode_content );
if ( get_query_var('paged') ) { $bridge_qode_paged = get_query_var('paged'); }
elseif ( get_query_var('page') ) { $bridge_qode_paged = get_query_var('page'); }
else { $bridge_qode_paged = 1; }

$bridge_qode_sidebar = get_post_meta($bridge_qode_id, "qode_show-sidebar", true);

if(get_post_meta($bridge_qode_id, "qode_page_background_color", true) != ""){
	$bridge_qode_background_color = get_post_meta($bridge_qode_id, "qode_page_background_color", true);
}else{
	$bridge_qode_background_color = "";
}

if($bridge_qode_options['number_of_chars_masonry'] != "") {
	bridge_qode_set_blog_word_count($bridge_qode_options['number_of_chars_masonry']);
}

$bridge_qode_blog_content_position = "content_above_blog_list";
if(isset($bridge_qode_options['blog_content_position'])){
	$bridge_qode_blog_content_position = $bridge_qode_options['blog_content_position'];
}

$bridge_qode_category_filter = "no";
if(isset($bridge_qode_options['blog_masonry_filter'])){
	$bridge_qode_category_filter = $bridge_qode_options['blog_masonry_filter'];
}
$bridge_qode_container_inner_class = "";
if($bridge_qode_category_filter == "yes"){
	$bridge_qode_container_inner_class = " page_container_inner";
}

$bridge_qode_content_style_spacing = "";
if(get_post_meta($bridge_qode_id, "qode_margin_after_title", true) != ""){
	if(get_post_meta($bridge_qode_id, "qode_margin_after_title_mobile", true) == 'yes'){
		$bridge_qode_content_style_spacing = "padding-top:".esc_attr(get_post_meta($bridge_qode_id, "qode_margin_after_title", true))."px !important";
	}else{
		$bridge_qode_content_style_spacing = "padding-top:".esc_attr(get_post_meta($bridge_qode_id, "qode_margin_after_title", true))."px";
	}
}
?>

	<?php get_template_part( 'title' ); ?>
	
	<?php
		$bridge_qode_revslider = get_post_meta($bridge_qode_id, "qode_revolution-slider", true);
		if (!empty($bridge_qode_revslider)){ ?>
			<div class="q_slider"><div class="q_slider_inner">
			<?php echo do_shortcode($bridge_qode_revslider); ?>
			</div></div>
		<?php
		}
		?>
	<?php
        $bridge_qode_blog_query = bridge_qode_get_blog_query_posts();
        $bridge_qode_params['blog_query'] = $bridge_qode_blog_query;

	?>
	<div class="container"<?php if($bridge_qode_background_color != "") { echo " style='background-color:". $bridge_qode_background_color ."'";} ?>>
        <?php if(isset($bridge_qode_options['overlapping_content']) && $bridge_qode_options['overlapping_content'] == 'yes') {?>
            <div class="overlapping_content"><div class="overlapping_content_inner">
        <?php } ?>
		<div class="container_inner default_template_holder clearfix<?php echo esc_attr( $bridge_qode_container_inner_class ); ?>" <?php bridge_qode_inline_style($bridge_qode_content_style_spacing); ?>>
		<?php /* ?>
							<?php
								$blog_posts_1 = json_decode(mga_get_blog_posts("https://mgahealthcare.com/wp-json/wp/v2/posts?per_page=4&categories=57&_embed"));
								$blog_posts_2 = json_decode(mga_get_blog_posts("https://mgahomecare.com/wp-json/wp/v2/posts?per_page=4&categories=426&_embed"));

								$blog_posts = array_merge($blog_posts_1, $blog_posts_2);
								$blog_posts = array_slice($blog_posts, 0, 4);
								usort($blog_posts, 'mga_sort_objects_by_total');
							?>
							<h2 class="h1 blog-header">News from ZOE Companies</h2>
							<div class="company-news">
								<div class="blog_holder masonry masonry_load_more" style="position: relative; height: 1232.22px; opacity: 1;">
									<div class="blog_holder_grid_sizer"></div>
									<div class="blog_holder_grid_gutter"></div>
									<? foreach($blog_posts as $post) : ?>	
											<?php 
												$images = $post->_embedded->{'wp:featuredmedia'}[0]->media_details->sizes;
												$excerpt = substr($post->excerpt->rendered, 0, strpos(wordwrap($post->excerpt->rendered, 100), "\n") ) . '...';
												if(strpos($post->guid->rendered, 'mgahealthcare.com')){
													$sitename = 'MGA Healthcare';
												} else {
													$sitename = 'MGA Home Healhcare';
												}
											?>
											<article id="post-5" class="post-5 post type-post status-publish format-standard has-post-thumbnail hentry category-design tag-analysis tag-articles tag-business tag-opportunities" style="position: absolute; left: 0px; top: 0px;">
											<?php if($images) : ?>
												<div class="post_image">
													<div itemprop="dateCreated" class="time entry_date updated">
														<span class="time_day"><?php echo date('d', strtotime($post->date)); ?></span>
														<span class="time_month"><?php echo date('M', strtotime($post->date)); ?></span>
													</div>
													<a itemprop="url" href="<?php echo $post->link; ?>" target="_self" title="Staffing Solutions Unparalleled">
													<img width="1920" height="1293" src="<?php echo $images->full->source_url ?>" class="attachment-full size-full wp-post-image" alt="q" srcset="<?php echo $images->full->source_url ?> 1920w, <?php echo $images->full->source_url ?> 300w, <?php echo $images->full->source_url ?> 768w, <?php echo $images->full->source_url ?> 1024w, <?php echo $images->full->source_url ?> 700w" sizes="(max-width: 1920px) 100vw, 1920px">					</a>
												</div>
											<?php endif; ?>
												<div class="post_text">
												<div class="post_text_inner">
													<h2 itemprop="name" class="h5 entry_title"><a itemprop="url" href="<?php echo $post->link; ?>" target="_self" title="Staffing Solutions Unparalleled"><?php echo $post->title->rendered; ?></a></h2>
													<div itemprop="description" class="post_excerpt"><?php echo $excerpt; ?></div><a href="<?php echo $post->link; ?>">Read on <?php echo $sitename; ?></a>	
													<!-- <div class="post_info">
														<span itemprop="dateCreated" class="time entry_date updated"><?php echo $post->date; ?><meta itemprop="interactionCount" content="UserComments: 0"></span>
																			</div> -->
												</div>	
											</div>
										</article>
									<?php endforeach; ?>
								</div>
							</div>
												<?php */ ?>
						<h2 class="h1 blog-header">ZOE Holding News</h2>
			
			<?php if(($bridge_qode_sidebar == "default")||($bridge_qode_sidebar == "")) : ?>

					<?php echo bridge_qode_get_module_part( $bridge_qode_content ); ?>

					<?php 
						bridge_qode_get_template_part('templates/blog', 'structure', $bridge_qode_params);
					?>
					
			<?php elseif($bridge_qode_sidebar == "1" || $bridge_qode_sidebar == "2"): ?>
				<?php
					if($bridge_qode_blog_content_position != "content_above_blog_list"){
						echo bridge_qode_get_module_part( $bridge_qode_content );
					}
				?>
				<div class="<?php if($bridge_qode_sidebar == "1"):?>two_columns_66_33<?php elseif($bridge_qode_sidebar == "2") : ?>two_columns_75_25<?php endif; ?> clearfix grid2 background_color_sidebar">
					<div class="column1">
						<div class="column_inner">

							<?php
								if($bridge_qode_blog_content_position == "content_above_blog_list"){
									echo bridge_qode_get_module_part( $bridge_qode_content );
								}
							?>

							<?php 
								bridge_qode_get_template_part('templates/blog', 'structure', $bridge_qode_params);
							?>
							
						</div>
					</div>
					<div class="column2">
						<?php get_sidebar(); ?>	
					</div>
				</div>
			<?php elseif($bridge_qode_sidebar == "3" || $bridge_qode_sidebar == "4"): ?>
				<?php
					if($bridge_qode_blog_content_position != "content_above_blog_list"){
						echo bridge_qode_get_module_part( $bridge_qode_content );
					}
				?>
				<div class="<?php if($bridge_qode_sidebar == "3"):?>two_columns_33_66<?php elseif($bridge_qode_sidebar == "4") : ?>two_columns_25_75<?php endif; ?> grid2 clearfix background_color_sidebar">
					<div class="column1">
						<?php get_sidebar(); ?>	
					</div>
					<div class="column2">
						<div class="column_inner">

							<?php
								if($bridge_qode_blog_content_position == "content_above_blog_list"){
									echo bridge_qode_get_module_part( $bridge_qode_content );
								}
							?>

							<?php 
								bridge_qode_get_template_part('templates/blog', 'structure', $bridge_qode_params);
							?>
						</div>
					</div>
				</div>
				<?php endif; ?>
		</div>
        <?php if(isset($bridge_qode_options['overlapping_content']) && $bridge_qode_options['overlapping_content'] == 'yes') {?>
            </div></div>
        <?php } ?>
	</div>
<?php do_action('bridge_qode_action_page_after_container') ?>
<?php get_footer(); ?>