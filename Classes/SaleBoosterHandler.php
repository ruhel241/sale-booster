<?php

namespace SaleBooster\Classes;

class SaleBoosterHandler
{

    // register Tab
    public static function registerProductDataTab($product_data_tabs)
    {

        wp_enqueue_style("admin-sale-booster-datepicker", SALE_BOOSTER_PLUGIN_DIR_URL."src/admin/css/admin-sale-booster-datepicker.css", false);
        wp_enqueue_style("admin-sale-booster", SALE_BOOSTER_PLUGIN_DIR_URL."src/admin/css/admin-sale-booster.css", false);

        wp_enqueue_script("admin-sale-booster-datepicker", SALE_BOOSTER_PLUGIN_DIR_URL."src/admin/js/admin-sale-booster-datepicker.full.min.js", array('jquery'), '1.0.0', true);
        wp_enqueue_script("admin-sale-booster", SALE_BOOSTER_PLUGIN_DIR_URL."src/admin/js/admin-sale-booster.js", array('jquery'), '1.0.0', true);

       

        $product_data_tabs['_sale_booster'] = array(
            'label'  => esc_html__('Sale Booster', 'sale_booster'),
            'target' => 'sale_booster_product_data',
            'class'  => array('show_if_sale_booster_product_data'),
        );
        return $product_data_tabs;
    }

    // create Data Fields
    public static function createDataFields()
    {
        $layoutSelected = get_post_meta(get_the_ID(), '_Sale_booster_expaire_date_layout', true);
        $discound_timer = get_post_meta(get_the_ID(), '_sale_booster_discound_timer', true);

        wp_localize_script('admin-sale-booster', 'sale_booster_discound_timer_vars', array(
            'discound_timer' => $discound_timer,
        ));
    ?>
        <div id="sale_booster_product_data" class="panel woocommerce_options_panel">
            <div class="options_group">
    <?php
         // Select
        woocommerce_wp_select(
            array(
                'id'       => '_sale_booster_alter_cart_button',
                'label'    => __('Alter Add to Cart Button', 'sale_booster'),
                'selected' => true,
                'options'  => array(
                    'default'       => __('Default', 'sale_booster'),
                    'remove_button' => __('Remove Add to Cart Button', 'sale_booster'),
                    'inquire_us'    => __('Show Inquire Us Button', 'sale_booster')
                )

            )
        ); 
    ?>
     <div class="_sale_booster_inquire">
    <?php
        // Text Field
        woocommerce_wp_text_input(
            array(
                'id'          => '_sale_booster_inquire_text',
                'label'       => __('Inquire Us Text', 'sale_booster'),
                'placeholder' => 'Inquire Us',
                'desc_tip'    => 'true',
                'description' => __('Inquire Us Text.', 'sale_booster')
            )
        );
        // Inquire Us link Field
        woocommerce_wp_text_input(
            array(
                'id'          => '_sale_booster_inquire_link',
                'label'       => __('Inquire Us Link', 'sale_booster'),
                'placeholder' => 'http://',
                'desc_tip'    => 'true',
                'description' => __('Enter the URL to Inquire Us button.', 'sale_booster'),
            )
        );
    ?> 
      </div> 
    <?php        // Checkbox
        woocommerce_wp_checkbox(
            array(
                'id'          => '_sale_booster_hide_price',
                'label'       => __('Hide Price', 'sale_booster'),
                'description' => __('Check me!', 'sale_booster')
            )
        );
    ?> 
        </div> <div class="options_group">
    <?php
        woocommerce_wp_checkbox(
            array(
                'id'          => '_sale_booster_discound_timer',
                'label'       => __('Discound Timer', 'sale_booster'),
                'description' => __('Show / Hide', 'sale_booster'),
            )
        );
    ?> 
       <div id="_sale_booster_discoundtimer_showhide">
    <?php
            woocommerce_wp_text_input(
                array(
                    'id'          => '_sale_booster_alert_text',
                    'label'       => __('Alert Text', 'sale_booster'),
                    'placeholder' => 'Hurry up! just 8 items left in stock',
                    'desc_tip'    => 'true',
                    'description' => __('Hurry up! just 8 items left in stock.', 'sale_booster')
                )
            );

            woocommerce_wp_text_input(
                array(
                    'id'          => '_sale_booster_subtitle',
                    'label'       => __('Sub Title', 'sale_booster'),
                    'placeholder' => 'Prices Go Up When The Timer Hits Zero.',
                    'desc_tip'    => 'true',
                    'description' => "Prices Go Up When The Timer Hits Zero."
                )
            );

            woocommerce_wp_text_input(
                array(
                    'id'          => '_sale_booster_expire_date_time',
                    //'type'        => 'datetime-local',
                    'label'       => __('Coupon Expire Date', 'sale_booster'),
                    //'placeholder' => '07/15/2015 12:30 PM',
                    'description' => __('ex: (m/d/yyyy 00:00)', 'sale_booster')
                )
            );

            woocommerce_wp_radio(
                array(
                    //'name' => '_price_per_word_character',
                    'label'   => __('Expaire Date Layout', 'woocommerce-price-per-word'),
                    'id'      => '_Sale_booster_expaire_date_layout',
                    'value'   => !empty($layoutSelected) ? $layoutSelected : "both",
                    'options' => array(
                        'top'    => __("Top", 'sale_booster'),
                        'bottom' => __("Bottom", 'sale_booster'),
                        'both'   => __("Both", 'sale_booster')
                    ),
                )
            );
    ?> 
            </div>
            </div>
        </div>
     <?php
    }

