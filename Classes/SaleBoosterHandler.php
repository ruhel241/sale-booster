<?php

namespace SaleBooster\Classes;

class SaleBoosterHandler
{

    // register Tab
    public static function registerProductDataTab($product_data_tabs)
    {

        wp_enqueue_style("admin-sale-booster-datepicker", SALE_BOOSTER_PLUGIN_DIR_URL."src/admin/css/admin-sale-booster-datepicker.css", false);
        wp_enqueue_style("admin-sale-booster", SALE_BOOSTER_PLUGIN_DIR_URL."src/admin/css/admin-sale-booster.css", false);

        wp_enqueue_script("admin-sale-booster-datepicker", SALE_BOOSTER_PLUGIN_DIR_URL."src/admin/js/admin-sale-booster-datepicker.full.min.js", array('jquery'), SALE_BOOSTER_PLUGIN_DIR_VERSION, true);
        wp_enqueue_script("admin-sale-booster", SALE_BOOSTER_PLUGIN_DIR_URL."src/admin/js/admin-sale-booster.js", array('jquery'), SALE_BOOSTER_PLUGIN_DIR_VERSION, true);

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
        $layoutSelected = get_post_meta(get_the_ID(), '_sale_booster_expaire_date_layout', true);
        $discound_timer = get_post_meta(get_the_ID(), '_sale_booster_discound_timer', true);

        wp_localize_script('admin-sale-booster', 'sale_booster_discound_timer_vars', array(
            'discound_timer' => $discound_timer,
        ));
        ?>
            <div id="sale_booster_product_data" class="panel woocommerce_options_panel">
                <div class="options_group">
                    <?php
                        // Select alter cart button
                        woocommerce_wp_select(
                            array(
                                'id'       => '_sale_booster_alter_cart_button',
                                'label'    => __('Alter Add to Cart Button', 'sale_booster'),
                                'selected' => true,
                                'options'  => array(
                                    'default'       => __('Default', 'sale_booster'),
                                    'remove_button' => __('Remove Add to Cart Button', 'sale_booster'),
                                )
                            )
                        ); 
                    ?>
                
                    <?php   // Hide Price
                        woocommerce_wp_checkbox(
                            array(
                                'id'          => '_sale_booster_hide_price',
                                'label'       => __('Hide Price', 'sale_booster'),
                                'description' => __('Check me!', 'sale_booster')
                            )
                        );
                    ?> 
                </div> 
                <div class="options_group">
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
                            
                            woocommerce_wp_textarea_input(
                                array(
                                    'id'          => '_sale_booster_note',
                                    'label'       => __('Note', 'sale_booster'),
                                    'placeholder' => 'Prices Go Up When The Timer Hits Zero.',
                                    'desc_tip'    => 'true',
                                    'description' => "Prices Go Up When The Timer Hits Zero."
                                )
                            );

                            woocommerce_wp_text_input(
                                array(
                                    'id'          => '_sale_booster_expire_date_time',
                                    'label'       => __('Coupon Expire Date', 'sale_booster'),
                                    'description' => __('ex: (m/d/yyyy 00:00)', 'sale_booster')
                                )
                            );

                            woocommerce_wp_radio(
                                array(
                                    'label'   => __('Expaire Date Layout', 'woocommerce-price-per-word'),
                                    'id'      => '_sale_booster_expaire_date_layout',
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
        $alter_cart_button = sanitize_text_field($_POST['_sale_booster_alter_cart_button']);
        if (isset($alter_cart_button)) {
            update_post_meta($post_id, '_sale_booster_alter_cart_button', esc_attr($alter_cart_button));
        }
       
        // Save hide price
        $hide_price = isset($_POST['_sale_booster_hide_price']) ? 'yes' : 'no';
        update_post_meta($post_id, '_sale_booster_hide_price', $hide_price);
        
        // save Discound Timer 
        $discound_timer = isset($_POST['_sale_booster_discound_timer']) ? 'yes' : 'no';
        update_post_meta($post_id, '_sale_booster_discound_timer', $discound_timer);

        $note = sanitize_text_field($_POST['_sale_booster_note']);
        if (isset($note)) {
            update_post_meta($post_id, '_sale_booster_note', esc_attr($note));
        }

        // Save expire date
        $expire_datetime = sanitize_text_field($_POST['_sale_booster_expire_date_time']);
        if (isset($expire_datetime)) {
            update_post_meta($post_id, '_sale_booster_expire_date_time', esc_html($expire_datetime));
        }

        $expaire_datelayout = sanitize_text_field($_POST['_sale_booster_expaire_date_layout']);
        if (isset($expaire_datelayout)) {
            update_post_meta($post_id, '_sale_booster_expaire_date_layout', esc_html($expaire_datelayout));
        }

        // Save Hidden field
        $hidden = $_POST['_hidden_field'];
        if (!empty($hidden)) {
            update_post_meta($post_id, '_hidden_field', esc_attr($hidden));
        }
    }

    // remove single cart button
    public static function removeSingleCartButton()
    {   global $product;
        $remove_cart_button = get_post_meta($product->id, '_sale_booster_alter_cart_button', true);
       if ($remove_cart_button == 'remove_button') {
            if(is_product()){
                remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
            }
        }
        
    }

    public static function alterShopCartButton( $button, $product ) {
        if ( is_shop() || is_product_category() ) {
            $alter_cart_button = get_post_meta($product->id, '_sale_booster_alter_cart_button', true);
            if($alter_cart_button == 'remove_button'){
                $button = "";
            } 
        }
        return $button;
    }

    //hide price
    public static function hideSinglePrice()
    {   global $product;
        $hidePrice = get_post_meta($product->id, '_sale_booster_hide_price', true);
        if ($hidePrice == "yes") {
            remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);
        }
    }

    // Shop Price Hide 
    public static function hideShopPrice( $price, $product ) {
        if ( is_shop() || is_product_category() ) {
            $hidePrice = get_post_meta($product->id, '_sale_booster_hide_price', true);
            if($hidePrice == 'yes'){
                return '';
            }
        }
        return $price;
    }
    
    // Bottom discound timer
    public static function discoundTimer()
    {  
        global $product;
        $note = get_post_meta($product->id, '_sale_booster_note', true);
        $expire_datetime = get_post_meta($product->id, '_sale_booster_expire_date_time', true);
        $expire_date_layout = get_post_meta($product->id, '_sale_booster_expaire_date_layout', true);
        $curreent_time =  date('m/d/Y H:i', current_time('timestamp', 0));
       
        if ($curreent_time < $expire_datetime) :
            if ($expire_date_layout == "bottom" || $expire_date_layout == "both") :
                ?>
                    <div class="_sale-booster-countdown-bottom" style="margin-top:20px"> 
                        <div class="_sale-booster-countdown"></div>
                        <p class="_sale-booster-hits"> <?php echo $note; ?> </p>
                    </div>
                <?php
            endif;
        endif;
    }
    // Top Discound Timer 
    public static function discoundTimerTop()
    {   
        global $product;
        $note = get_post_meta($product->id, '_sale_booster_note', true);
        $expire_datetime = get_post_meta($product->id, '_sale_booster_expire_date_time', true);
        $expire_date_layout = get_post_meta($product->id, '_sale_booster_expaire_date_layout', true);
        $curreent_time = date('m/d/Y H:i', current_time('timestamp', 0));
         
        wp_localize_script('sale-booster-js', 'sale_booster_countdown_vars', array(
            'dateTime' => $expire_datetime,
        ));

        if ($curreent_time < $expire_datetime) :
            if ($expire_date_layout == "top" || $expire_date_layout == "both") :
                ?>
                    <div class="_sale-booster-countdown-top">
                        <div class="_sale-booster-countdown-row">
                            <p class="countdown-top-title"><?php echo $note; ?></p>
                            <div class="_sale-booster-countdown"></div>
                        </div>
                    </div>
                <?php
            endif;
        endif;
    }

}

