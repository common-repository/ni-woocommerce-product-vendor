<?php 
if ( !class_exists( 'NIWooPV_Setting' ) ) {
	include_once("niwoopv-function.php");
	class NIWooPV_Setting  extends NIWooPV_Function {
		function __construct() {
		}
		function get_page_init(){
		$user = $this->get_user_role();
		$this->options = get_option('niwoopv_option');
		//$this->prettyPrint($this->options["user_role"]);
		$user_role_selected = isset($this->options["user_role"])?$this->options["user_role"]:"niwoopv_product_vendor";
		?>
        <form name="frm_niwoopv_setting" id="frm_niwoopv_setting">
        	<table>
            	<tr>
                	<td><?php _e("Select User Role")?></td>
                    <td>
					<select name="niwoopv_option[user_role]">
					<?php foreach($user  as $key=>$value): ?>
                    	<option <?php echo ($user_role_selected==$key)?"selected":''; ?> value="<?php echo $key; ?>"><?php echo $value; ?></option>
                    <?php endforeach; ?>
                    </select>
                    </td>
                </tr>
                <tr>
                	<td colspan="2">
                    	<input type="submit" value="<?php _e("Save")?>" />
                    </td>
                </tr>
            </table>
        	<input type="hidden" name="action" id="action" value="niwoopv_ajax" />
           <input type="hidden" name="sub_action" id="sub_action" value="niwoopv_setting" />
           
        </form>
        <div class="niwoopv_ajax_content"></div>
        <?php
		}
		function get_ajax(){
			//echo json_encode($_REQUEST["niwoopv_option"]);
			$niwoopv_option   = isset($_REQUEST["niwoopv_option"])? $_REQUEST["niwoopv_option"]:array();
			update_option("niwoopv_option",$niwoopv_option);
			echo "Record updated..";
			die;
		}
		function get_user_role(){
			global $wp_roles;
			$roles = $wp_roles->get_names();
		
			return $roles;
		}
	}
}