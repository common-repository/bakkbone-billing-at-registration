<?php

/**
 * @author BAKKBONE Australia
 * @package BbrCore
 * @license GNU General Public License (GPL) 3.0
**/

defined("BBR_EXEC") or die("Silence is golden");

class BbrCore{
function __construct() {
    add_filter( 'plugin_action_links_bakkbone-billing-at-registration/bakkbone-billing-at-registration.php', array($this, 'bbr_settings_link') );
    add_action( 'woocommerce_register_form_start', array($this, 'bbr_extra_register_fields') );
    add_action( 'woocommerce_register_post', array($this, 'bbr_validate_extra_register_fields'), 10, 3 );
    add_action( 'woocommerce_created_customer', array($this, 'bbr_save_extra_register_fields') );
}

function bbr_settings_link( $links ) {
	$url = esc_url( add_query_arg(
	    array(
		'page'      =>  'wc-settings',
		'tab'       =>  'account',
		'section'   =>  'bbr_settings'
		),
		get_admin_url() . 'admin.php'
	) );
	$settings_link = "<a href='$url'>" . __( 'Settings' ) . '</a>';
	array_push(
		$links,
		$settings_link
	);
	return $links;
}

function bbr_extra_register_fields() {
	if(get_option("bbr_first_name") == "required") {
		?>
		<p class="form-row form-row-first">
			<label for="reg_billing_first_name"><?php _e( 'First name', 'woocommerce' ); ?> <span class="required">*</span></label>
			<input type="text" class="input-text" name="billing_first_name" id="reg_billing_first_name" value="<?php if ( ! empty( $_POST['billing_first_name'] ) ) esc_attr_e( $_POST['billing_first_name'] ); ?>" />
        </p>
		<?php
	}else{
	    if(get_option("bbr_first_name") == "optional") {
    		?>
		<p class="form-row form-row-first">
			<label for="reg_billing_first_name"><?php _e( 'First name (optional)', 'woocommerce' ); ?></label>
			<input type="text" class="input-text" name="billing_first_name" id="reg_billing_first_name" value="<?php if ( ! empty( $_POST['billing_first_name'] ) ) esc_attr_e( $_POST['billing_first_name'] ); ?>" />
        </p>
		<?php
	    }
	}
	
	if(get_option("bbr_last_name") == "required") {
		?>
    	<p class="form-row form-row-last">
    		<label for="reg_billing_last_name"><?php _e( 'Last name', 'woocommerce' ); ?> <span class="required">*</span></label>
    		<input type="text" class="input-text" name="billing_last_name" id="reg_billing_last_name" value="<?php if ( ! empty( $_POST['billing_last_name'] ) ) esc_attr_e( $_POST['billing_last_name'] ); ?>" />
    	</p>
		<?php
	}else{
	    if(get_option("bbr_last_name") == "optional") {
    		?>
    	<p class="form-row form-row-last">
    		<label for="reg_billing_last_name"><?php _e( 'Last name (optional)', 'woocommerce' ); ?></label>
    		<input type="text" class="input-text" name="billing_last_name" id="reg_billing_last_name" value="<?php if ( ! empty( $_POST['billing_last_name'] ) ) esc_attr_e( $_POST['billing_last_name'] ); ?>" />
    	</p>
		<?php	        
	    }
	}
	
	if(get_option("bbr_company") == "required") {
		?>
		<p class="form-row form-row-wide">
			<label for="reg_billing_company"><?php _e( 'Company', 'woocommerce' ); ?> <span class="required">*</span></label>
			<input type="text" class="input-text" name="billing_company" id="reg_billing_company" value="<?php esc_attr_e( $_POST['billing_company'] ); ?>" />
		</p>
		<?php
	}else{
	    if(get_option("bbr_company") == "optional") {
		?>
		<p class="form-row form-row-wide">
			<label for="reg_billing_company"><?php _e( 'Company (optional)', 'woocommerce' ); ?></label>
			<input type="text" class="input-text" name="billing_company" id="reg_billing_company" value="<?php esc_attr_e( $_POST['billing_company'] ); ?>" />
		</p>
		<?php	        
	    }
	}
	
	if(get_option("bbr_country") == "required") {
	    $field = [
        'type' => 'country',
        'label' => 'Country',
        'required' => 1,
        'class' => ['address-field']
        ];
        woocommerce_form_field( 'billing_country', $field, '' );
	}else{if(get_option("bbr_country") == "optional"){
	    $field = [
        'type' => 'country',
        'label' => 'Country',
        'required' => 0,
        'class' => ['address-field']
        ];
        woocommerce_form_field( 'billing_country', $field, '' );
	}
	}

	if(get_option("bbr_address_1") == "required") {
		?>
		<p class="form-row form-row-wide">
			<label for="reg_billing_address_1"><?php _e( 'Address Line 1', 'woocommerce' ); ?> <span class="required">*</span></label>
			<input type="text" class="input-text" name="billing_address_1" id="reg_billing_address_1" value="<?php esc_attr_e( $_POST['billing_address_1'] ); ?>" />
		</p>
		<?php
	}else{
	    if(get_option("bbr_address_1") == "optional") {
		?>
		<p class="form-row form-row-wide">
			<label for="reg_billing_address_1"><?php _e( 'Address Line 1 (optional)', 'woocommerce' ); ?></label>
			<input type="text" class="input-text" name="billing_address_1" id="reg_billing_address_1" value="<?php esc_attr_e( $_POST['billing_address_1'] ); ?>" />
		</p>
		<?php	        
	    }
	}

	if(get_option("bbr_address_2") == "required") {
		?>
		<p class="form-row form-row-wide">
			<label for="reg_billing_address_2"><?php _e( 'Address Line 2', 'woocommerce' ); ?> <span class="required">*</span></label>
			<input type="text" class="input-text" name="billing_address_2" id="reg_billing_address_2" value="<?php esc_attr_e( $_POST['billing_company'] ); ?>" />
		</p>
		<?php
	}else{
	    if(get_option("bbr_address_2") == "optional") {
		?>
		<p class="form-row form-row-wide">
			<label for="reg_billing_address_2"><?php _e( 'Address Line 2 (optional)', 'woocommerce' ); ?></label>
			<input type="text" class="input-text" name="billing_address_2" id="reg_billing_address_2" value="<?php esc_attr_e( $_POST['billing_company'] ); ?>" />
		</p>
		<?php	        
	    }
	}

	if(get_option("bbr_city") == "required") {
		?>
		<p class="form-row form-row-wide">
			<label for="reg_billing_city"><?php _e( 'City', 'woocommerce' ); ?> <span class="required">*</span></label>
			<input type="text" class="input-text" name="billing_city" id="reg_billing_city" value="<?php esc_attr_e( $_POST['billing_company'] ); ?>" />
		</p>
		<?php
	}else{
	    if(get_option("bbr_address_2") == "optional") {
		?>
		<p class="form-row form-row-wide">
			<label for="reg_billing_city"><?php _e( 'City (optional)', 'woocommerce' ); ?></label>
			<input type="text" class="input-text" name="billing_city" id="reg_billing_city" value="<?php esc_attr_e( $_POST['billing_company'] ); ?>" />
		</p>
		<?php
	    }	    
	}

	if(get_option("bbr_postcode") == "required") {
		?>
		<p class="form-row form-row-wide">
			<label for="reg_billing_postcode"><?php _e( 'Postcode', 'woocommerce' ); ?> <span class="required">*</span></label>
			<input type="text" class="input-text" name="billing_postcode" id="reg_billing_postcode" value="<?php esc_attr_e( $_POST['billing_company'] ); ?>" />
		</p>
		<?php
	}else{
	    if(get_option("bbr_address_2") == "optional") {
		?>
		<p class="form-row form-row-wide">
			<label for="reg_billing_postcode"><?php _e( 'Postcode (optional)', 'woocommerce' ); ?></label>
			<input type="text" class="input-text" name="billing_postcode" id="reg_billing_postcode" value="<?php esc_attr_e( $_POST['billing_company'] ); ?>" />
		</p>
		<?php
	    }
	}
	if(get_option("bbr_state") == "required") {
		$field = [
		    'type' => 'state',
		    'label' => 'State',
		    'required' => 1,
		    'class' => ['address-field'],
		    'validate' => ['state']
		];
		woocommerce_form_field( 'billing_state', $field, '' );
	}else{
	    if(get_option("bbr_state") == "optional") {
		$field = [
		    'type' => 'state',
		    'label' => 'State',
		    'required' => 0,
		    'class' => ['address-field'],
		    'validate' => ['state']
		];
		woocommerce_form_field( 'billing_state', $field, '' );
	    }
	}

	if(get_option("bbr_phone") == "required") {
		?>
		<p class="form-row form-row-wide">
			<label for="reg_billing_phone"><?php _e( 'Phone', 'woocommerce' ); ?> <span class="required">*</span></label>
			<input type="text" class="input-text" name="billing_phone" id="reg_billing_phone" value="<?php esc_attr_e( $_POST['billing_company'] ); ?>" />
		</p>
		<?php
	}else{
	    if(get_option("bbr_phone") == "optional") {
		?>
		<p class="form-row form-row-wide">
			<label for="reg_billing_phone"><?php _e( 'Phone (optional)', 'woocommerce' ); ?></label>
			<input type="text" class="input-text" name="billing_phone" id="reg_billing_phone" value="<?php esc_attr_e( $_POST['billing_company'] ); ?>" />
		</p>
		<?php
	    }
	}
	?>
	<div class="clear"></div>
	<?php
	}

function bbr_validate_extra_register_fields( $username, $email, $validation_errors ) {
	if(get_option("bbr_first_name") == "required") {
	    if ( isset( $_POST['billing_first_name'] ) && empty( $_POST['billing_first_name'] ) ) {
              $validation_errors->add( 'billing_first_name_error', __( '<strong>Error</strong>: First name is required!', 'woocommerce' ) );
       }
	}
	if(get_option("bbr_last_name") == "required") {
       if ( isset( $_POST['billing_last_name'] ) && empty( $_POST['billing_last_name'] ) ) {
              $validation_errors->add( 'billing_last_name_error', __( '<strong>Error</strong>: Last name is required!', 'woocommerce' ) );
       }
	}
	if(get_option("bbr_company") == "required") {
       if ( isset( $_POST['billing_company'] ) && empty( $_POST['billing_company'] ) ) {
              $validation_errors->add( 'billing_company_error', __( '<strong>Error</strong>: Company is required!', 'woocommerce' ) );
       }
	}
	if(get_option("bbr_address_1") == "required") {
       if ( isset( $_POST['billing_address_1'] ) && empty( $_POST['billing_address_1'] ) ) {
              $validation_errors->add( 'billing_address_1_error', __( '<strong>Error</strong>: Address Line 1 is required!', 'woocommerce' ) );
       }
	}
	if(get_option("bbr_address_2") == "required") {
       if ( isset( $_POST['billing_address_2'] ) && empty( $_POST['billing_address_2'] ) ) {
              $validation_errors->add( 'billing_address_2_error', __( '<strong>Error</strong>: Address Line 2 is required!', 'woocommerce' ) );
       }
	}
	if(get_option("bbr_city") == "required") {
       if ( isset( $_POST['billing_city'] ) && empty( $_POST['billing_city'] ) ) {
              $validation_errors->add( 'billing_city_error', __( '<strong>Error</strong>: City is required!', 'woocommerce' ) );
       }
	}
	if(get_option("bbr_postcode") == "required") {
       if ( isset( $_POST['billing_postcode'] ) && empty( $_POST['billing_postcode'] ) ) {
              $validation_errors->add( 'billing_postcode_error', __( '<strong>Error</strong>: Postcode is required!', 'woocommerce' ) );
       }
	}
	if(get_option("bbr_country") == "required") {
       if ( isset( $_POST['billing_country'] ) && empty( $_POST['billing_country'] ) ) {
              $validation_errors->add( 'billing_country_error', __( '<strong>Error</strong>: Country is required!', 'woocommerce' ) );
       }
	}
	if(get_option("bbr_state") == "required") {
       if ( isset( $_POST['billing_state'] ) && empty( $_POST['billing_state'] ) ) {
              $validation_errors->add( 'billing_state_error', __( '<strong>Error</strong>: State is required!', 'woocommerce' ) );
       }
	}
	if(get_option("bbr_phone") == "required") {
       if ( isset( $_POST['billing_phone'] ) && empty( $_POST['billing_phone'] ) ) {
              $validation_errors->add( 'billing_phone_error', __( '<strong>Error</strong>: Phone is required!', 'woocommerce' ) );
       }
	}
          return $validation_errors;
 }
 
function bbr_save_extra_register_fields( $customer_id ) {
     if ( isset( $_POST['billing_first_name'] ) ) {
                  update_user_meta( $customer_id, 'first_name', sanitize_text_field( $_POST['billing_first_name'] ) );
                  update_user_meta( $customer_id, 'billing_first_name', sanitize_text_field( $_POST['billing_first_name'] ) );
           }
       if ( isset( $_POST['billing_last_name'] ) ) {
                  update_user_meta( $customer_id, 'last_name', sanitize_text_field( $_POST['billing_last_name'] ) );
                  update_user_meta( $customer_id, 'billing_last_name', sanitize_text_field( $_POST['billing_last_name'] ) );
           }
     if ( isset( $_POST['billing_company'] ) ) {
                  update_user_meta( $customer_id, 'billing_company', sanitize_text_field( $_POST['billing_company'] ) );
           }
     if ( isset( $_POST['billing_address_1'] ) ) {
                  update_user_meta( $customer_id, 'billing_address_1', sanitize_text_field( $_POST['billing_address_1'] ) );
           }
     if ( isset( $_POST['billing_address_2'] ) ) {
                  update_user_meta( $customer_id, 'billing_address_2', sanitize_text_field( $_POST['billing_address_2'] ) );
           }
     if ( isset( $_POST['billing_city'] ) ) {
                  update_user_meta( $customer_id, 'billing_city', sanitize_text_field( $_POST['billing_city'] ) );
           }
     if ( isset( $_POST['billing_postcode'] ) ) {
                  update_user_meta( $customer_id, 'billing_postcode', sanitize_text_field( $_POST['billing_postcode'] ) );
           }
     if ( isset( $_POST['billing_country'] ) ) {
                  update_user_meta( $customer_id, 'billing_country', sanitize_text_field( $_POST['billing_country'] ) );
           }
     if ( isset( $_POST['billing_state'] ) ) {
                  update_user_meta( $customer_id, 'billing_state', sanitize_text_field( $_POST['billing_state'] ) );
           }
     if ( isset( $_POST['billing_phone'] ) ) {
                  update_user_meta( $customer_id, 'billing_phone', sanitize_text_field( $_POST['billing_phone'] ) );
           }

 }
 
}