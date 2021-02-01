<?php

namespace Elementor\Wps\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;


if (!defined('ABSPATH')) exit; // Exit if accessed directly

/**
 * @since 1.1.0
 */
class Wps_Featured_Deals extends \Elementor\Widget_Base
{

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
        $scripts = ['elementor-wps-addons'];

        return $scripts;
    }

    public function get_style_depends()
    {
        $styles = ['elementor-wps-addons'];

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
            $optionProductFeatured[$product->get_id()] = $product->get_id() . ' - ' . $product->get_name();
        }

        foreach ($products as $productVariant) {
            if ($productVariant->is_type('variable')) {
                $variation_ids = $productVariant->get_visible_children();
                foreach ($variation_ids as $variation_id) {
                    $variation = wc_get_product($variation_id);
                    $optionProductFeaturedVariant[$variation_id] = $variation->get_id() . ' - ' . $variation->get_name();
                }
            }
        }


        /**
         * BestSellers
         */

        $this->start_controls_section(
            'section_content',
            [
                'label' => __('featured deals', 'elementor-wps-featured-deals'),
            ]
        );

        $this->add_control(
            'important_note_1_0',
            [
                'type' => \Elementor\Controls_Manager::RAW_HTML,
                'raw' => __('Specify products to display on the featured-deals', 'elementor-wps-featured-deals'),
            ]
        );

        $this->add_control(
            'hr0',
            [
                'type' => \Elementor\Controls_Manager::DIVIDER,
            ]
        );

        $this->add_control(
            'featured_deals_title',
            [
                'label' => __( 'Title', 'elementor-wps-featured-deals' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __( 'Default title', 'elementor-wps-featured-deals' ),
                'placeholder' => __( 'Featured deals title', 'elementor-wps-featured-deals' ),
            ]
        );

        $this->add_control(
            'important_note_1',
            [
                'type' => \Elementor\Controls_Manager::RAW_HTML,
                'raw' => __('Select first product or variant', 'elementor-wps-featured-deals'),
            ]
        );

        $this->add_control(
            'id_productFeatured_1',
            [
                'label' => __('Select product 1', 'elementor-wps-featured-deals'),
                'type' => Controls_Manager::SELECT,
                'options' => $optionProductFeatured,
                'default' => __('Empty', 'elementor-wps-featured-deals'),
            ]
        );

        $this->add_control(
            'or_note_1',
            [
                'type' => \Elementor\Controls_Manager::RAW_HTML,
                'raw' => __('OR', 'elementor-wps-featured-deals'),
            ]
        );

        $this->add_control(
            'id_variant_1',
            [
                'label' => __('Select variant 1', 'elementor-wps-featured-deals'),
                'type' => Controls_Manager::SELECT,
                'options' => $optionProductFeaturedVariant,
                'default' => __('Empty', 'elementor-wps-featured-deals'),
            ]
        );


        $this->add_control(
            'hr2',
            [
                'type' => \Elementor\Controls_Manager::DIVIDER,
            ]
        );


        $this->add_control(
            'important_note_2',
            [
                'type' => \Elementor\Controls_Manager::RAW_HTML,
                'raw' => __('Select second product or variant', 'elementor-wps-featured-deals'),
            ]
        );

        $this->add_control(
            'id_productFeatured_2',
            [
                'label' => __('Select product 2', 'elementor-wps-featured-deals'),
                'type' => Controls_Manager::SELECT,
                'options' => $optionProductFeatured,
                'default' => __('Empty', 'elementor-wps-featured-deals'),
            ]
        );

        $this->add_control(
            'or_note_2',
            [
                'type' => \Elementor\Controls_Manager::RAW_HTML,
                'raw' => __('OR', 'elementor-wps-featured-deals'),
            ]
        );

        $this->add_control(
            'id_variant_2',
            [
                'label' => __('Select variant 2', 'elementor-wps-featured-deals'),
                'type' => Controls_Manager::SELECT,
                'options' => $optionProductFeaturedVariant,
                'default' => __('Empty', 'elementor-wps-featured-deals'),
            ]
        );


        $this->add_control(
            'hr3',
            [
                'type' => \Elementor\Controls_Manager::DIVIDER,
            ]
        );


        $this->add_control(
            'important_note_3',
            [
                'type' => \Elementor\Controls_Manager::RAW_HTML,
                'raw' => __('Select the third product or variant', 'elementor-wps-featured-deals'),
            ]
        );

        $this->add_control(
            'id_productFeatured_3',
            [
                'label' => __('Select product 3', 'elementor-wps-featured-deals'),
                'type' => Controls_Manager::SELECT,
                'options' => $optionProductFeatured,
                'default' => __('Empty', 'elementor-wps-featured-deals'),
            ]
        );

        $this->add_control(
            'or_note_3',
            [
                'type' => \Elementor\Controls_Manager::RAW_HTML,
                'raw' => __('OR', 'elementor-wps-featured-deals'),
            ]
        );

        $this->add_control(
            'id_variant_3',
            [
                'label' => __('Select variant 3', 'elementor-wps-featured-deals'),
                'type' => Controls_Manager::SELECT,
                'options' => $optionProductFeaturedVariant,
                'default' => __('Empty', 'elementor-wps-featured-deals'),
            ]
        );


        $this->add_control(
            'hr4',
            [
                'type' => \Elementor\Controls_Manager::DIVIDER,
            ]
        );


        $this->add_control(
            'important_note_4',
            [
                'type' => \Elementor\Controls_Manager::RAW_HTML,
                'raw' => __('Select the fourth product or variant', 'elementor-wps-featured-deals'),
            ]
        );

        $this->add_control(
            'id_productFeatured_4',
            [
                'label' => __('Select product 4', 'elementor-wps-featured-deals'),
                'type' => Controls_Manager::SELECT,
                'options' => $optionProductFeatured,
                'default' => __('Empty', 'elementor-wps-featured-deals'),
            ]
        );

        $this->add_control(
            'or_note_4',
            [
                'type' => \Elementor\Controls_Manager::RAW_HTML,
                'raw' => __('OR', 'elementor-wps-featured-deals'),
            ]
        );

        $this->add_control(
            'id_variant_4',
            [
                'label' => __('Select variant 4', 'elementor-wps-featured-deals'),
                'type' => Controls_Manager::SELECT,
                'options' => $optionProductFeaturedVariant,
                'default' => __('Empty', 'elementor-wps-featured-deals'),
            ]
        );



        $this->add_control(
            'hr5',
            [
                'type' => \Elementor\Controls_Manager::DIVIDER,
            ]
        );


        $this->add_control(
            'important_note_5',
            [
                'type' => \Elementor\Controls_Manager::RAW_HTML,
                'raw' => __('Select the fourth product or variant', 'elementor-wps-featured-deals'),
            ]
        );

        $this->add_control(
            'id_productFeatured_5',
            [
                'label' => __('Select product 5', 'elementor-wps-featured-deals'),
                'type' => Controls_Manager::SELECT,
                'options' => $optionProductFeatured,
                'default' => __('Empty', 'elementor-wps-featured-deals'),
            ]
        );

        $this->add_control(
            'or_note_5',
            [
                'type' => \Elementor\Controls_Manager::RAW_HTML,
                'raw' => __('OR', 'elementor-wps-featured-deals'),
            ]
        );

        $this->add_control(
            'id_variant_5',
            [
                'label' => __('Select variant 5', 'elementor-wps-featured-deals'),
                'type' => Controls_Manager::SELECT,
                'options' => $optionProductFeaturedVariant,
                'default' => __('Empty', 'elementor-wps-featured-deals'),
            ]
        );


        $this->add_control(
            'hr6',
            [
                'type' => \Elementor\Controls_Manager::DIVIDER,
            ]
        );


        $this->add_control(
            'important_note_6',
            [
                'type' => \Elementor\Controls_Manager::RAW_HTML,
                'raw' => __('Select the fourth product or variant', 'elementor-wps-featured-deals'),
            ]
        );

        $this->add_control(
            'id_productFeatured_6',
            [
                'label' => __('Select product 6', 'elementor-wps-featured-deals'),
                'type' => Controls_Manager::SELECT,
                'options' => $optionProductFeatured,
                'default' => __('Empty', 'elementor-wps-featured-deals'),
            ]
        );

        $this->add_control(
            'or_note_6',
            [
                'type' => \Elementor\Controls_Manager::RAW_HTML,
                'raw' => __('OR', 'elementor-wps-featured-deals'),
            ]
        );

        $this->add_control(
            'id_variant_6',
            [
                'label' => __('Select variant 6', 'elementor-wps-featured-deals'),
                'type' => Controls_Manager::SELECT,
                'options' => $optionProductFeaturedVariant,
                'default' => __('Empty', 'elementor-wps-featured-deals'),
            ]
        );

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
         * Best sellers data
         */
        $idProductFeatured_1 = (!empty($settings['id_productFeatured_1']) && $settings['id_productFeatured_1'] != 'Empty') ? $settings['id_productFeatured_1'] : $settings['id_variant_1'];
        $idProductFeatured_2 = (!empty($settings['id_productFeatured_2']) && $settings['id_productFeatured_2'] != 'Empty') ? $settings['id_productFeatured_2'] : $settings['id_variant_2'];
        $idProductFeatured_3 = (!empty($settings['id_productFeatured_3']) && $settings['id_productFeatured_3'] != 'Empty') ? $settings['id_productFeatured_3'] : $settings['id_variant_3'];
        $idProductFeatured_4 = (!empty($settings['id_productFeatured_4']) && $settings['id_productFeatured_4'] != 'Empty') ? $settings['id_productFeatured_4'] : $settings['id_variant_4'];
        $idProductFeatured_5 = (!empty($settings['id_productFeatured_5']) && $settings['id_productFeatured_5'] != 'Empty') ? $settings['id_productFeatured_5'] : $settings['id_variant_5'];
        $idProductFeatured_6 = (!empty($settings['id_productFeatured_6']) && $settings['id_productFeatured_6'] != 'Empty') ? $settings['id_productFeatured_6'] : $settings['id_variant_6'];

        $productFeatured_1 = wc_get_product($idProductFeatured_1);
        $productFeatured_2 = wc_get_product($idProductFeatured_2);
        $productFeatured_3 = wc_get_product($idProductFeatured_3);
        $productFeatured_4 = wc_get_product($idProductFeatured_4);
        $productFeatured_5 = wc_get_product($idProductFeatured_5);
        $productFeatured_6 = wc_get_product($idProductFeatured_6);

        $productUrl1 = (!empty($productFeatured_1)) ? $productFeatured_1->get_permalink() : '';
        $productUrl2 = (!empty($productFeatured_2)) ? $productFeatured_2->get_permalink() : '';
        $productUrl3 = (!empty($productFeatured_3)) ? $productFeatured_3->get_permalink() : '';
        $productUrl4 = (!empty($productFeatured_4)) ? $productFeatured_4->get_permalink() : '';
        $productUrl5 = (!empty($productFeatured_5)) ? $productFeatured_5->get_permalink() : '';
        $productUrl6 = (!empty($productFeatured_6)) ? $productFeatured_6->get_permalink() : '';

        $imageUrl1 = wp_get_attachment_url($productFeatured_1->image_id);
        $imageUrl2 = wp_get_attachment_url($productFeatured_2->image_id);
        $imageUrl3 = wp_get_attachment_url($productFeatured_3->image_id);
        $imageUrl4 = wp_get_attachment_url($productFeatured_4->image_id);
        $imageUrl5 = wp_get_attachment_url($productFeatured_5->image_id);
        $imageUrl6 = wp_get_attachment_url($productFeatured_6->image_id);

        $priceProductFeatured1 = (!empty($productFeatured_1->regular_price)) ? $productFeatured_1->regular_price : $productFeatured_1->price;
        $priceProductFeatured2 = (!empty($productFeatured_2->regular_price)) ? $productFeatured_2->regular_price : $productFeatured_2->price;
        $priceProductFeatured3 = (!empty($productFeatured_3->regular_price)) ? $productFeatured_3->regular_price : $productFeatured_3->price;
        $priceProductFeatured4 = (!empty($productFeatured_4->regular_price)) ? $productFeatured_4->regular_price : $productFeatured_4->price;
        $priceProductFeatured5 = (!empty($productFeatured_5->regular_price)) ? $productFeatured_5->regular_price : $productFeatured_5->price;
        $priceProductFeatured6 = (!empty($productFeatured_6->regular_price)) ? $productFeatured_6->regular_price : $productFeatured_6->price;

        $percent1 = (!empty($productFeatured_1->sale_price)) ? ($priceProductFeatured1 != 0) ? ceil($productFeatured_1->sale_price * 100 / $priceProductFeatured1) : null : null;
        $percent2 = (!empty($productFeatured_2->sale_price)) ? ($priceProductFeatured2 != 0) ? ceil($productFeatured_2->sale_price * 100 / $priceProductFeatured2) : null : null;
        $percent3 = (!empty($productFeatured_3->sale_price)) ? ($priceProductFeatured3 != 0) ? ceil($productFeatured_3->sale_price * 100 / $priceProductFeatured3) : null : null;
        $percent4 = (!empty($productFeatured_4->sale_price)) ? ($priceProductFeatured4 != 0) ? ceil($productFeatured_4->sale_price * 100 / $priceProductFeatured4) : null : null;
        $percent5 = (!empty($productFeatured_5->sale_price)) ? ($priceProductFeatured5 != 0) ? ceil($productFeatured_5->sale_price * 100 / $priceProductFeatured5) : null : null;
        $percent6 = (!empty($productFeatured_6->sale_price)) ? ($priceProductFeatured6 != 0) ? ceil($productFeatured_6->sale_price * 100 / $priceProductFeatured6) : null : null;

echo '<div class="wrapper-wps extended">
    <div id="featured-products-section" class="homepage-section-wps">
        <h2 class="featured-deals-header wps-homepage-section-wps-header">'.$settings["featured_deals_title"].'</h2>

        <ul class="productGrid grid-wps grid-wps--uniform" data-product-type="featured">';

for($i = 1; $i <= 6; $i++){

       echo '
    <li class="product grid-wps__item large-up--one-third">
                <article class="card-wrapper-wps featured-card-container productCard data-event-type">
                    <div class="card-header">
                        <h2 class="featured-daily-title">
                            <span class="featured-title-content">Daily deal</span>
                        </h2>
                    </div>
                    <div class="card featured-card">
                        <a href="'.  ${"productUrl$i"}.'"
                           data-event-type="product-click">
                            <figure class="card-figure">
                                <div class="card-img-container">
                                    <img src="'.  ${"imageUrl$i"}.'"
                                         alt="Perfecter Iron 2-in-1 Hair Straightener &amp; Hot Round Brush product image"
                                         data-sizes="auto"
                                         class="card-image lazyautosizes lazyloaded" sizes="309px">
                                </div>
                            </figure>
                            <div class="card-body">
                                <p class="h4 card-title">'.  ${"productFeatured_$i"}->name.'</p>


                                <a href="'. ${"productUrl$i"}.'" class="button product_type_simple add_to_cart_button_wps "  rel="nofollow">
<del><span class="woocommerce-Price-amount amount"
><bdi>
<span class="woocommerce-Price-currencySymbol">$</span> '. ${"priceProductFeatured$i"} .'</bdi></span></del> 
<ins>
<span class="woocommerce-Price-amount amount">
<bdi>
<span class="woocommerce-Price-currencySymbol">$</span>'. ${"productFeatured_$i"}->sale_price.'
</bdi>
</span>
</ins>
<br><span class="discount">save '.${"percent$i"}.'%</span></a>

                            </div>
                        </a>
                    </div>
                </article>
            </li>
    ';


}

echo '       </ul>
    </div>
</div>';

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
