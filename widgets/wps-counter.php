<?php

namespace Elementor\Wps\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;


if (!defined('ABSPATH')) exit; // Exit if accessed directly

/**
 * @since 1.1.0
 */
class Wps_Counter extends \Elementor\Widget_Base
{

    /**
     * Count product of module, conceived as 1 day 1 product
     *
     * @var int
     */
    private $numDay = 31;

    /**
     * Retrieve the widget name.
     *
     * @return string Widget name.
     * @since 1.1.0
     *
     * @access public
     *
     */
    public function get_name()
    {
        return 'wps-counter';
    }

    /**
     * Retrieve the widget title.
     *
     * @return string Widget title.
     * @since 1.1.0
     *
     * @access public
     *
     */
    public function get_title()
    {
        return __('Wps Counter', 'elementor-wps');
    }

    /**
     * Retrieve the widget icon.
     *
     * @return string Widget icon.
     * @since 1.1.0
     *
     * @access public
     *
     */
    public function get_icon()
    {
        return 'fa fa-pencil';
    }

    /**
     * Retrieve the list of categories the widget belongs to.
     *
     * Used to determine where to display the widget in the editor.
     *
     * Note that currently Elementor supports only one category.
     * When multiple categories passed, Elementor uses the first one.
     *
     * @return array Widget categories.
     * @since 1.1.0
     *
     * @access public
     *
     */
    public function get_categories()
    {
        return ['general'];
    }

    public function get_script_depends()
    {
        $scripts = ['elementor-wps'];

        return $scripts;
    }

    public function get_style_depends()
    {
        $styles = ['elementor-wps'];

        return $styles;
    }

