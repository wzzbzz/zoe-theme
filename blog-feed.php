<?php 
require "../../../wp-load.php";

function blogfeed_excerpt_more( $more ) {
	return ' [...]';
}
add_filter( 'excerpt_more', 'blogfeed_excerpt_more' );

remove_filter('the_content', 'wptexturize');

if(isset($_GET['pfid'])) {
	$recent_posts = new WP_Query(array(
		'p' => $_GET['pfid'],
	));
} else {

	$count = (isset($_GET['c'])) ? $_GET['c'] : 2;

	if(isset($_GET['cat'])) {
		$args = array(
			'posts_per_page' => $count,
			'cat' => array($_GET['cat'])
		);
	} else {
		$args = array(
			'posts_per_page' => $count,
			'category__not_in' => array(358), //Exclude 'Employee Spotlight' posts
		);
	}

	$recent_posts = new WP_Query($args);

}

$feed = array();

foreach($recent_posts->posts as $post){
	setup_postdata( $post );
	$item = new stdClass();
	//$item->post_date = strtotime(get_the_date('Y-m-d', $post->ID));
	$item->ID = $post->ID;
	$item->post_date = $post->post_date;
	$thumbID = get_post_thumbnail_id($post->ID);
	$thumb = wp_get_attachment_image_src($thumbID, 'eight-columns' );
	$item->thumb = str_replace('http:', '', $thumb[0]);
	$featured_thumb = wp_get_attachment_image_src($thumbID, 'full' );
	$item->featured_thumb = str_replace('http:', '', $featured_thumb[0]);
	$title =  preg_replace( '~((?:\S*?\s){5})~', "$1\n", $post->post_title );
	$item->post_content = apply_filters( 'the_content', $post->post_content );
	//$item->content = $post->post_content;
	$item->post_excerpt = get_the_excerpt($post->ID);
	$item->post_title = $title;
	$item->permalink = get_permalink($post->ID);
	array_push($feed, $item);
}
$feed = json_encode($feed);

echo $feed;