<?php

namespace Elementor\Wps\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use QuickBuy;


if (!defined('ABSPATH')) exit; // Exit if accessed directly

/**
 * @since 1.1.0
 */
class Wps_Featured_Deals extends \Elementor\Widget_Base
{

    /**
     * How show product in render
     *
     * @var int
     */
    private $countProduct = 10;

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
        return 'wps-featured-deals';
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
        return __('Wps Featured Deals', 'elementor-wps-featured-deals');
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
        $scripts = ['elementor-wps-featured-deals'];

        return $scripts;
    }

    public function get_style_depends()
    {
        $styles = ['elementor-wps-featured-deals'];

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

        $optionProductFeatured = ['' => 'Empty'];
        $optionProductFeaturedVariant = ['' => 'Empty'];
        $products = wc_get_products($args);

        foreach ($products as $product) {
            if(is_object($product)) {
                $optionProductFeatured[$product->get_id()] = $product->get_id() . ' - ' . $product->get_name();
            }
        }

        foreach ($products as $productVariant) {
            if ($productVariant->is_type('variable')) {
                $variation_ids = $productVariant->get_visible_children();
                foreach ($variation_ids as $variation_id) {
                    $variation = wc_get_product($variation_id);
                    if(is_object($variation)) {
                        $optionProductFeaturedVariant[$variation_id] = $variation->get_id() . ' - ' . $variation->get_name();
                    }
                }
            }
        }

        $this->start_controls_section(
            'section_config',
            [
                'label' => __('Config', 'elementor-wps-featured-deals'),
            ]
        );

        $this->add_control(
            'featured_deals_title',
            [
                'label' => __('Title', 'elementor-wps-featured-deals'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Default title', 'elementor-wps-featured-deals'),
                'placeholder' => __('Featured deals title', 'elementor-wps-featured-deals'),
            ]
        );

        $this->add_control(
            'featured_deals_day_title',
            [
                'label' => __('Title day', 'elementor-wps-featured-deals'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Daily deal', 'elementor-wps-featured-deals'),
            ]
        );

        $this->end_controls_section();


        /**
         * Featured
         */

        $this->start_controls_section(
            'section_content',
            [
                'label' => __('Featured deals', 'elementor-wps-featured-deals'),
            ]
        );

        $this->add_control(
            'important_note_1_0',
            [
                'type' => \Elementor\Controls_Manager::RAW_HTML,
                'raw' => __('Specify products to display on the featured-deals', 'elementor-wps-featured-deals'),
            ]
        );

        for ($fd = 1; $fd <= $this->countProduct; $fd++) {
            $this->add_control(
                'important_note_' . $fd,
                [
                    'type' => \Elementor\Controls_Manager::RAW_HTML,
                    'raw' => __('Select ' . $fd . ' product or variant', 'elementor-wps-featured-deals'),
                ]
            );

            $this->add_control(
                'id_productFeatured_' . $fd,
                [
                    'label' => __('Select product ' . $fd, 'elementor-wps-featured-deals'),
                    'type' => Controls_Manager::SELECT2,
                    'options' => $optionProductFeatured,
                    'default' => __('Empty', 'elementor-wps-featured-deals'),
                ]
            );

            $this->add_control(
                'or_note_' . $fd,
                [
                    'type' => \Elementor\Controls_Manager::RAW_HTML,
                    'raw' => __('OR', 'elementor-wps-featured-deals'),
                ]
            );

            $this->add_control(
                'id_variant_' . $fd,
                [
                    'label' => __('Select variant ' . $fd, 'elementor-wps-featured-deals'),
                    'type' => Controls_Manager::SELECT2,
                    'options' => $optionProductFeaturedVariant,
                    'default' => __('Empty', 'elementor-wps-featured-deals'),
                ]
            );

            $this->add_control(
                'product_sale_all_variant_' . $fd,
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
                'product_sale_old_' . $fd,
                [
                    'label' => __('Sale price ' . $fd, 'elementor-wps'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                ]
            );

            $this->add_control(
                'product_sale_' . $fd,
                [
                    'label' => __('Sale price over ' . $fd, 'elementor-wps'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                ]
            );

            $this->add_control(
                'product_coupon_' . $fd,
                [
                    'label' => __('Coupon product ' . $fd, 'elementor-wps'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                ]
            );

            $this->add_control(
                'product_description_' . $fd,
                [
                    'label' => __('Description product ' . $fd, 'elementor-wps'),
                    'type' => \Elementor\Controls_Manager::TEXTAREA,
                ]
            );

            $this->add_control(
                'product_image_' . $fd,
                [
                    'label' => __('Choose Image for product ' . $fd, 'elementor-wps'),
                    'type' => \Elementor\Controls_Manager::MEDIA,
                ]
            );

            $this->add_control(
                'hr' . $fd,
                [
                    'type' => \Elementor\Controls_Manager::DIVIDER,
                ]
            );
        }

        $this->end_controls_section();

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
        $settings = $this->get_settings_for_display();

        /**
         * Featured deals data
         */
        for ($d = 1; $d <= $this->countProduct; $d++) {
            if((!empty($settings['id_productFeatured_'.$d]) && $settings['id_productFeatured_'.$d] != 'Empty')){
                ${"idProductFeatured_$d"} = $settings['id_productFeatured_'.$d];
                ${"checkVariant_$d"} = false;
            }else{
                ${"idProductFeatured_$d"} = $settings['id_variant_'.$d];
                ${"checkVariant_$d"} = true;
            }
            //${"idProductFeatured_$d"} = (!empty($settings['id_productFeatured_'.$d]) && $settings['id_productFeatured_'.$d] != 'Empty') ? $settings['id_productFeatured_'.$d] : $settings['id_variant_'.$d];
            ${"productFeatured_$d"} = wc_get_product(${"idProductFeatured_$d"});
            ${"productUrl$d"} = (!empty(${"productFeatured_$d"})) ? ${"productFeatured_$d"}->get_permalink() : '';
            ${"imageUrl$d"} = (!empty($settings['product_image_'.$d]['url'])) ? $settings['product_image_'.$d]['url'] : wp_get_attachment_url(${"productFeatured_$d"}->image_id);
            ${"priceProductFeatured$d"} = (!empty(${"productFeatured_$d"}->regular_price)) ? ${"productFeatured_$d"}->regular_price : ${"productFeatured_$d"}->price;
            ${"percent$d"} = (!empty(${"productFeatured_$d"}->sale_price)) ? (${"priceProductFeatured$d"} != 0) ? round(((${"priceProductFeatured$d"} - ${"productFeatured_$d"}->sale_price) / ${"priceProductFeatured$d"}) * 100) : null : null;
        }

        echo '<div class="wrapper-wps extended">
    <div id="featured-products-section" class="homepage-section-wps">
        <h2 class="featured-deals-header wps-homepage-section-wps-header">' . $settings["featured_deals_title"] . '</h2>

        <ul class="productGrid grid-wps grid-wps--uniform" data-product-type="featured">';

        for ($i = 1; $i <= $this->countProduct; $i++) {
            $productCoupon = (!empty($settings['product_coupon_' . $i])) ? '<label>Coupon for sale:<input type="text" value="' . $settings['product_coupon_' . $i] . '"></label>' : '';

            /**
             * If sale price product not equal sale price over setting, sale over price setting not empty and not zero
             * update sale if exist over sale in module
             * if check "sale all variant" then update all variant
             */
            if ((${"productFeatured_$i"}->sale_price != $settings['product_sale_' . $i]) &&
                !empty($settings['product_sale_' . $i]) &&
                $settings['product_sale_' . $i] != 0
            ) {
                if ($settings['product_sale_all_variant_' . $i] == 1 && ${"checkVariant_$i"} == true) {

                    $variationSelected = wc_get_product(${"productFeatured_$i"});
                    $parentProduct = wc_get_product($variationSelected->get_parent_id());
                    $allVariation = $parentProduct->get_children();

                    foreach ($allVariation as $variant) {
                        $variant = wc_get_product($variant);
                        $variant->set_sale_price($settings['product_sale_' . $i]);
                        $variant->save();
                    }
                } else {
                    ${"productFeatured_$i"}->set_sale_price($settings['product_sale_' . $i]);
                    ${"productFeatured_$i"}->save();
                }
            }

            /**
             * If over sale empty and old product exist
             * then restore old sale price
             * if check "sale all variant" then update all variant
             */
            if(empty($settings['product_sale_' . $i]) && !empty($settings['product_sale_old_' . $i])){
                if ($settings['product_sale_all_variant_' . $i] == 1 && ${"checkVariant_$i"} == true) {

                    $variationSelected = wc_get_product(${"productFeatured_$i"});
                    $parentProduct = wc_get_product($variationSelected->get_parent_id());
                    $allVariation = $parentProduct->get_children();

                    foreach ($allVariation as $variant) {
                        $variant = wc_get_product($variant);
                        $variant->set_sale_price($settings['product_sale_old_' . $i]);
                        $variant->save();
                    }
                } else {
                    ${"productFeatured_$i"}->set_sale_price($settings['product_sale_old_' . $i]);
                    ${"productFeatured_$i"}->save();
                }
            }

            /**
             * show product
             */
            echo '
    <li class="product grid-wps__item large-up--one-third">
                <article class="card-wrapper-wps featured-card-container productCard data-event-type">
                    <div class="card-header">
                        <h2 class="featured-daily-title">
                            <span class="featured-title-content">' . $settings["featured_deals_day_title"] . '</span>
                        </h2>
                    </div>
                    <div class="card featured-card">
                        <a href="' . ${"productUrl$i"} . '"
                           data-event-type="product-click">
                            <figure class="card-figure">
                                <div class="card-img-container">
                                    <img src="' . ${"imageUrl$i"} . '"
                                         alt="' . ${"productFeatured_$i"}->name . '"
                                         data-sizes="auto"
                                         class="card-image lazyautosizes lazyloaded" sizes="309px">
                                </div>
                            </figure>
                            <div class="card-body astra-shop-summary-wrap">
                                <p class="h4 card-title">';
            echo (!empty($settings["product_description_" . $i])) ? $settings["product_description_" . $i] : ${"productFeatured_$i"}->name;
            echo '</p><p style="text-align:center">' . $productCoupon . '</p>';

            /**
             * If product selected then add button quick order
             * Hook: woocommerce_featured_wps.
             */
            if (${"idProductFeatured_$i"} != 'Empty' && !empty(${"productFeatured_$i"})) {
                global $product;
                $product = ${"productFeatured_$i"};
                do_action('woocommerce_featured_wps');
            }

            echo '

                                <a href="' . ${"productUrl$i"} . '" class="button product_type_simple add_to_cart_button_wps "  rel="nofollow">
<del><span class="woocommerce-Price-amount amount"
><bdi class="regularprice">
<span class="woocommerce-Price-currencySymbol">$</span> ' . ${"priceProductFeatured$i"} . '</bdi></span></del> 
<ins>
<span class="woocommerce-Price-amount amount">
<bdi class="saleprice">
<span class="woocommerce-Price-currencySymbol">$</span>' . ${"productFeatured_$i"}->sale_price . '
</bdi>
</span>
</ins>
<br><span class="discount">save ' . ${"percent$i"} . '%</span></a>
                            </div>
                        </a>
                    </div>
                </article>
            </li>
    ';

        }

        echo '</ul></div></div>';

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