    //save Data Fields
    public static function saveDataFields($post_id)
    {

        // Save Select
        $alter_cart_button = $_POST['_sale_booster_alter_cart_button'];
        if (!empty($alter_cart_button)) {
            update_post_meta($post_id, '_sale_booster_alter_cart_button', esc_attr($alter_cart_button));
        }
        // Save inquire Text Field
        $inquire_text = $_POST['_sale_booster_inquire_text'];
        if (!add_post_meta($post_id, '_sale_booster_inquire_text', 'Buy Now', true)) {
            update_post_meta($post_id, '_sale_booster_inquire_text', esc_attr($inquire_text));
        }

        // inquire link
        $inquire_us_link = $_POST['_sale_booster_inquire_link'];
        if (isset($inquire_us_link)) {
            update_post_meta($post_id, '_sale_booster_inquire_link', esc_attr($inquire_us_link));
        }

        // Save hide price
        $hide_price = isset($_POST['_sale_booster_hide_price']) ? 'yes' : 'no';
        update_post_meta($post_id, '_sale_booster_hide_price', $hide_price);
        
        // save Discound Timer 
        $discound_timer = isset($_POST['_sale_booster_discound_timer']) ? 'yes' : 'no';
        update_post_meta($post_id, '_sale_booster_discound_timer', $discound_timer);

        // Save Alert Text Field
        $alert_text = $_POST['_sale_booster_alert_text'];
        if (isset($alert_text)) {
            update_post_meta($post_id, '_sale_booster_alert_text', esc_attr($alert_text));
        }

        $subtitle = $_POST['_sale_booster_subtitle'];
        if (isset($subtitle)) {
            update_post_meta($post_id, '_sale_booster_subtitle', esc_attr($subtitle));
        }

        // Save expire date
        $expire_datetime = $_POST['_sale_booster_expire_date_time'];
        if (isset($expire_datetime)) {
            update_post_meta($post_id, '_sale_booster_expire_date_time', esc_html($expire_datetime));
        }

        $_expaire_datelayout = $_POST['_Sale_booster_expaire_date_layout'];
        if (!empty($_expaire_datelayout)) {
            update_post_meta($post_id, '_Sale_booster_expaire_date_layout', esc_html($_expaire_datelayout));
        }

        // Save Hidden field
        $hidden = $_POST['_hidden_field'];
        if (!empty($hidden)) {
            update_post_meta($post_id, '_hidden_field', esc_attr($hidden));
        }
    }

    // remove cart button
    public static function removeCartButton()
    {   global $product;

        $remove_cart_button = get_post_meta($product->id, '_sale_booster_alter_cart_button', true);
        if ($remove_cart_button == 'remove_button' || $remove_cart_button == 'inquire_us') {
            if(is_product()){
                var_dump($product->id);
                remove_action('woocommerce_simple_add_to_cart', 'woocommerce_simple_add_to_cart', 30);
            }



            if(is_shop()){
               
                // if($product->id == 12){
                //     echo "ruhel"; 
                //     // var_dump($product->id);
                //     remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
                //     //remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart',30);
                // }
                
            }



            
           
        }
    }


   

    
    // function wpblog_specific_product($purchaseable_product_wpblog, $product) {
    // return ($product->id == specific_product_id (512) ? false : $purchaseable_product_wpblog);
    // }
    


    // Added custom button
    public static function addCustomButton()
    {
        $cart_ButtonText = get_post_meta(get_the_ID(), '_sale_booster_inquire_text', true);
        $cart_ButtonTextLink = get_post_meta(get_the_ID(), '_sale_booster_inquire_link', true);
        $alter_cart_button = get_post_meta(get_the_ID(), '_sale_booster_alter_cart_button', true);

        if ($alter_cart_button == 'inquire_us') {
            echo "<a href='" . $cart_ButtonTextLink . "' class='single_add_to_cart_button button alt' target='_blank'>" . $cart_ButtonText . "</a>";
        }
    }

    //hide price
    public static function hidePrice()
    {
        $hidePrice = get_post_meta(get_the_ID(), '_sale_booster_hide_price', true);
        if ($hidePrice == "yes") {
            remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);
        }
    }

    public static function discoundTimer()
    {
        $_alert_text = get_post_meta(get_the_ID(), '_sale_booster_alert_text', true);
        $subtitle = get_post_meta(get_the_ID(), '_sale_booster_subtitle', true);

        $_expire_datetime = get_post_meta(get_the_ID(), '_sale_booster_expire_date_time', true);
        $_expire_date_layout = get_post_meta(get_the_ID(), '_Sale_booster_expaire_date_layout', true);
        $curreent_time =  date('m/d/Y H:i', current_time('timestamp', 0));
       
        if ($curreent_time <= $_expire_datetime) {
            if ($_expire_date_layout == "bottom" || $_expire_date_layout == "both") {
                echo "<div class='_sale-booster-discoun-timer' style='margin-top:20px'> 
                    <div class='_alert-text'> " . $_alert_text . "</div> 
                    <div id='_sale-booster-countdown-bottom' class='_sale-booster-countdown'></div>
                    <div class='_sale-booster-hits'> " . $subtitle . " </div>
                </div>";
            }
        }
    }

    public static function discoundTimerTop()
    {
        $_expire_datetime = get_post_meta(get_the_ID(), '_sale_booster_expire_date_time', true);
        $_expire_date_layout = get_post_meta(get_the_ID(), '_Sale_booster_expaire_date_layout', true);
        $curreent_time = date('m/d/Y H:i', current_time('timestamp', 0));
         
        wp_localize_script('sale-booster-js', 'sale_booster_countdown_vars', array(
            'dateTime' => $_expire_datetime,
        ));

        if ($curreent_time <= $_expire_datetime) {
            if ($_expire_date_layout == "top" || $_expire_date_layout == "both") {
                echo "<div id='_sale-booster-countdown-top' class='_sale-booster-countdown'></div>";
            }
        }
    }

}

