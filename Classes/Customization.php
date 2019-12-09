<?php

namespace SaleBooster\Classes;

class Customization {

    public static function saleBoosterAddSettings($settings) {
        $settings[] = include_once 'SaleBoosterSettings.php';
        return $settings ;
    }
  
    public static function customStyle(){

        if(!defined('SALES_BOOTER_PRO_INSTALLED')) {
            return '';
        }

        $topbarPrimaryBgColor   = get_option('sale_booster_settings_primary_bg_color', '#7901ff');
        $topbarSecondaryBgColor = get_option('sale_booster_settings_secondary_bg_color', '#ff185f');
        $topbarTextColor        = get_option('sale_booster_settings_topbar_text_color', '#ffffff');
        $countdownBgColor       = get_option('sale_booster_settings_countdown_bg_color', '#9B4DCA');
        $countdownTimerColor    = get_option('sale_booster_settings_countdown_timer_color', '#ffffff');
        $countdownTextColor     = get_option('sale_booster_settings_countdown_text_color', '#9a07d7');
        $stockColor             = get_option('sale_booster_settings_stock_color', '#ff0400');
        $bgGradientColor        = $topbarSecondaryBgColor ? 'linear-gradient(to right,'.$topbarPrimaryBgColor.', '.$topbarSecondaryBgColor.')' : $topbarPrimaryBgColor;
        ?>
        <style type='text/css'>
            <?php if($bgGradientColor || $topbarTextColor) : ?>
            ._sale-booster-countdown-top {
                background: <?php echo $bgGradientColor; ?>;
                color:  <?php echo $topbarTextColor; ?>;
            }
            <?php endif; ?>

            <?php if($countdownBgColor || $countdownTimerColor) : ?>
            ._sale-booster-countdown-bottom ._sale-booster-countdown ._sale-discount-countdown-timer{
                background: <?php echo $countdownBgColor; ?>;
                color:  <?php echo $countdownTimerColor; ?>;
            }
            <?php endif; ?>

            <?php if($countdownTextColor) : ?>
            ._sale-booster-countdown-bottom ._sale-booster-hits{
                color:  <?php echo $countdownTextColor; ?>;
            }
            <?php endif; ?>

            <?php if($stockColor) : ?>
            ._sale-booster-countdown-bottom ._sale-booster-hits .sale_booster_stock{
                color: <?php echo $stockColor; ?>;
            }
            <?php endif; ?>
        </style>
        <?php
    }

}