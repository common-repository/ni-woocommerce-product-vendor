<?php 
include_once("niwoopv-function.php");
class NIWooPV_Order_Hook  extends NIWooPV_Function {
	function __construct() {
    	//add_action( 'woocommerce_new_order_item',  array($this, 'misha_order_item_meta'), 10, 3 );
		add_action( 'woocommerce_checkout_create_order_line_item', array($this, 'add_booking_order_line_item'), 20, 4 );
	}
	function add_booking_order_line_item( $item, $cart_item_key, $values, $order ) {
		// Get cart item custom data and update order item meta
		/*
		if( isset( $values['adults_qty'] ) ){
			if( ! empty( $values['adults_qty'] ) )
				
		}
		*/
		//
		
		$product_id = $item["product_id"];
		//error_log(  json_encode( $product_id));
		$niwoopv_product_vendor_id = get_post_meta($product_id,"_niwoopv_product_vendor_id",true);
		if ($niwoopv_product_vendor_id >0){
			
			$niwoopv_product_vendor_name = "";
			$niwoopv_product_vendor_array= $this->get_user_list($niwoopv_product_vendor_id );
			
			if (count($niwoopv_product_vendor_array)>0){
				$niwoopv_product_vendor_name  = $niwoopv_product_vendor_array[0]->first_name ." | " . $niwoopv_product_vendor_array[0]->user_email;
			}
			
			$item->update_meta_data( '_niwoopv_product_vendor_id',$niwoopv_product_vendor_id);
			$item->update_meta_data( '_niwoopv_product_vendor_name',$niwoopv_product_vendor_name);	
		}
		
		//error_log(  json_encode( $item));
	}
	function misha_order_item_meta( $item_id, $item, $order_id  ) {
	 
	 	error_log(  json_encode( $item ));
			 	error_log(  json_encode( $item_id ));
		// get product meta
		//$event_time = get_post_meta( $cart_item[ 'product_id' ], 'event_time', true );
	 
		// if not empty, update order item meta
		//if( ! empty( $event_time ) ) {
			//wc_update_order_item_meta( $item_id, 'event_time', $event_time );
		//}
	 
	}
}
?>