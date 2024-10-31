<?php
if ( !class_exists( 'NIWooPV_Order_Product_Report' ) ) {
	include_once("niwoopv-function.php");
	class NIWooPV_Order_Product_Report extends NIWooPV_Function {
		function __construct() {
		}
		function get_page_init(){
		?>
        <div class="container-fluid">
            	<div id="niwoopv">
                	<div class="row">
                    <div class="col">
                        <div class="card " style="max-width:50%">
                            <div class="card-header bd-indigo-400">
                               <?php esc_html_e('Order Product Sales Report', 'nisalesreport'); ?>
                            </div>
                            <div class="card-body">
                                <form id="frm_niwoopv_order_product_report" name="frm_niwoopv_order_product_report">
                                    <div class="row">
                                        <div class="col-3">
                                            <label for="select_order">
                                               <?php esc_html_e('Select order period', 'nisalesreport'); ?>
                                            </label>
                                        </div>
                                        <div class="col-3">
                                           <select name="select_order"  id="select_order" >
                                              <option value="today"><?php _e('Today', 'nisalesreport'); ?></option>
                                              <option value="yesterday"><?php _e('Yesterday', 'nisalesreport'); ?></option>
                                              <option value="last_7_days"><?php _e('Last 7 days', 'nisalesreport'); ?></option>
                                              <option value="last_10_days"><?php _e('Last 10 days', 'nisalesreport'); ?></option>
                                              <option value="last_30_days"><?php _e('Last 30 days', 'nisalesreport'); ?></option>
                                              <option value="last_60_days"><?php _e('Last 60 days', 'nisalesreport'); ?></option>
                                              <option value="this_year"><?php _e('This year', 'nisalesreport'); ?></option>
                                        </select>
                                        </div>
                                        <div class="col-3">
                                            <label for="order_no">
                                              <?php esc_html_e('Order No.', 'nisalesreport'); ?>
                                            </label>
                                        </div>
                                        <div class="col-3">
                                             <input id="order_no" name="order_no" type="text">
                                        </div>
                                    </div>
                                    <div class="row">
                                    	<div  class="col"  style="padding:10px;"></div>
                                    </div>
                                    <div class="row">
                                    	<div class="col-3">
                                        	<label for="billing_first_name">
                                               <?php esc_html_e('Billing First Name', 'nisalesreport'); ?>
                                            </label>
                                        </div>
                                        <div class="col-3">
                                        	 <input id="billing_first_name" name="billing_first_name" type="text" >
                                        </div>
                                        
                                        <div class="col-3">
                                        	<label for="billing_email">
                                               <?php esc_html_e('Billing Email', 'nisalesreport'); ?>
                                            </label>
                                        </div>
                                        <div class="col-3">
                                        	<input id="billing_email" name="billing_email" type="text">
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
                   					<input type="hidden"  name="sub_action" id="sub_action" value="niwoopv_order_product_report"/>
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
			
			?>
            <div style="overflow:auto">
            <div style="text-align:right;margin-bottom:10px">
            <form id="ni_frm_sales_order" action="" method="post">
               <input type="submit" value="Print"  class="print_hide  ni_print wooreport_button" name="niwoopv_order_product_report_print" id="niwoopv_order_product_report_print" />
               <input type="hidden" name="select_order" value="<?php echo $this->get_request("select_order");  ?>" />
              <input type="hidden" name="order_no" value="<?php echo $this->get_request("order_no");  ?>" />
               <input type="hidden" name="billing_first_name" value="<?php echo  $this->get_request("billing_first_name",'',true);  ?>" />
              <input type="hidden" name="billing_email" value="<?php echo $this->get_request("billing_email",'',true);  ?>" />
                
                
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
                            	<?php switch($col_key): case "": break; ?>
                                <?php case "": ?>
                                <?php break; ?>
                                
                                
                                <?php case "price": ?>
								<?php $td_class = "style=\"text-align:right\""; ?>
                                <?php $td_vale = wc_price($row_value->line_total/$row_value->qty);   ?>
                                <?php break; ?>
                                
                                <?php case "icwoopv_product_vendor_id": ?>
                                <?php $product_id = isset($row_value->product_id)?$row_value->product_id:'0'; ?>
                                <?php $product_vendor_id = get_post_meta($product_id ,'_niwoopv_product_vendor_id',true); ?>
                                <?php if (strlen($product_vendor_id)>0) :?>
								<?php $td_value = $this->get_user_name_by_id($product_vendor_id ); ?>
                                	<?php else: ?>
                                    <?php  $td_value = "vendor not assign"; ?>
                                <?php endif;?>
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
				$order_id =$v->order_id;
				$order_detail = $this->get_order_detail($order_id);
				foreach($order_detail as $dkey => $dvalue)
				{
						$rows[$k]->$dkey =$dvalue;
					
				}
				/*Order Item Detail*/
				$order_item_id = $v->order_item_id;
				$order_item_detail= $this->get_order_item_detail($order_item_id );
				foreach ($order_item_detail as $mKey => $mValue){
						$new_mKey = $str= ltrim ($mValue->meta_key, '_');
						$rows[$k]->$new_mKey = $mValue->meta_value;		
				}
			}
			
			
			return $rows;
			
		}
		function get_query(){
			global $wpdb;	
			$today 				 = date_i18n("Y-m-d");
			$select_order 		 = $this->get_request("select_order","today");
			$order_no			 = $this->get_request("order_no");
			$order_no 			 = $this->get_request("order_no");
			$billing_first_name  = $this->get_request("billing_first_name",'',true);
			$billing_email		 = $this->get_request("billing_email",'',true);
			
			
			$query = "SELECT
					posts.ID as order_id
					,posts.post_status as order_status
					,woocommerce_order_items.order_item_id as order_item_id
					, date_format( posts.post_date, '%Y-%m-%d') as order_date 
					,woocommerce_order_items.order_item_name
					FROM {$wpdb->prefix}posts as posts	";		
					$query .= "  LEFT JOIN  {$wpdb->prefix}woocommerce_order_items as woocommerce_order_items ON woocommerce_order_items.order_id=posts.ID ";
					
					if (strlen($billing_first_name)>0 && $billing_first_name!="" ){
						$query .= "  LEFT JOIN  {$wpdb->prefix}postmeta as billing_first_name ON billing_first_name.post_id=posts.ID ";
					}
					if (strlen($billing_email)>0 && $billing_email!="" ){
							$query .= " LEFT JOIN {$wpdb->prefix}postmeta as billing_email ON billing_email.post_id = posts.ID ";
					}
					
					$query .= "  WHERE 1 = 1";  
					$query .= " AND	posts.post_type ='shop_order' ";
					$query .= "	AND woocommerce_order_items.order_item_type ='line_item' ";
					if (strlen($billing_first_name)>0 && $billing_first_name!="" ){
						$query .= " AND	billing_first_name.meta_key ='_billing_first_name' ";
						$query .= " AND billing_first_name.meta_value LIKE '%{$billing_first_name}%'";	
					}
					if (strlen($billing_email)>0 && $billing_email!="" ){
						$query .= " AND billing_email.meta_key = '_billing_email'";	 
						$query .= " AND billing_email.meta_value LIKE '%{$billing_email}%'";	
					}
					$query .= "		AND posts.post_status IN ('wc-pending','wc-processing','wc-on-hold', 'wc-completed' ,'wc-cancelled' ,  'wc-refunded' ,'wc-failed')";
							
					if ($order_no){
						$query .= " AND   posts.ID = '{$order_no}'";
					}		
					
					 switch ($select_order) {
						case "today":
							$query .= " AND   date_format( posts.post_date, '%Y-%m-%d') BETWEEN '{$today}' AND '{$today}'";
							break;
						case "yesterday":
							$query .= " AND  date_format( posts.post_date, '%Y-%m-%d') = date_format( DATE_SUB(CURDATE(), INTERVAL 1 DAY), '%Y-%m-%d')";
							break;
						case "last_7_days":
							$query .= " AND  date_format( posts.post_date, '%Y-%m-%d') BETWEEN date_format(DATE_SUB(CURDATE(), INTERVAL 7 DAY), '%Y-%m-%d') AND   '{$today}' ";
							break;
						case "last_10_days":
							$query .= " AND  date_format( posts.post_date, '%Y-%m-%d') BETWEEN date_format(DATE_SUB(CURDATE(), INTERVAL 10 DAY), '%Y-%m-%d') AND   '{$today}' ";
							break;	
						case "last_30_days":
								$query .= " AND  date_format( posts.post_date, '%Y-%m-%d') BETWEEN date_format(DATE_SUB(CURDATE(), INTERVAL 30 DAY), '%Y-%m-%d') AND   '{$today}' ";
						 case "last_60_days":
								$query .= " AND  date_format( posts.post_date, '%Y-%m-%d') BETWEEN date_format(DATE_SUB(CURDATE(), INTERVAL 60 DAY), '%Y-%m-%d') AND   '{$today}' ";		
							break;	
						case "this_year":
							$query .= " AND  YEAR(date_format( posts.post_date, '%Y-%m-%d')) = YEAR(date_format(CURDATE(), '%Y-%m-%d'))";			
							break;		
						default:
							$query .= " AND   date_format( posts.post_date, '%Y-%m-%d') BETWEEN '{$today}' AND '{$today}'";
					}
				$query .= "order by posts.post_date DESC";	
				
				$rows = $wpdb->get_results($query);
		
			return $rows;	
		}
		function get_columns(){
			$columns  =array();
			$columns["order_id"] =  __('#ID', 'nisalesreport');
			$columns["order_date"]		   =  __('Date', 'nisalesreport');
			$columns["billing_first_name"] =  __('First Name', 'nisalesreport');
			$columns["billing_email"] =  __('Email', 'nisalesreport');
			$columns["billing_country"] =  __('Country', 'nisalesreport');
			$columns["order_currency"] =  __('Currency', 'nisalesreport');
			$columns["payment_method_title"] =  __('Payment', 'nisalesreport');
			$columns["order_status"] =  __('Status', 'nisalesreport');
			$columns["order_item_name"] =  __('Product', 'nisalesreport');
			$columns["qty"] =  __('Quantity', 'nisalesreport');
			$columns["price"] =  __('Price', 'nisalesreport');
			$columns["line_tax"] =  __('Line Tax', 'nisalesreport');
			$columns["line_total"] =  __('Line Total', 'nisalesreport');
			$columns["icwoopv_product_vendor_id"] =  __('Vendor', 'nisalesreport');
			
			//_icwoopv_product_vendor_id
			return  apply_filters('icwoopv_order_product_report', $columns );	
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
	}
}
?>