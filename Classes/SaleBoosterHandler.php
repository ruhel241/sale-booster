<?php

namespace SaleBooster\Classes;

class SaleBoosterHandler {

    // register Tab
    public static function registerProductDataTab($product_data_tabs){
        $product_data_tabs['_sale_booster'] = array(
            'label' => esc_html__( 'Sale Booster', 'sale_booster' ),
            'target' => 'sale_booster_product_data',
            'class'   => array( 'show_if_sale_booster_product_data'  ),
        );
        return $product_data_tabs;
    }

    // Custom icon Css 
    public static function customStyles() {
        echo '<style>#woocommerce-product-data ul.wc-tabs li._sale_booster_options a::before {
        font-family: Dashicons;
        content: "\f182";
        }
        input#_sale_booster_expire_date_time {
            width: 200px;
        }
        ._sale_booster_inquire {
            display: none;
        }

      ._Sale_booster_expaire_date_layout_field > ul{
            display: flex !important;
        }
        ._Sale_booster_expaire_date_layout_field li {
            margin-right: 10px !important;
        }

        </style>';
    }
    // create Data Fields 
    public static function createDataFields(){
         global $post;
         $layoutSelected = get_post_meta(get_the_ID(), '_Sale_booster_expaire_date_layout', true);
    ?> 
            <div id='sale_booster_product_data' class='panel woocommerce_options_panel'>
            <div class='options_group'> 
        <?php
         // Select
         woocommerce_wp_select(
            array(
                'id' => '_sale_booster_alter_cart_button',
                'label' => __( 'Alter Add to Cart Button', 'sale_booster' ),
                'selected' => true,
                'options' => array(
                    'default' => __( 'Default', 'sale_booster' ),
                    'remove_button' => __( 'Remove Cart Button', 'sale_booster' ),
                    'inquire_us' => __( 'Inquire Us', 'sale_booster' )
                )
                
            )
        );
    echo "<div class = '_sale_booster_inquire'>";
        // Text Field
        woocommerce_wp_text_input(
            array(
            'id' => '_sale_booster_inquire_text',
            'label' => __( 'Inquire Us Text', 'sale_booster' ),
            'placeholder' => 'Inquire Us',
            'desc_tip' => 'true',
            'description' => __( 'Inquire Us Text.', 'sale_booster' )
            )
        );

        // Inquire Us link Field
          woocommerce_wp_text_input(
            array(
            'id' => '_sale_booster_inquire_link',
            'label' => __( 'Inquire Us Link', 'sale_booster' ),
            'placeholder' => 'http://',
            'desc_tip' => 'true',
            'description' => __('Enter the URL to Inquire Us button.', 'sale_booster'),
            )
        );
    echo "</div>";
        // Checkbox
        woocommerce_wp_checkbox(
            array(
            'id' => '_sale_booster_hide_price',
            'label' => __('Hide Price', 'sale_booster' ),
            'description' => __( 'Check me!', 'sale_booster' )
            )
        );

    echo "</div> <div class='options_group'> ";

    echo "<p><b style='margin-left: 3px'>Discound Timer</b></p>";
            woocommerce_wp_text_input(
            array(
            'id' => '_sale_booster_alert_text',
            'label' => __( 'Alert Text', 'sale_booster' ),
            'placeholder' => 'Hurry up! just 8 items left in stock',
            'desc_tip' => 'true',
            'description' => __( 'Hurry up! just 8 items left in stock.', 'sale_booster' )
            )
        );

        woocommerce_wp_text_input(
            array(
            'id' => '_sale_booster_expire_date_time',
            'label' => __( 'Coupon Expire Date', 'sale_booster' ),
            'placeholder' => '07/15/2015 12:30 PM',
            // 'desc_tip' => 'true',
          
            'description' => __( 'ex: 07/15/2019 12:30 PM (m/d/yyyy 00:00 PM)', 'sale_booster' )
            )
        );
       
        woocommerce_wp_radio(
            array(
               //'name' => '_price_per_word_character', 
               'label' => __('Expaire Date Layout', 'woocommerce-price-per-word'),
                'id' => '_Sale_booster_expaire_date_layout', 
                'value' => !empty($layoutSelected) ? $layoutSelected : "both",
                'options' => array(
                    'top'    => __("Top", 'sale_booster'), 
                    'bottom' => __("Bottom", 'sale_booster'),
                    'both'   => __("Both", 'sale_booster')
                ),
            )
        );
        // woocommerce_wp_text_input(
        //     array(
        //     'id' => '_sale_booster_expire_date_time',
        //     'label' => __( 'Coupon Expire Time', 'sale_booster' ),
        //     'placeholder' => '2:50',
        //     // 'desc_tip' => 'true',
           
        //     'description' => __( 'Coupon Expire Time: 2:30', 'sale_booster' )
        //     )
        // );

        ?> </div>
        </div>
        <?php
    }

    //save Data Fields
    public static function saveDataFields($post_id){

        // Save Select
        $alter_cart_button = $_POST['_sale_booster_alter_cart_button'];
        if (!empty($alter_cart_button)) {
            update_post_meta($post_id, '_sale_booster_alter_cart_button', esc_attr($alter_cart_button));
        }
        // Save inquire Text Field
        $inquire_text= $_POST['_sale_booster_inquire_text'];
        if ( ! add_post_meta($post_id, '_sale_booster_inquire_text', 'Buy Now', true ) ) { 
            update_post_meta($post_id, '_sale_booster_inquire_text', esc_attr($inquire_text));
         }

        // inquire link
        $inquire_us_link = $_POST['_sale_booster_inquire_link'];
        if(isset($inquire_us_link)){
            update_post_meta($post_id, '_sale_booster_inquire_link', esc_attr($inquire_us_link) );
        }
 
        // Save hide price
        $hide_price = isset($_POST['_sale_booster_hide_price']) ? 'yes' : 'no';
        update_post_meta($post_id, '_sale_booster_hide_price', $hide_price);

        // Save Alert Text Field
        $alert_text = $_POST['_sale_booster_alert_text'];
        if (isset($alert_text)) {
            update_post_meta($post_id, '_sale_booster_alert_text', esc_attr($alert_text));
        }

        // Save expire date
        $expire_datetime = $_POST['_sale_booster_expire_date_time'];
        if (isset($expire_datetime)) {
            update_post_meta($post_id, '_sale_booster_expire_date_time', esc_html($expire_datetime));
        }

        $_expaire_datelayout = $_POST['_Sale_booster_expaire_date_layout'];
            if(!empty($_expaire_datelayout)){
                update_post_meta($post_id, '_Sale_booster_expaire_date_layout', esc_html($_expaire_datelayout) );
            }
       
        // expire_date_time
        // $expire_date_time = $_POST['_sale_booster_expire_date_time'];
        // if(!empty($expire_date_time)){
        //     update_post_meta($post_id, '_sale_booster_expire_date_time', esc_html($expire_date_time));
        // }

        // Save Hidden field
        $hidden = $_POST['_hidden_field'];
        if (!empty($hidden)) {
            update_post_meta($post_id, '_hidden_field', esc_attr($hidden));
        }
    }

    // remove cart button
    public static function removeCartButton() {
        $remove_cart_button = get_post_meta( get_the_ID(), '_sale_booster_alter_cart_button', true );
       
        if($remove_cart_button == 'remove_button' || $remove_cart_button == 'inquire_us'){
            remove_action( 'woocommerce_simple_add_to_cart', 'woocommerce_simple_add_to_cart', 30 );
        } 
    }
    
    // Added custom button
   public static function addCustomButton() {
        $cart_ButtonText = get_post_meta( get_the_ID(), '_sale_booster_inquire_text', true );
        $cart_ButtonTextLink = get_post_meta( get_the_ID(), '_sale_booster_inquire_link', true );
        $alter_cart_button = get_post_meta( get_the_ID(), '_sale_booster_alter_cart_button', true );
        
        if($alter_cart_button == 'inquire_us'){
            echo "<a href='".$cart_ButtonTextLink."' class='single_add_to_cart_button button alt' target='_blank'>".$cart_ButtonText."</a>";
        }
   }   
   

    //hide price
    public static function hidePrice(){
        $hidePrice = get_post_meta( get_the_ID(), '_sale_booster_hide_price', true );
        if($hidePrice == "yes"){
             remove_action('woocommerce_single_product_summary','woocommerce_template_single_price',10  );
         } 
    }



    public static function discoundTimer(){
        $_alert_text = get_post_meta( get_the_ID(), '_sale_booster_alert_text', true);
        $_expireDateTime = get_post_meta( get_the_ID(), '_sale_booster_expire_date_time', true);
       
        $_expire_date_layout = get_post_meta( get_the_ID(), '_Sale_booster_expaire_date_layout', true);

        var_dump($_expire_date_layout);

        $curr_timestamp = date('m/d/Y H:i A');
         if($curr_timestamp  <= $_expireDateTime) { 
             if($_expire_date_layout == "bottom" || $_expire_date_layout == "both"){
    ?>
            <div class="_sale-booster-discoun-timer" style="margin-top:20px"> 
                <div class="_alert-text"> <?php  echo $_alert_text;?></div> 
                <div id='_sale-booster-countdown-bottom'></div>
            </div>
        <?php } }
    }


    public static function discoundTimerTop(){
        $_expireDateTime = get_post_meta( get_the_ID(), '_sale_booster_expire_date_time', true);
        $_expire_date_layout = get_post_meta( get_the_ID(), '_Sale_booster_expaire_date_layout', true);
        // $_expire_time = get_post_meta( get_the_ID(), '_sale_booster_expire_date_time', true);
        wp_localize_script('sale-booster-js', 'sale_booster_countdown_vars', array(
            'dateTime'    => $_expireDateTime,
            // 'time'    =>  $_expire_time 
        ));
        $curr_timestamp = date('m/d/Y H:i:s A');
        if($_expireDateTime >= $curr_timestamp) {
            if($_expire_date_layout == "top" || $_expire_date_layout == "both"){
                echo "<div id='_sale-booster-countdown-top'></div>";
             }
                
            
        }
    }




    
    
   



}

