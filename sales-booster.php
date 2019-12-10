<?php
/*
Plugin Name: Sales Booster for WooCommerce
Description: The Best Sale Booster Plugin for Woocommerce.
Version: 1.5.0
Author: Footnote.io
Author URI: https://footnote.io
Plugin URI: https://footnote.io/downloads/sales-booster-pro-for-woocommerce/
License: GPLv2 or later
Text Domain: sale_booster
Domain Path: /languages
*/

defined("ABSPATH") or die;

class WooSaleBoosterLite
{
    /**
     * @var NINJASaleBoosterPro The only instance
     * @since 1.0
     */
    private static $instance;

    public static function instance()
    {
        if(defined('SALES_BOOTER_PRO_INSTALLED')) {
            return false;
        }

        if (!isset(self::$instance) && !(self::$instance instanceof WooSaleBoosterLite)) {
            self::$instance = new WooSaleBoosterLite;
            self::$instance->loadDependecies();
            self::loadTextDomain();
            self::$instance->boot();
        }

        return self::$instance;
    }

    public function boot()
    {
        if (is_admin()) {
            $this->adminHooks();
        }
        $this->loadTextDomain();
        $this->publicHooks();
   }

    private function loadDependecies()
    {
        include_once 'Classes/ProductSettings.php';
        include_once 'Classes/Customization.php';
        include_once 'Classes/FrontendHandler.php';
        define("SALE_BOOSTER_PLUGIN_DIR_URL", plugin_dir_url(__FILE__));
        define("SALE_BOOSTER_PLUGIN_DIR_PATH", plugin_dir_path(__FILE__));
        define("SALES_BOOSTER_PRO_URL", 'https://footnote.io/downloads/sales-booster-pro-for-woocommerce/');
        define("SALE_BOOSTER_PLUGIN_DIR_VERSION", '1.5.0');
    }

    public function adminHooks()
    {
        add_filter('woocommerce_product_data_tabs', array('SaleBooster\Classes\ProductSettings', 'registerProductDataTab'));
        add_action('woocommerce_product_data_panels', array('SaleBooster\Classes\ProductSettings', 'createDataFields'));
        add_action('woocommerce_process_product_meta', array('SaleBooster\Classes\ProductSettings', 'saveDataFields'));
        add_filter( 'woocommerce_get_settings_pages', array('SaleBooster\Classes\Customization', 'saleBoosterAddSettings'), 15, 1 );
    }

    public function publicHooks()
    {
        // Remove add to cart button on shop page 
        add_filter('woocommerce_loop_add_to_cart_link', array('SaleBooster\Classes\FrontendHandler', 'removeShopCartButton'), 10, 2);
        
        // Custom Text add to cart button on shop page
        add_filter( 'woocommerce_product_add_to_cart_text', array('SaleBooster\Classes\FrontendHandler', 'customTextAddToCartShop'), 30, 1);
        // Custom Text add to cart button on Single page
        add_filter( 'woocommerce_product_single_add_to_cart_text', array('SaleBooster\Classes\FrontendHandler', 'customTextAddToCartSingle'), 30, 1);

        // remove cart button single page
        add_action('woocommerce_single_product_summary', array('SaleBooster\Classes\FrontendHandler', 'removeSingleCartButton'), 1);

        // shop Hide Price
        add_filter('woocommerce_get_price_html', array('SaleBooster\Classes\FrontendHandler', 'hideShopPrice'), 10, 2);
        // Single hide price
        add_action('woocommerce_single_product_summary', array('SaleBooster\Classes\FrontendHandler', 'hideSinglePrice'), 1);
        // discount timer
        add_action('wp', array('SaleBooster\Classes\FrontendHandler', 'initSaleBooster'));

        add_action( 'woocommerce_before_shop_loop', array('SaleBooster\Classes\FrontendHandler','shopPageBannerTop'), 10 );
        add_action( 'woocommerce_after_shop_loop', array('SaleBooster\Classes\FrontendHandler','shopPageBannerBottom'), 5 );
        add_action( 'wp_footer', array('SaleBooster\Classes\FrontendHandler','shopPageCornerAd'));
        add_action('wp_head',  array('SaleBooster\Classes\FrontendHandler', 'shopPageExitPopup') );
    }

    public function loadTextDomain()
    {
        load_plugin_textdomain('sale_booster', false, basename(dirname(__FILE__)) . '/languages');
    }

}

add_action('plugins_loaded', function () {
    if(!defined('SALES_BOOTER_PRO_INSTALLED')) {
        WooSaleBoosterLite::instance();
    }
});



