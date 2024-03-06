<?php
/**
 * Plugin Name: WPS Product Search Field Exclude Categories
 * Plugin URI: https://github.com/geotsiokos/groups-notifications-alternative-notifications
 * Description: Exclude product categories when using the Product Search Field by <a href="https://woo.com/products/woocommerce-product-search/">WooCommerce Product Search</a> 
 * Version: 1.0.0
 * Author: gtsiokos
 * Author URI: http://www.netpad.gr
 * Donate-Link: http://www.netpad.gr
 * License: GPLv3
 */

if ( !defined( 'ABSPATH' ) ) {
	exit;
}
class WPS_Product_Search_Field_Exclude_Categories {

	public static function init() {
		add_action( 'wp_ajax_product_search', array( __CLASS__, 'wp_ajax_product_search' ), 9 );
		add_action( 'wp_ajax_nopriv_product_search', array( __CLASS__, 'wp_ajax_product_search' ), 9 );
	}

	public static function example_wp_ajax_product_search() {
		add_filter( 'woocommerce_product_object_query_args', array( __CLASS__, 'woocommerce_product_object_query_args' ) );
	}

	public static function example_woocommerce_product_object_query_args( $query_args ) {
		$excluded_categories = array( 19, 18 ); // category ids to exclude from search results
		$all_categories = get_terms(
			array(
				'fields'   => 'ids',
				'taxonomy' => 'product_cat',
				'exclude'  => $excluded_categories
			)
		);
		if ( !is_wp_error( $all_categories ) ) {
			foreach ( $all_categories as $category ) {
				$included_categories[] = $category;
			}
			if ( count( $included_categories ) > 0 ) {
				$query_args['category'] = $included_categories;
			}
		}
		return $query_args;
	}
} WPS_Product_Search_Field_Exclude_Categories::init();