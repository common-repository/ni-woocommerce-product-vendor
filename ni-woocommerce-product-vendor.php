<?php 
/*
Plugin Name: Ni WooCommerce Product Vendor 
Description:Provide the option to create the product vendor and show the product vendor sales report
Author: 	 anzia
Version: 	 1.1.1
Author URI:  http://naziinfotech.com/
Plugin URI:  https://wordpress.org/plugins/ni-woocommerce-product-vendor/
License:	 GPLv3 or later
License URI: http://www.gnu.org/licenses/agpl-3.0.html
Text Domain:  niwoopv
Domain Path: /languages/
Requires at least: 4.7
Tested up to: 6.1.1
WC requires at least: 3.0.0
WC tested up to: 7.4.0
Last Updated Date: 19-February-2023
Requires PHP: 7.0
*/

class IC_WooCommerce_Product_Vendor{
	function __construct() {
		register_activation_hook( __FILE__, array( $this,  'niwoopv_Activation') );	
    	include_once("includes/niwoopv-core.php");
		$core = new NIWooPV_Core();
    }
	function NIWooPV_Activation(){
		$cap = array();
		
		remove_role( 'niwoopv_product_vendor' );
		
		$result = add_role('niwoopv_product_vendor', __('Ni Product Vendor' ),$cap); 
		$role 	= get_role('niwoopv_product_vendor' );
		
		$role->add_cap("manage_woocommerce");
		$role->add_cap("edit_product");
		$role->add_cap("read_product");
		$role->add_cap("delete_product");
		$role->add_cap("edit_products");
		$role->add_cap("edit_others_products");
		$role->add_cap("publish_products");
		$role->add_cap("read_private_products");
		$role->add_cap("delete_products");
		$role->add_cap("delete_private_products");
		$role->add_cap("delete_published_products");
		$role->add_cap("delete_others_products");
		$role->add_cap("edit_private_products");
		$role->add_cap("edit_published_products");
		$role->add_cap("assign_product_terms");
	}
}
$niwoopv = new IC_WooCommerce_Product_Vendor();
?>