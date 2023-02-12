<?php
add_action('wp_ajax_loadmore', 'ajax_loadmore');
add_action('wp_ajax_nopriv_loadmore', 'ajax_loadmore');

function ajax_loadmore()
{

	$paged = !empty($_POST['paged']) ? $_POST['paged'] : 1;
	$paged++;

	query_posts([
		'paged' => $paged,
		'post_status' => 'publish'
	]);
	while (have_posts()) : the_post();
		get_template_part('template-parts/content', 'post', ['class' => 'col-lg-6']);
	endwhile;
	die;
}

?>