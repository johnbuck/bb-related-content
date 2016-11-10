<?php
/*
Plugin Name: Beaver Builder Related Content Module
Plugin URI:
Description: Beaver Builder Related Content Module
Author: Pancake Creative
Version:
Author URI:
*/


define( 'BBRC_MODULES_DIR', plugin_dir_path( __FILE__ ) );
define( 'BBRC_MODULES_URL', plugins_url( '/', __FILE__ ) );

function bbrc_load_module() {
    if ( class_exists( 'FLBuilder' ) ) {
        require_once 'bb-related-content-module/bb-related-content-module.php';
    }
}
add_action( 'init', 'bbrc_load_module' );

function fl_checkbox_field($name, $value, $field, $settings) {
    echo '<input type="checkbox" name="' . $name . '" value="1" '.( $value == 1 ? 'checked' : '' ).'/>';
}

add_action('fl_builder_control_checkbox', 'fl_checkbox_field', 1, 4);

if ( !function_exists('my_get_field') ) {
	function my_get_field( $field ) {
		if ( is_callable('get_field') ) {
			return get_field( $field );
		} else {
			return get_post_meta( get_the_ID(), $field, true );
		}
	}
}
