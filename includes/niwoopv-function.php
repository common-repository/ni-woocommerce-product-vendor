<?php 
class NIWooPV_Function{
	function __construct() {
      
    }
	function prettyPrint($a) {
		echo "<pre>";
		print_r($a);
		echo "</pre>";
	}
	public function get_request($name,$default = NULL,$set = false){
		if(isset($_REQUEST[$name])){
			$newRequest = $_REQUEST[$name];
			
			if(is_array($newRequest)){
				$newRequest = implode(",", $newRequest);
			}else{
				$newRequest = trim($newRequest);
			}
			
			if($set) $_REQUEST[$name] = $newRequest;
			
			return $newRequest;
		}else{
			if($set) 	$_REQUEST[$name] = $default;
			return $default;
		}
	}
	function get_order_item_detail($order_item_id){
		global $wpdb;
		$sql = "SELECT
				* FROM {$wpdb->prefix}woocommerce_order_itemmeta as woocommerce_order_itemmeta			
				WHERE order_item_id = {$order_item_id}
				";
				
		$results = $wpdb->get_results($sql);
		return $results;			
	}
	function get_order_detail($order_id){
		$order_detail	= get_post_meta($order_id);
		$order_detail_array = array();
		foreach($order_detail as $k => $v)
		{
			$k =substr($k,1);
			$order_detail_array[$k] =$v[0];
		}
		return 	$order_detail_array;
	}
	function get_user_role(){
		global $wp_roles;
		$roles = $wp_roles->get_names();
	
		return $roles;
	}	
	function get_user_list($user_id =NULL){
		global $wpdb;
		
		$query=  "";
		$this->options = get_option('niwoopv_option');
		
		$role = isset($this->options["user_role"])?$this->options["user_role"]:'niwoopv_product_vendor';
		
		//$role = "niwoopv_product_vendor";
		
		$query = " SELECT ";
		$query .= " users.ID as user_id  ";
		$query .= " ,users.user_email as user_email  ";
		$query .= " ,first_name.meta_value as first_name  ";
		$query .= " ,last_name.meta_value as last_name  ";
		
		$query .= " FROM	{$wpdb->prefix}users as users  ";
		
		
		$query .= " LEFT JOIN {$wpdb->prefix}usermeta  role ON role.user_id=users.ID ";
		$query .= " LEFT JOIN {$wpdb->prefix}usermeta  first_name ON first_name.user_id=users.ID ";
		$query .= " LEFT JOIN {$wpdb->prefix}usermeta  last_name ON last_name.user_id=users.ID ";
		
		$query .= " WHERE 1 = 1 ";
		$query .= " AND   role.meta_key='{$wpdb->prefix}capabilities'";
		$query .= " AND  role.meta_value   LIKE '%\"{$role}\"%' ";
		
		$query .= " AND   first_name.meta_key='first_name'";
		$query .= " AND   last_name.meta_key='last_name'";
			
		if ($user_id !=NULL){
			$query .= " AND  users.ID = '{$user_id }'";
		}
		$query .= "  ORDER BY first_name.meta_value ASC";
		
		
		$row = $wpdb->get_results($query);
		//$this->print_data($row);
		return $row;
	}
	function get_user_name_by_id($user_id =NULL){
		$user_name="";
		$first_name = "";
		$user_email = "";
		$user = array();
		
		$user  = $this->get_user_list($user_id);
		$first_name = isset($user[0]->first_name)?$user[0]->first_name:'';
		$user_email = isset($user[0]->user_email)?$user[0]->user_email:'';
		if ( strlen($first_name)>0 &&  strlen($user_email)>0){
			$user_name = $first_name ." | ". $user_email;	
		}else if (strlen($first_name)>0){
			$user_name = $first_name;
		}else if (strlen($user_email)>0){
			$user_name = $user_email;
		}else{
		$user_name ="vendor not assign";
		}
		
		return $user_name;
	}
}
?>