<?php

defined("ABSPATH") or die;

/*
Plugin Name: Sale Booster
Description: The Best Sale Booster Plugin for Woocommerce.
Version: 1.0.0
Author: WPManageNinja
Author URI: https://wpmanageninja.com
Plugin URI: https://wpmanageninja.com/products/sale-booster-plugin
License: GPLv2 or later
Text Domain: sale_booster
Domain Path: /languages
*/

define("SALE_BOOSTER_PLUGIN_DIR_URL", plugin_dir_url(__FILE__));
define("SALE_BOOSTER_PLUGIN_DIR_PATH", plugin_dir_path(__FILE__));
define("SALE_BOOSTER_PLUGIN_DIR_VERSION", plugin_dir_path(__FILE__));

include "load.php";

class NINJASaleBooster 
{
    public function boot()
    {
        $this->adminHooks();
        $this->loadTextDomain();
        $this->publicHooks();
       
    }

    public function commonHooks(){

    }

    public function adminHooks(){
        add_filter( 'woocommerce_product_data_tabs', array('SaleBooster\Classes\SaleBoosterHandler', 'registerProductDataTab') );
        add_action('woocommerce_product_data_panels', array('SaleBooster\Classes\SaleBoosterHandler', 'createDataFields') );
        add_action( 'woocommerce_process_product_meta', array('SaleBooster\Classes\SaleBoosterHandler','saveDataFields') );
    }

    public function publicHooks(){
        // Alter shop page add to cart button
        add_filter( 'woocommerce_loop_add_to_cart_link',  array('SaleBooster\Classes\SaleBoosterHandler', 'alterShopCartButton'), 10, 2 );
        // remove cart button single page
        add_action( 'woocommerce_single_product_summary', array('SaleBooster\Classes\SaleBoosterHandler', 'removeSingleCartButton'), 1 );
        // custom button add
        add_action( 'woocommerce_single_product_summary', array('SaleBooster\Classes\SaleBoosterHandler', 'addSingleCustomButton'), 30 ); 
        
        // shop Hide Price
        add_filter( 'woocommerce_get_price_html', array('SaleBooster\Classes\SaleBoosterHandler', 'hideShopPrice'), 10, 2 );
        // Single hide price
        add_action('woocommerce_single_product_summary', array('SaleBooster\Classes\SaleBoosterHandler', 'hideSinglePrice'), 1 );
        
        // Discound timer
        add_action('woocommerce_share', array('SaleBooster\Classes\SaleBoosterHandler', 'discoundTimer') );
      
        //woocommerce_before_single_product
        add_action( 'wp_footer', array('SaleBooster\Classes\SaleBoosterHandler','discoundTimerTop') );
       
       
        // enqueue script 
        add_action('wp_enqueue_scripts', array($this, 'enqueueScripts'));
    }

    public function enqueueScripts(){
        if(is_singular('product')) {
            wp_enqueue_script("sale-booster-js", SALE_BOOSTER_PLUGIN_DIR_URL."src/public/js/sale-booster.js", array('jquery'),'1.0.0',true);
            wp_enqueue_style("sale-booster-css", SALE_BOOSTER_PLUGIN_DIR_URL."src/public/css/sale-booster.css", false);
        }
    }


    public function loadTextDomain(){

    }

}

add_action('plugins_loaded', function(){
    $ninjaSaleBooster = new NINJASaleBooster();
    $ninjaSaleBooster->boot();
}); 



// Replacing the single product button add to cart by a custom button for a specific product category

function replace_single_add_to_cart_button() {
    global $product;

    // Only for product category ID 64
    if( has_term( '20', 'product_cat', $product->get_id() ) ){

        // For variable product types (keeping attribute select fields)
        if( $product->is_type( 'variable' ) ) {
            remove_action( 'woocommerce_single_variation', 'woocommerce_single_variation_add_to_cart_button', 20 );
            add_action( 'woocommerce_single_variation', 'custom_product_button', 20 );
        }
        // For all other product types
        else {
            remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
            //add_action( 'woocommerce_single_product_summary', 'custom_product_button', 30 );
        }
    }
}

add_action( 'woocommerce_single_product_summary', 'replace_single_add_to_cart_button', 1 );