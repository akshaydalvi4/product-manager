<?php
/*
Plugin Name: Product Manager  
Description: Product Manager is a responsive breakthrough powerful and free Wordpress Plugins for beautiful products and services management on WordPress website.
Version: 1.0
Author: Akshay Dalvi (akshaydalvi4@gmail.com)
*/

//create data base 
register_activation_hook( __FILE__, 'jal_install_child' );
register_activation_hook( __FILE__, 'jal_install_parent' );
register_activation_hook( __FILE__, 'jal_install_product' );
////////////add product backend ////////////
function add_product(){
	include_once('add-product.php');
}
////////////add manage product backend////////////
function product_manager(){
	include_once('list-product.php');
}
////////////add brand////////////
function add_child(){
	include_once('add-child.php');
}
////////////add category ////////////
function add_parent(){
	include_once('add-parent.php');
}
//////////Dashbord Menu/////////////////
function wp_krx_products(){

	add_menu_page( 'My Page Title', 'Product Manager', 6, __FILE__ , 'product_manager');
	add_submenu_page( __FILE__, 'add-parent', 'Add Category', 6, 'add-parent', 'add_parent');
	add_submenu_page( __FILE__, 'add-child', 'Add Brand', 6, 'add-child', 'add_child');
	add_submenu_page( __FILE__, 'add-product', 'Add Product', 6, 'add-product', 'add_product');
}
add_action('admin_menu', 'wp_krx_products');
?>

