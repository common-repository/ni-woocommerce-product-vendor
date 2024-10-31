<?php
if ( !class_exists( 'NIWooPV_Stock_Report' ) ) {
	include_once("niwoopv-function.php");
	class NIWooPV_Stock_Report extends NIWooPV_Function {
		function __construct() {
		}
		function get_page_init(){
		$product_list = $this->get_product_list();
		$user = $this->get_user_list();
		?>
        <div class="container-fluid">
            	<div id="niwoopv">
                	<div class="row">
                    <div class="col">
                        <div class="card " style="max-width:50%">
                            <div class="card-header bd-indigo-400">
                              <?php esc_html_e('Stock Report', 'nisalesreport'); ?>
                            </div>
                            <div class="card-body">
                                <form id="frm_niwoopv_stock_report" name="frm_niwoopv_stock_report">
                                    <div class="row">
                                        <div class="col-3">
                                            <label for="select_order">
                                              <?php esc_html_e('Select order period', 'nisalesreport'); ?>
                                            </label>
                                        </div>
                                        <div class="col-3">
                                          <select name="product_id"  id="product_id" >
                                              <option value="-1">--<?php esc_html_e("Select")?>--</option>
                                             <?php foreach($product_list as $key=>$value): ?>
                                              <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                             <?php endforeach; ?>
                                        </select>
                                        </div>
                                        <div class="col-3">
                                            <label for="vendor_id">
                                             <?php esc_html_e('Select order period', 'nisalesreport'); ?>
                                            </label>
                                        </div>
                                        <div class="col-3">
                                             <select name="vendor_id"  id="vendor_id" >
												 <option value="-1">--<?php esc_html_e("Select On Product")?>--</option>
                                                 <?php foreach($user as $key=>$value): ?>
                                                   <?php $first_name  = isset($value->first_name)?$value->first_name:''; ?>		
                                                   <?php $user_email  = isset($value->user_email)?$value->user_email:''; ?>		
                                                  <option value="<?php echo $value->user_id; ?>"><?php echo $first_name ." | ". $user_email ; ?></option>
                                                 <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                    	<div  class="col"  style="padding:10px;"></div>
                                    </div>
                                  
                                    <div class="row">
                                    	<div class="col" style="text-align:right">
                                        	<input type="submit" value="<?php  esc_html_e("Search","nicsrfwoo "); ?>" class="btn bd-blue-300  mb-2" />
                                        </div> 
                                    </div>
                                     <input type="hidden"  name="action" id="action" value="niwoopv_ajax"/>
                    <input type="hidden"  name="sub_action" id="sub_action" value="niwoopv_stock_report"/>
                                    <input type="hidden" name="call" id="call" value="get_report" />
                                </form>
                                    
                            </div>
                        </div>
                    </div>
                	</div>
                	
                    <div class="row">
                    	<div  class="col">
                           <div class="niwoopv_ajax_content"></div>
                        </div>
                    </div>
                    
                    
                    
               		
           		</div>
            </div>
        
        <?php
		}
		function get_ajax(){
			$columns = $this->get_columns();
			$rows =  $this->get_report();
			$td_value ="";
			$td_class ="";
			//$this->prettyPrint($rows);
			?>
            <div style="overflow:auto">
            <div style="text-align:right;margin-bottom:10px">
            <form id="" action="" method="post">
               <input type="submit" value="Print"  class="print_hide  ni_print wooreport_button" name="niwoopv_stock_report_print" id="niwoopv_stock_report_print" />
               <input type="hidden" name="product_id" value="<?php echo $this->get_request("product_id");  ?>" />
              <input type="hidden" name="vendor_id" value="<?php echo $this->get_request("vendor_id");  ?>" />
              
                
                
            </form>
            </div>
            <div style="clear:both"></div>
            <div style="overflow-x:auto;">
            	<table class="table">
            	<thead>
                	<tr>
						<?php foreach($columns as $key=>$value): ?>
                            <th><?php echo $value; ?></th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
                	<?php foreach($rows as $row_key=>$row_value): ?>
                    	<tr>
                        	<?php foreach($columns as $col_key=>$col_value): ?>
                            	<?php switch($col_key): case "sad": break; ?>
                                <?php case "": ?>
                                <?php break; ?>
                                
                                <?php case "icwoopv_product_vendor_id": ?>
                                <?php $product_id = isset($row_value->product_id)?$row_value->product_id:'0'; ?>
                                <?php $product_vendor_id = get_post_meta($product_id ,'_niwoopv_product_vendor_id',true); ?>
                                 <?php $td_value = $this->get_user_name_by_id($product_vendor_id ); ?>
                                <?php break; ?>
                                
                                <?php default; ?>
                                <?php $td_value = isset($row_value->$col_key)?$row_value->$col_key:''; ?>
                                <?php endswitch;?>
                                 <td> <?php echo  $td_value; ?> </td>
                            <?php endforeach; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            </div>
            
            </div>
			<?php
			
			
		}
		function get_report(){
			$rows = $this->get_query();
			foreach($rows as $k => $v){
				
				/*Order Data*/
				$order_id =$v->product_id;
				$order_detail = $this->get_order_detail($order_id);
				foreach($order_detail as $dkey => $dvalue)
				{
						$rows[$k]->$dkey =$dvalue;
					
				}
				
			}
			//$this->prettyPrint($rows);
			return $rows;
			
		}
		function get_query(){
			global $wpdb;	
			$today 				 = date_i18n("Y-m-d");
			$product_id 		 = $this->get_request("product_id","-1");
		    $vendor_id			 = $this->get_request("vendor_id","-1");
		
			
				$query = " SELECT ";
				$query .= " posts.ID as product_id ";
				$query .= ", post_title as product_name" ;
				$query .= " 	FROM {$wpdb->prefix}posts as posts	";		
				
				if ($vendor_id >0){
					$query .= "  LEFT JOIN  {$wpdb->prefix}postmeta as product_vendor_id ON product_vendor_id.post_id=posts.ID ";
				}
				$query .= "  WHERE 1 = 1";  
				$query .= " AND	posts.post_type ='product' ";
				$query .= " AND	posts.post_status ='publish'";
				
				if ($vendor_id >0){
					$query .= " AND	product_vendor_id.meta_key ='_niwoopv_product_vendor_id'";
					$query .= " AND	product_vendor_id.meta_value ='". $vendor_id ."'";
				}
				if ($product_id >0){
					$query .= " AND	posts.ID ='{$product_id}'";
				}
				$query .= "order by posts.post_date DESC";	
				
				
				$rows = $wpdb->get_results($query);
				
			//$this->prettyPrint($rows);	
		
			return $rows;	
		}
		function get_columns(){
			$columns  =array();
			$columns["product_id"] =  __('#ID', 'nisalesreport');
			$columns["product_name"]		   =  __('Product Name', 'nisalesreport');
			$columns["sku"] =  __('sku', 'nisalesreport');
			$columns["price"] =  __('Price', 'nisalesreport');
			$columns["stock"] =  __('Stock', 'nisalesreport');
			$columns["stock_status"] =  __('Stock Status', 'nisalesreport');
			$columns["icwoopv_product_vendor_id"] =  __('Vendor Name', 'nisalesreport');
			
			
			return  apply_filters('icwoopv_stock_report', $columns );	
		}
		function get_print(){
			?>
        <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
            <html xmlns="http://www.w3.org/1999/xhtml">
            <head>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
            <title>Print</title>
            <link rel='stylesheet' id='sales-report-style-css'  href='<?php echo  plugins_url( '../admin/css/niwoopv-report.css', __FILE__ ); ?>' type='text/css' media='all' />
            </head>
            
            <body>
                <?php 
                     $this->get_ajax("PRINT");
                ?>
              <div class="print_hide" style="text-align:right; margin-top:15px"><input type="button" value="Back" onClick="window.history.go(-1)"> <input type="button" value="Print this page" onClick="window.print()">	</div>
             
            </body>
            </html>
    
        <?php
		}
		function get_product_list(){
			global $wpdb;	
			$data = array();
			$query = " SELECT ";
			$query .= " posts.ID as product_id ";
			$query .= ", post_title as product_name" ;
			$query .= " 	FROM {$wpdb->prefix}posts as posts	";		
			$query .= "  WHERE 1 = 1";  
			$query .= " AND	posts.post_type ='product' ";
			$query .= " AND	posts.post_status ='publish'";
			$query .= "order by posts.post_date DESC";	
				
			$rows = $wpdb->get_results($query);	
			
			foreach($rows as $key=>$value){
				$data[$value->product_id] =$value->product_name;
					 
			}
			
			return $data;
		}
	}
}
?>