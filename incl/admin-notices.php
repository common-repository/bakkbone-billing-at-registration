<?php

/**
 * @author BAKKBONE Australia
 * @package BbrAdminNotices
 * @license GNU General Public License (GPL) 3.0
**/

defined("BBR_EXEC") or die("Silence is golden");

class BbrAdminNotices{

	function __construct()
	{
		if (!in_array("woocommerce/woocommerce.php", apply_filters("active_plugins", get_option("active_plugins")))){
			add_action("admin_notices",array($this,"bbrWooSettingsNotice"));
		}
		if (in_array("woocommerce/woocommerce.php", apply_filters("active_plugins", get_option("active_plugins"))) && get_option('woocommerce_enable_myaccount_registration') == 'no') {
			add_action("admin_notices",array($this,"bbrWooCompatibilityNotice"));
		}
	    add_action('wp_ajax_bbr_fix', array($this, 'bbr_fix'));
	}

	function bbrWooSettingsNotice( $admin_notice){
		$plugin_data = get_plugin_data(BBR_FILE);
		echo '<div id="message-woo-settings" class="error notice">
			<p>'. sprintf(__('<strong>%s</strong> requires <a href="https://woocommerce.com/">WooCommerce</a> plugin to be installed and activated on your site.','bakkbone-billing-at-registration'), $plugin_data["Name"]).'</p>
		</div>';
	}
	
	function bbrWooCompatibilityNotice( $admin_notice){
		$plugin_data = get_plugin_data(BBR_FILE);
	    $nonce = wp_create_nonce("bbr_fix");
	    $ajaxurl = admin_url('admin-ajax.php?action=bbr_fix&nonce='.$nonce);
		echo '<div id="message-woo-compatibility" class="error notice is-dismissable">
			<p>'. sprintf(__('<strong>%s</strong> requires the <strong>Allow customers to create an account on the "My account" page</strong> setting to be checked, to be able to function. <a href="'. $ajaxurl . '">Please click here to rectify automatically</a>','bakkbone-billing-at-registration'), $plugin_data["Name"]).'</p>
		</div>';
	}

    function bbr_fix(){
        if ( !wp_verify_nonce( $_REQUEST['nonce'], "bbr_fix")) {
          exit("No funny business please");
        }
        update_option('woocommerce_enable_myaccount_registration', 'yes');
		
        if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
      $result = json_encode($result);
      echo $result;
   }
   else {        
      header("Location: ".$_SERVER["HTTP_REFERER"]);
   }
   die();
    }	
	
}