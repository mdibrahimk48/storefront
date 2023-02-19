<?php
/**
 * Storefront engine room
 *
 * @package storefront
 */

/**
 * Assign the Storefront version to a var
 */
$theme              = wp_get_theme( 'storefront' );
$storefront_version = $theme['Version'];

/**
 * Set the content width based on the theme's design and stylesheet.
 */

if ( ! isset( $content_width ) ) {
	$content_width = 980; /* pixels */
}

$storefront = (object) array(
	'version'    => $storefront_version,

	/**
	 * Initialize all the things.
	 */
	'main'       => require 'inc/class-storefront.php',
	'customizer' => require 'inc/customizer/class-storefront-customizer.php',
);

require 'inc/storefront-functions.php';
require 'inc/storefront-template-hooks.php';
require 'inc/storefront-template-functions.php';
require 'inc/wordpress-shims.php';

if ( class_exists( 'Jetpack' ) ) {
	$storefront->jetpack = require 'inc/jetpack/class-storefront-jetpack.php';
}

if ( storefront_is_woocommerce_activated() ) {
	$storefront->woocommerce            = require 'inc/woocommerce/class-storefront-woocommerce.php';
	$storefront->woocommerce_customizer = require 'inc/woocommerce/class-storefront-woocommerce-customizer.php';

	require 'inc/woocommerce/class-storefront-woocommerce-adjacent-products.php';

	require 'inc/woocommerce/storefront-woocommerce-template-hooks.php';
	require 'inc/woocommerce/storefront-woocommerce-template-functions.php';
	require 'inc/woocommerce/storefront-woocommerce-functions.php';
}

if ( is_admin() ) {
	$storefront->admin = require 'inc/admin/class-storefront-admin.php';

	require 'inc/admin/class-storefront-plugin-install.php';
}

/**
 * NUX
 * Only load if wp version is 4.7.3 or above because of this issue;
 * https://core.trac.wordpress.org/ticket/39610?cversion=1&cnum_hist=2
 */
if ( version_compare( get_bloginfo( 'version' ), '4.7.3', '>=' ) && ( is_admin() || is_customize_preview() ) ) {
	require 'inc/nux/class-storefront-nux-admin.php';
	require 'inc/nux/class-storefront-nux-guided-tour.php';
	require 'inc/nux/class-storefront-nux-starter-content.php';
}

/**
 * Note: Do not add any custom code here. Please use a custom plugin so that your customizations aren't lost during updates.
 * https://github.com/woocommerce/theme-customisations
 */


// remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart');
// remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart');

// add_filter('woocommerce_is_purchasable', 'woocommerce_cloudways_purchasable');
// function woocommerce_cloudways_purchasable($cloudways_purchasable, $product) {
// return ($product->id == your_specific_product_id (like 15) ? false : $cloudways_purchasable);
// }


// add_filter( 'wpto_add_to_cart_view' , function(){
// 	return false;
// });


//Remove Cart for Specific Products from Table
add_filter( 'woocommerce_loop_add_to_cart_link', 'remove_add_to_cart_specific_products', 25, 2 );
			  
function remove_add_to_cart_specific_products( $add_to_cart_html, $product ) {
	
	if( 15 === $product->get_id() || 17 === $product->get_id() || $product->is_type( 'variable' ) ) {
		return '';
	}
	return $add_to_cart_html;
	
}


//Remove Cart for Specific Products from Single Page
add_action( 'wp', 'rudr_remove_add_to_cart_single_product' );

function rudr_remove_add_to_cart_single_product(){
	if( is_single(15) || is_single(17) ) { // "10" is a product ID as you remember
		remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
	}
}

/////////////////////
if( !function_exists( 'new_shortcode_column' ) ){
	function new_shortcode_column( $column_array ) {
		$column_array['new_shortcode'] = 'New Shortcode';
		return $column_array;
	}
 }
 add_filter( 'wpto_default_column_arr', 'new_shortcode_column' );



 if( !function_exists( 'temp_file_for_new_shortcode' ) ){
    function temp_file_for_new_shortcode( $file ){
        $file = __DIR__ . '/../file/my_shortcode.php';
        // $file = $your_file_location;
        return $file;
    }
}
add_filter( 'wpto_template_loc_item_{new_shortcode}', 'temp_file_for_new_shortcode', 10 );