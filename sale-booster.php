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

include "load.php";
define("SALE_BOOSTER_PLUGIN_DIR_URL", plugin_dir_url(__FILE__));
define("SALE_BOOSTER_PLUGIN_DIR_PATH", plugin_dir_path(__FILE__));
define("SALE_BOOSTER_PLUGIN_DIR_VERSION", plugin_dir_path(__FILE__));



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
        add_action('admin_head', array('SaleBooster\Classes\SaleBoosterHandler', 'customStyles') );
        add_action('woocommerce_product_data_panels', array('SaleBooster\Classes\SaleBoosterHandler', 'createDataFields') );
        add_action( 'woocommerce_process_product_meta', array('SaleBooster\Classes\SaleBoosterHandler','saveDataFields') );
        add_action('admin_enqueue_scripts', array($this, 'adminEnqueueScripts') );
    }


    public function publicHooks(){
        // add_filter('woocommerce_product_single_add_to_cart_text', array('SaleBooster\Classes\SaleBoosterHandler', 'cart_button_text') );
        // add_filter('woocommerce_is_purchasable',  array('SaleBooster\Classes\SaleBoosterHandler', 'removeCartButton'));
        
        // remove cart button
        add_action('woocommerce_single_product_summary', array('SaleBooster\Classes\SaleBoosterHandler', 'removeCartButton'), 1);
        // custom button add
        add_action( 'woocommerce_simple_add_to_cart', array('SaleBooster\Classes\SaleBoosterHandler', 'addCustomButton'), 30 ); 
        // hide price
        add_action('woocommerce_single_product_summary', array('SaleBooster\Classes\SaleBoosterHandler', 'hidePrice'), 2 );
    }


    public function adminEnqueueScripts(){
        wp_enqueue_script("admin-sale-booster", SALE_BOOSTER_PLUGIN_DIR_URL."src/admin/js/admin-sale-booster.js", array('jquery'),'1.0.0',true);
    }


    public function loadTextDomain(){

    }


}


add_action('plugins_loaded', function(){
    $ninjaSaleBooster = new NINJASaleBooster();
    $ninjaSaleBooster->boot();
}); 

