<?php 
if ( !class_exists( 'NIWooPV_Core' ) ) {
	include_once("niwoopv-function.php");
	class NIWooPV_Core extends NIWooPV_Function {
		function __construct() {
			$this->get_include_files();
		  	add_action('admin_menu', array($this, 'admin_menu'));	
			add_action( 'admin_enqueue_scripts',  array(&$this,'admin_enqueue_scripts' ));
			add_action( 'wp_ajax_niwoopv_ajax',  array(&$this,'niwoopv_ajax' )); /*used in form field name="action" value="my_action"*/
			add_action('admin_init', array( &$this, 'admin_init' ) );
		}
		function admin_menu(){
			add_menu_page("Product vendor","Product vendor","manage_options", "niwoopv-dashboard",   array($this, 'add_page'),'dashicons-products', 61.457 );
			add_submenu_page('niwoopv-dashboard', 'Dashboard', 'Dashboard', 'manage_options', 'niwoopv-dashboard', array($this, 'add_page'));
			add_submenu_page('niwoopv-dashboard', 'Order Product Report', 'Order Product Report', 'manage_options', 'niwoopv-order-product-report', array($this, 'add_page'));
			
			add_submenu_page('niwoopv-dashboard', 'Stock Report', 'Stock Report', 'manage_options', 'niwoopv-stock-report', array($this, 'add_page'));
			
			add_submenu_page('niwoopv-dashboard', 'Setting', 'Setting', 'manage_options', 'niwoopv-setting', array($this, 'add_page'));
		}
		function add_page(){
			$page  = $this->get_request("page");
			if ($page  =="niwoopv-dashboard"){
				include_once("niwoopv-dashboard.php");
				$obj = new NIWooPV_Dashboard();
				$obj->get_page_init();
			}
			if ($page == "niwoopv-order-product-report"){
				include_once("niwoopv-order-product-report.php");
				$obj = new NIWooPV_Order_Product_Report();
				$obj->get_page_init();
			}
			if ($page == "niwoopv-setting"){
				include_once("niwoopv-setting.php");
				$obj = new NIWooPV_Setting();
				$obj->get_page_init();
			}
			if ($page == "niwoopv-stock-report"){
				include_once("niwoopv-stock-report.php");
				$obj = new NIWooPV_Stock_Report();
				$obj->get_page_init();
			}
			
			
		}
		function get_include_files(){
			include_once("niwoopv-product-hook.php");
			$objph = new NIWooPV_Product_Hook();
			
			include_once("niwoopv-order-hook.php");
			$objorder = new NIWooPV_Order_Hook();
		}
		function admin_enqueue_scripts($hook){
			$page  = $this->get_request("page");
			if ($page == "niwoopv-dashboard"){
				wp_register_style('niwoopv-report-css', plugins_url( '../admin/css/niwoopv-report.css', __FILE__ ));
		 		wp_enqueue_style('niwoopv-report-css');
				
				wp_register_style('niwoovd-bootstrap-css', plugins_url('../admin/css/lib/bootstrap.min.css', __FILE__ ));
				wp_enqueue_style('niwoovd-bootstrap-css' );
				
				wp_enqueue_script('niwoovd-bootstrap-script', plugins_url( '../admin/js/lib/bootstrap.min.js', __FILE__ ));
				wp_enqueue_script('niwoovd-popper-script', plugins_url( '../admin/js/lib/popper.min.js', __FILE__ ));
				
				
				wp_register_style( 'niwoovd-font-awesome-css', plugins_url( '../admin/css/font-awesome.css', __FILE__ ));
		 			wp_enqueue_style( 'niwoovd-font-awesome-css' );
					
					wp_register_script( 'niwoovd-amcharts-script', plugins_url( '../admin/js/amcharts/amcharts.js', __FILE__ ) );
					wp_enqueue_script('niwoovd-amcharts-script');
				
		
					wp_register_script( 'niwoovd-light-script', plugins_url( '../admin/js/amcharts/light.js', __FILE__ ) );
					wp_enqueue_script('niwoovd-light-script');
				
					wp_register_script( 'niwoovd-pie-script', plugins_url( '../admin/js/amcharts/pie.js', __FILE__ ) );
					wp_enqueue_script('niwoovd-pie-script');
				
			}
			if ($page == "niwoopv-order-product-report"){
				wp_register_script( 'niwoopv-order-product-report-script', plugins_url( '../admin/js/niwoopv-order-product-report.js', __FILE__ ) );
				wp_enqueue_script('niwoopv-order-product-report-script');
				
				wp_register_style('niwoopv-report-css', plugins_url( '../admin/css/niwoopv-report.css', __FILE__ ));
		 		wp_enqueue_style('niwoopv-report-css');
				
				wp_register_style('niwoovd-bootstrap-css', plugins_url('../admin/css/lib/bootstrap.min.css', __FILE__ ));
				wp_enqueue_style('niwoovd-bootstrap-css' );
			}
			if ($page == "niwoopv-setting"){
				wp_register_script( 'niwoopv-setting-script', plugins_url( '../admin/js/niwoopv-setting.js', __FILE__ ) );
				wp_enqueue_script('niwoopv-setting-script');
			}
			if ($page == "niwoopv-stock-report"){
				wp_register_script( 'niwoopv-stock-report-script', plugins_url( '../admin/js/niwoopv-stock-report.js', __FILE__ ) );
				wp_enqueue_script('niwoopv-stock-report-script');
				
				
				
				wp_register_style('niwoopv-report-css', plugins_url( '../admin/css/niwoopv-report.css', __FILE__ ));
		 		wp_enqueue_style('niwoopv-report-css');
				
				wp_register_style('niwoovd-bootstrap-css', plugins_url('../admin/css/lib/bootstrap.min.css', __FILE__ ));
				wp_enqueue_style('niwoovd-bootstrap-css' );
				
				
			}
			
			wp_enqueue_script('niwoopv-script', plugins_url( '../admin/js/script.js', __FILE__ ), array('jquery') );
			wp_localize_script('niwoopv-script','niwoopv_ajax_object',array('niwoopv_ajaxurl'=>admin_url('admin-ajax.php')));
		 	
		}
		function admin_init(){
			if(isset($_REQUEST['niwoopv_stock_report_print'])){
				include_once("niwoopv-stock-report.php");
				$obj = new NIWooPV_Stock_Report();
				$obj->get_print();
				die;
			}
			if(isset($_REQUEST['niwoopv_order_product_report_print'])){
				include_once("niwoopv-order-product-report.php");
				$obj = new NIWooPV_Order_Product_Report();
				$obj->get_print();
				die;
			}
			//niwoopv_order_product_report_print	
		}
		function niwoopv_ajax(){
			//order_product_report
			$sub_action = $this->get_request("sub_action");
			if ($sub_action  =="niwoopv_order_product_report"){
				include_once("niwoopv-order-product-report.php");
				$obj = new NIWooPV_Order_Product_Report();
				$obj->get_ajax();
			}
			if ($sub_action=="niwoopv_setting"){
				include_once("niwoopv-setting.php");
				$obj = new NIWooPV_Setting();
				$obj->get_ajax();
			}
			if ($sub_action=="niwoopv_stock_report"){
				include_once("niwoopv-stock-report.php");
				$obj = new NIWooPV_Stock_Report();
				$obj->get_ajax();
			}
			//echo json_encode($_REQUEST);
			die;
		}
	}
}
?>