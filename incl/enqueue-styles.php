<?php

/**
 * @author BAKKBONE Australia
 * @package BbrEnqueueStyles
 * @license GNU General Public License (GPL) 3.0
**/


defined("BBR_EXEC") or die("Silence is golden");

class BbrEnqueueStyles{

	function __construct()
	{
		add_action("wp_enqueue_scripts", array($this, "bbrLoadStyles"));
		if(is_admin()){
			add_action("admin_enqueue_scripts", array($this, "bbrLoadStyles"));
		}
	}
	
	function bbrLoadStyles()
	{
		wp_enqueue_style("bbr_default", BBR_URL . "assets/css/default.css", array(),"1.0.0","all" );
	}
	
}