    /**
     * Register the widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 1.1.0
     *
     * @access protected
     */
    protected function _register_controls()
    {

        /**
         * get all product for select list
         */
        $args = [
            'orderby' => 'name',
            'order' => 'DESC',
            'numberposts' => -1,
            'post_status' => 'published',
        ];
        $optionProduct = ['' => 'Empty'];
        $optionProductVariant = ['' => 'Empty'];
        $products = wc_get_products($args);

        foreach ($products as $product) {
            if(is_object($product)) {
                $optionProduct[$product->get_id()] = $product->get_id() . ' - ' . $product->get_name();
            }
        }

        foreach ($products as $productVariant) {
            if ($productVariant->is_type('variable')) {
                $variation_ids = $productVariant->get_visible_children();
                foreach ($variation_ids as $variation_id) {
                    $variation = wc_get_product($variation_id);

                    if(is_object($variation)) {
                        $optionProductVariant[$variation_id] = $variation->get_id() . ' - ' . $variation->get_name();
                    }
                }
            }
        }

        /**
         * Main config
         */
        $this->start_controls_section(
            'section_content',
            [
                'label' => __('Config', 'elementor-wps'),
            ]
        );

        $this->add_control(
            'counter_title',
            [
                'label' => __('Title', 'elementor-wps'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Hollywood Steal Of The Day', 'elementor-wps'),
            ]
        );

        $this->add_control(
            'counter_sub_title',
            [
                'label' => __('Sub title', 'elementor-wps'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('A Team-Picked, Limited-Time Deal Launches Every Day at 8AM ET', 'elementor-wps'),
            ]
        );

        $this->add_control(
            'counter_message',
            [
                'label' => __('Message - sold', 'elementor-wps'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Sold product', 'elementor-wps'),
                'placeholder' => __('Message out of stock', 'elementor-wps'),
            ]
        );

        $this->add_control(
            'counter_message_1',
            [
                'label' => __('Message - expired', 'elementor-wps'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Expired time', 'elementor-wps'),
                'placeholder' => __('Message expired time', 'elementor-wps'),
            ]
        );

        $this->add_control(
            'counter_message_2',
            [
                'label' => __('Next deal', 'elementor-wps'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Next deal', 'elementor-wps'),
            ]
        );

        $this->add_control(
            'count_words_description',
            [
                'label' => __('Description words count', 'elementor-wps'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('20', 'elementor-wps'),
            ]
        );

        $this->add_control(
            'align_title',
            [
                'label' => __('Align title', 'elementor-wps'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'left' => __('Left', 'elementor-wps'),
                    'center' => __('Center', 'elementor-wps'),
                    'right' => __('Right', 'elementor-wps'),
                ],
                'default' => __('Left', 'elementor-wps'),
            ]
        );

        $this->end_controls_section();

        for ($num = 1; $num <= $this->numDay; $num++) {
            /**
             * Product other
             */
            $this->start_controls_section(
                'section_product_' . $num,
                [
                    'label' => __('product ' . $num, 'elementor-wps'),
                ]
            );

            $this->add_control(
                'important_note_' . $num,
                [
                    'type' => \Elementor\Controls_Manager::RAW_HTML,
                    'raw' => __('You can select either product only or product variant only. If you have selected a product, in the product variant select Empty. Or the other way around. If the product has variants, then you need to choose a product variant!', 'elementor-wps'),
                ]
            );

            $this->add_control(
                'id_product_' . $num,
                [
                    'label' => __('Select product', 'elementor-wps'),
                    'type' => Controls_Manager::SELECT2,
                    'options' => $optionProduct,
                    'default' => __('Empty', 'elementor-wps'),
                ]
            );

            $this->add_control(
                'or_note_' . $num,
                [
                    'type' => \Elementor\Controls_Manager::RAW_HTML,
                    'raw' => __('OR', 'elementor-wps'),
                ]
            );

            $this->add_control(
                'id_variant_' . $num,
                [
                    'label' => __('Select variant', 'elementor-wps'),
                    'type' => Controls_Manager::SELECT2,
                    'options' => $optionProductVariant,
                    'default' => __('Empty', 'elementor-wps'),
                ]
            );

            $this->add_control(
                'hr-1-7-0-' . $num,
                [
                    'type' => \Elementor\Controls_Manager::DIVIDER,
                ]
            );

            $this->add_control(
                'product_title_' . $num,
                [
                    'label' => __('Title product ' . $num, 'elementor-wps'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                ]
            );

            $this->add_control(
                'product_coupon_' . $num,
                [
                    'label' => __('Coupon product ' . $num, 'elementor-wps'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                ]
            );

            $this->add_control(
                'product_sale_old_' . $num,
                [
                    'label' => __('Sale price normal ' . $num, 'elementor-wps'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                ]
            );

            $this->add_control(
                'product_sale_all_variant_' . $num,
                [
                    'label' => __( 'Sale price over for all variant?', 'elementor-wps' ),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'default' => '0',
                    'options' => [
                        '0'  => __( 'No', 'elementor-wps' ),
                        '1' => __( 'Yes', 'elementor-wps' ),
                    ],
                ]
            );

            $this->add_control(
                'product_sale_' . $num,
                [
                    'label' => __('Sale price over ' . $num, 'elementor-wps'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                ]
            );

            $this->add_control(
                'hr-1-7-1' . $num,
                [
                    'type' => \Elementor\Controls_Manager::DIVIDER,
                ]
            );

            $this->add_control(
                'product_date_start_' . $num,
                [
                    'label' => __('Date start product sale ' . $num, 'elementor-wps'),
                    'type' => \Elementor\Controls_Manager::DATE_TIME,
                ]
            );

            $this->add_control(
                'product_date_final_' . $num,
                [
                    'label' => __('Date final product sale ' . $num, 'elementor-wps'),
                    'type' => \Elementor\Controls_Manager::DATE_TIME,
                ]
            );

            $this->add_control(
                'hr-1-271' . $num,
                [
                    'type' => \Elementor\Controls_Manager::DIVIDER,
                ]
            );

            $this->add_control(
                'product_description_' . $num,
                [
                    'label' => __('Description product ' . $num, 'elementor-wps'),
                    'type' => \Elementor\Controls_Manager::WYSIWYG,
                ]
            );

            $this->add_control(
                'hr-1-7-3' . $num,
                [
                    'type' => \Elementor\Controls_Manager::DIVIDER,
                ]
            );

            $this->add_control(
                'product_image_' . $num,
                [
                    'label' => __('Choose Image for product ' . $num, 'elementor-wps'),
                    'type' => \Elementor\Controls_Manager::MEDIA,
                ]
            );

            $this->end_controls_section();

        }


    }


    function custom_dynamic_sale_price_1($product)
    {
        $sale = $product->get_sale_price();
        return $sale - 1;
    }


    /**
     * Render the widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since 1.1.0
     *
     * @access protected
     */
    protected function render()
    {
        echo ' '; //for exist if empty in elementor
        $numActiveProduct = 1;
        $numNextProduct = 2;
        $checked = 0;
        $settings = $this->get_settings_for_display();
        $now = strtotime(date('Y-m-d H:i:s'));

        for ($i = 1; $i <= $this->numDay; $i++) {

            /**
             * search product in interval, if found then $checked = 1
             */
            if ((strtotime($settings['product_date_start_' . $i]) < $now) && (strtotime($settings['product_date_final_' . $i]) > $now) && ($checked < 1)) {
                $numActiveProduct = $i;
                $numNextProduct = $numActiveProduct + 1;
                $checked = 1;
            }

            /**
             * if product not set in interval, then next product last of exist
             */
            if ((strtotime($settings['product_date_start_' . $i]) > $now) && (strtotime($settings['product_date_final_' . $i]) > $now) && ($checked == 0)) {
                $numNextProduct = $i;
            }
        }

        $idProduct = (!empty($settings['id_product_' . $numActiveProduct]) && $settings['id_product_' . $numActiveProduct] != 'Empty') ? $settings['id_product_' . $numActiveProduct] : $settings['id_variant_' . $numActiveProduct];
        $product = (!empty($idProduct)) ? wc_get_product($idProduct) : false;

        if (isset($settings['id_product_' . $numNextProduct]) || isset($settings['id_variant_' . $numNextProduct])) {
            $idProductNext = (!empty($settings['id_product_' . $numNextProduct]) && $settings['id_product_' . $numNextProduct] != 'Empty') ? $settings['id_product_' . $numNextProduct] : $settings['id_variant_' . $numNextProduct];
            $productNext = wc_get_product($idProductNext);

            if ($productNext != false) {
                $stockStatusNextProduct = $productNext->get_stock_status();
            }
        }

        /**
         * if product selected, then start counter when sale date is over get next product
         * also we get old sale price prev product and update prev product sale price
         */
        if ($product != false) {

            /**
             * restoring old sale price
             */
            for ($j = 1; $j <= $this->numDay; $j++) {
                if (!empty($settings['product_sale_old_' . $j]) && !is_null($j)) {
                    $idProductPrev = (!empty($settings['id_product_' . $j]) && $settings['id_product_' . $j] != 'Empty') ? $settings['id_product_' . $j] : $settings['id_variant_' . $j];
                    $productPrev = (!empty($idProductPrev)) ? wc_get_product($idProductPrev) : false;
                    if ($productPrev && !empty($settings['product_sale_old_' . $j]) && $settings['product_sale_old_' . $j] != 0 && $j != $numActiveProduct) {
                        if ($productPrev->is_type('simple')) {
                            $productPrev->set_sale_price($settings['product_sale_old_' . $j]);
                            $productPrev->save();
                        }else{
                            if( $settings['product_sale_all_variant_' . $j] == 1){
                                $variationSelected = wc_get_product($idProductPrev);
                                $parentProduct = wc_get_product( $variationSelected->get_parent_id() );
                                $allVariation = $parentProduct->get_children();

                                foreach($allVariation as $variant){
                                    $variant = wc_get_product( $variant );
                                    $variant->set_sale_price($settings['product_sale_old_' . $j]);
                                    $variant->save();
                                }
                            }else{
                                $productPrev->set_sale_price($settings['product_sale_old_' . $j]);
                                $productPrev->save();
                            }
                        }
                    }
                }
            }

            /**
             * apply over sale, update if over sale not 0 or equal sale prise
             * if sale_all_variant not 1 then update only select variant, other update sale price for all variant
             */
            if (!empty($settings['product_sale_' . $numActiveProduct]) &&
                $settings['product_sale_' . $numActiveProduct] != 0 &&
                $settings['product_sale_' . $numActiveProduct] != $product->get_sale_price()) {

                if ($product->is_type('simple')) {
                    $product->set_sale_price($settings['product_sale_' . $numActiveProduct]);
                    $product->save();
                }else{
                   if( $settings['product_sale_all_variant_' . $numActiveProduct] == 1){
                       $variationSelected = wc_get_product($idProduct);
                       $parentProduct = wc_get_product( $variationSelected->get_parent_id() );
                       $allVariation = $parentProduct->get_children();

                       foreach($allVariation as $variant){
                           $variant = wc_get_product( $variant );
                           $variant->set_sale_price($settings['product_sale_' . $numActiveProduct]);
                           $variant->save();
                       }
                   }else{
                       $product->set_sale_price($settings['product_sale_' . $numActiveProduct]);
                       $product->save();
                   }
                }

            }

            $productTitle = (!empty($settings['product_title_' . $numActiveProduct])) ? $settings['product_title_' . $numActiveProduct] : $product->get_title();
            $productDesc = (!empty($settings['product_description_' . $numActiveProduct])) ? wp_trim_words($settings['product_description_' . $numActiveProduct], $settings['count_words_description'], ' ...') : wp_trim_words($product->get_description(), $settings['count_words_description'], ' ...');
            $productCoupon = (!empty($settings['product_coupon_' . $numActiveProduct])) ? '<label>Coupon for sale:<input type="text" value="' . $settings['product_coupon_' . $numActiveProduct] . '"></label>' : '';
            $imageId = $product->get_image_id();
            $imageUrl = (!empty($settings['product_image_' . $numActiveProduct]['url'])) ? $settings['product_image_' . $numActiveProduct]['url'] : wp_get_attachment_image_url($imageId, 'full');
            $productUrl = $product->get_permalink();
            $productPrice = $product->get_regular_price();
            $productSalePrice = $product->get_sale_price();

            $productPercent = (!empty($productSalePrice)) ? 100 - round(($productSalePrice * 100) / $productPrice) : null;
            $productQuantity = (!empty($product->get_stock_quantity())) ? $product->get_stock_quantity() : ($product->get_stock_status() == 'outofstock') ? 0 : 1;

            $startTimeSale = date("F j, Y, g:i a", strtotime($settings['product_date_start_' . $numActiveProduct]));
            $finalTimeSale = date("F j, Y, g:i a", strtotime($settings['product_date_final_' . $numActiveProduct]));
            $startTimeSaleNext = (!empty($settings['product_date_start_' . $numNextProduct])) ? date("F j, Y, g:i a", strtotime($settings['product_date_start_' . $numNextProduct])) : null;

            echo '<script>        
        jQuery(function(){
            let ts = new Date("' . $finalTimeSale . '");	 //time stop   
            let tf = new Date("' . $startTimeSale . '");	 //time from
            let now = new Date();
            let stock = "' . $product->get_stock_status() . '"; 
            let quantity = ' . $productQuantity . '; 
            let countdown = jQuery(\'#countdown' . $idProduct . '\');   
            let a = "' . is_admin() . '";
            	if((now < ts) && (stock === "instock" || quantity > 0) && (tf < now)){
                    countdown.countdown({
                        timestamp	: ts
                    });	
	            }else{     
            	   if(a!=1){
            	       let message = (now > ts) ? "' . $settings['counter_message_1'] . '" : "' . $settings['counter_message'] . '";
            	       let overlay = countdown.closest(".elementor-section").children(".elementor-background-overlay");
            	        overlay.addClass("overlay-wps");
            	        overlay.append( "<div class=\'sold-or-expired\'>"+message+"</div>" );                  
            	        let ts2 = new Date("' . $startTimeSaleNext . '");
                        let now2 = new Date();
                        let stock2 = "' . $stockStatusNextProduct . '";
                        let countdown2 = jQuery(\'#countdown' . $idProductNext . '\');
                        countdown2.append("<p class=\"sold-or-expired\">' . $settings['counter_message_2'] . '</p>");
                            if(now2 < ts2 && stock2 === "instock"){
                                countdown2.countdown({
                                    timestamp	: ts2
                                });
                            }
            	   }
	            }
        });
        </script>
        <div class="wps-counter-row active-product-' . $numActiveProduct . '">
            <div class="wps-counter-title">' . $settings['counter_title'] . '</div>
            <div class="wps-counter-sub-title">' . $settings['counter_sub_title'] . '</div>
            <img src="' . $imageUrl . '" class="wps-image">
                        <div class="right-block">
             <a href="' . $productUrl . '" class="button wps-button-product" rel="nofollow">
                        <h3 style="text-align: ' . $settings['align_title'] . '">' . $productTitle . '</h3>  
                        <p>' . $productDesc . '</p>             
                        <p style="text-align:center">' . $productCoupon . '</p>
                        
                        
                        <div class="savingbox">
                <span class="discount-two">save ' . $productPercent . '%</span>
                </div>
                <div class="astra-shop-summary-wrap">

                        <del>
                            <span class="woocommerce-Price-amount amount">
                            <bdi class="oldprice"><span class="woocommerce-Price-currencySymbol">$</span>' . $productPrice . '</bdi>
                            </span>
                        </del> <ins>
                        <span class="woocommerce-Price-amount amount">
                        <bdi class="newprice">
                        <span class="woocommerce-Price-currencySymbol">$</span>' . $productSalePrice . '</bdi>
                        </span>
                        </ins>
                       <div class="btnviewproduct">Steal It</div>
                    </a>
                </div>
                <div id="countdown' . $idProduct . '"></div>
                <div id="countdown' . $idProductNext . '" style="z-index: 999; position: relative;"></div>
            </div>  
         </div>';
        }
    }

    /**
     * Render the widget output in the editor.
     *
     * Written as a Backbone JavaScript template and used to generate the live preview.
     *
     * @since 1.1.0
     *
     * @access protected
     */
    protected function _content_template()
    {

    }
}
