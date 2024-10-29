<?php

/**
 * Plugin Name: BAKKBONE Billing at Registration
 * Plugin URI: 
 * Description: Allows for WooCommerce billing fields to be collected on the My Account registration page.
 * Version: 1.1.0
 * Author: BAKKBONE Australia
 * Author URI: https://www.bakkbone.com.au/
 * License: GNU General Public License (GPL) 3.0
 * License URI: https://www.gnu.org/licenses/gpl.html
 * Text Domain: bakkbone-billing-at-registration
 * Domain Path: /i18n
**/


if (!defined("WPINC")){
	die;
}

if (!defined("BBR_EXEC")){
	define("BBR_EXEC",true);
}

if (!defined("BBR_DEBUG")){
	define("BBR_DEBUG",false);
}

if (!defined("BBR_FILE")){
	define("BBR_FILE",__FILE__);
}

if (!defined("BBR_PATH")){
	define("BBR_PATH",dirname(__FILE__));
}

if (!defined("BBR_URL")){
	define("BBR_URL",plugins_url("/",__FILE__));
}

include BBR_PATH . "/incl/core.php";
require BBR_PATH . "/incl/enqueue-styles.php";
require BBR_PATH . "/incl/admin-notices.php";
require BBR_PATH . "/incl/settings.php";

function run_bakkbone_billing_at_registration()
{
	$enqueueStyles = new BbrEnqueueStyles();  
	$admin_notices = new BbrAdminNotices();  
	$WooSettings = new SettingsWooSetting();
	$BbrCore = new BbrCore();
}

run_bakkbone_billing_at_registration();