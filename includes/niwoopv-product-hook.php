<?php 
	include_once("niwoopv-function.php");
class NIWooPV_Product_Hook  extends NIWooPV_Function {
	function __construct() {
      	global $post;
		
	   add_action( 'add_meta_boxes',  array($this, 'add_events_metaboxes') );
	   add_action('save_post',  array($this, 'wporg_save_postdata'));
	  
    }
	function add_events_metaboxes(){
		add_meta_box(
			'wpt_events_location',
			'Product Vendor',
			 array($this, 'wpt_events_location'),
			'product',
			'side',
			'default'
		);
	}
	function wpt_events_location() {
		global $post;
		$user = $this->get_user_list();
		$niwoopv_vendor = get_post_meta($post->ID,"_niwoopv_product_vendor_id",true);
		if (count($user)>0) :
			?>
        <select name="niwoopv_product_vendor" id="niwoopv_product_vendor">
        	<?php foreach($user  as $key=>$value): ?>
        	<option <?php echo ($niwoopv_vendor == $value->user_id)?"selected":""; ?> value="<?php echo   $value->user_id;?>"> <?php echo   $value->first_name ." | ". $value->user_email;?> </option>
            <?php endforeach; ?>
        </select>
        <?php
		else:
			_e("No vendor found, please create vendor");		
		endif;
		
	}
	function wporg_save_postdata($post_id){
		global $post;
		//echo $_POST['post_type'] ;
		// Bail if we're doing an auto save
	    if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
		
		//if ( $_POST['post_type'] =="product") {
			
			if (array_key_exists('niwoopv_product_vendor', $_POST)) {
				update_post_meta($post_id,	'_niwoopv_product_vendor_id', sanitize_text_field($_POST['niwoopv_product_vendor']));
			}
		//}
	
	}
}
?>