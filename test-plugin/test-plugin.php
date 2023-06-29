<?php 
/**
* Plugin Name: test-plugin
* Plugin URI: https://github.com/Master-r-dev/test-plugin/
* Description: Test.
* Version: 0.0.1
* Author: Alex S
* Author URI: https://www.linkedin.com/in/alexsdev/
**/
if ( !function_exists( 'add_action' ) ) {
	echo 'dont call directly';
	exit;
}
 
add_action( 'init', 'true_register_cpt' );
 
function true_register_cpt() { 
	$args = array(
		'labels' => array(
		'name'                     => 'Stocks',
		'singular_name'            => 'Stock', 
		'add_new'                  => 'Add stock',
		'add_new_item'             => 'Add new stock', 
		'edit_item'                => 'Edit stock',
		'new_item'                 => 'New stock',
		'view_item'                => 'View stock',  
		'search_items'             => 'Find stock',
		'not_found'                => 'No stocks found',
		'not_found_in_trash'       => 'No stocks found in trash', 
		'all_items'                => 'All stocks',  
		'archives'                 => 'Stocks archieves',  
		'menu_name'                => 'Stocks', 
		'name_admin_bar'           => 'Stocks',  
		'view_items'               => 'View stocks',  
		'attributes'               => 'Stock property', 
  
		'insert_into_item'         => 'Insert into stock',
		'uploaded_to_this_item'    => 'Uploaded to this stock',
		'featured_image'           => 'Stock`s image',
		'set_featured_image'       => 'Set stock`s image',
		'remove_featured_image'    => 'Delete stock`s image',
		'use_featured_image'       => 'Use stock`s image',
  
		'item_updated'             => 'Stock is updated',
		'item_published'           => 'Stock is added',
		'item_published_privately' => 'Stock is added privately',
		'item_reverted_to_draft'   => 'Stock is saved as a draft',
		'item_scheduled'           => 'Stock is scheduled',
	),
		'public' => true,
		'has_archive'   => true,
		'menu_icon' => 'dashicons-format-aside'
	);
	register_post_type( 'al_stocks', $args );
}
  
function custom_fields(){
	add_meta_box(
		'stock_cf',
		'Stock Details', // title
		'CF',
		'al_stocks', //type
		'normal',
		'low'
	);
}
function CF(){
	echo 'custom field for stock';
}
add_action('admin_init','custom_fields');


add_action( 'template_include', 'stocks_template' );
function stocks_template( $template ) { 
	global $post;  
    if($post &&'al_stocks' === $post->post_type  ) {
		if (is_archive()){ 		
			$template = dirname(__FILE__)  .'/tmpl_archives.php';
		} else if (is_single()){
			require  dirname(__FILE__) . '/single-page-functions.php';		
			$template = dirname(__FILE__)  .'/tmpl_single.php';
		} 
    } 
    return $template;
}

function myplugin_ajaxurl() {

	echo '<script type="text/javascript">
			var ajaxurl = "' . admin_url('admin-ajax.php') . '";
		  </script>';
 }
 add_action('wp_head', 'myplugin_ajaxurl');
  
 function get_stock() { 
	 if ( isset($_REQUEST) ) {
		 $name = $_REQUEST['search'];
		 global $wpdb;
		 $wpdb->show_errors();
		 $models = $wpdb->get_results( "SELECT SQL_CALC_FOUND_ROWS  wp_posts.post_name	 FROM wp_posts 		 WHERE 1=1 AND wp_posts.post_name LIKE '%".$name."%'  AND wp_posts.post_type = 'al_stocks' AND ((wp_posts.post_status = 'publish'))");
		 echo json_encode( $models );
	 } 
	die();
 } 
 add_action( 'wp_ajax_get_stock', 'get_stock' );
 add_action( 'wp_ajax_nopriv_get_stock', 'get_stock' );


?>
