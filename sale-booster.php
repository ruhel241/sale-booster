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
    
        //add_action('admin_enqueue_scripts', array($this, 'adminEnque') );
    }

    public function publicHooks(){
         // remove cart button Loop page
       // add_action('woocommerce_after_shop_loop_item', array('SaleBooster\Classes\SaleBoosterHandler', 'removeCartButton'), 10);
        // remove cart button single page
        //add_action('woocommerce_single_product_summary', array('SaleBooster\Classes\SaleBoosterHandler', 'removeCartButton'), 1);
       
        // remove cart button single page
        add_action( 'woocommerce_single_product_summary', array('SaleBooster\Classes\SaleBoosterHandler', 'removeCartButton'), 1 );



        // remove shop page add to cart
           //add_action( 'woocommerce_after_shop_loop_item', array('SaleBooster\Classes\SaleBoosterHandler', 'removeCartButton'), 10 );




        // custom button add
        add_action( 'woocommerce_simple_add_to_cart', array('SaleBooster\Classes\SaleBoosterHandler', 'addCustomButton'), 30 ); 
        // hide price
        add_action('woocommerce_single_product_summary', array('SaleBooster\Classes\SaleBoosterHandler', 'hidePrice'), 1 );
        // Discound timer
        add_action('woocommerce_share', array('SaleBooster\Classes\SaleBoosterHandler', 'discoundTimer') );
        add_action( 'woocommerce_before_single_product', array('SaleBooster\Classes\SaleBoosterHandler','discoundTimerTop') );
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

