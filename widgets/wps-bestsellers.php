<?php

namespace Elementor\Wps\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;


if (!defined('ABSPATH')) exit; // Exit if accessed directly

/**
 * @since 1.1.0
 */
class Wps_Bestsellers extends \Elementor\Widget_Base
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
        return 'wps-bestsellers';
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
        return __('Wps Best Sellers', 'elementor-wps-bestsellers');
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
        $scripts = ['elementor-wps-bestsellers'];

        return $scripts;
    }

    public function get_style_depends()
    {
        $styles = ['elementor-wps-bestsellers'];

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

            if(is_object($product)){
                $optionProduct[$product->get_id()] = $product->get_id() . ' - ' . $product->get_name();
            }
        }

        foreach ($products as $productVariant) {
            if ($productVariant->is_type('variable')) {
                $variation_ids = $productVariant->get_visible_children();
                foreach ($variation_ids as $variation_id) {
                    $variation = wc_get_product($variation_id);

                    if(is_object($variation)){
                        $optionProductVariant[$variation_id] = $variation->get_id() . ' - ' . $variation->get_name();
                    }
                }
            }
        }

        /**
         * BestSellers
         */

        $this->start_controls_section(
            'section_content',
            [
                'label' => __('First tab', 'elementor-wps-bestsellers'),
            ]
        );


        $this->add_control(
            'title_1',
            [
                'label' => __('Title', 'elementor-wps-bestsellers'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Best Sellers', 'elementor-wps-bestsellers'),
                'placeholder' => __('Title first tab', 'elementor-wps-bestsellers'),
            ]
        );

        $this->add_control(
            'title_1_color',
            [
                'label' => __('Title color', 'elementor-wps-bestsellers'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#000000',
            ]
        );

        $this->add_control(
            'title_1_color_selected',
            [
                'label' => __('Title color selected', 'elementor-wps-bestsellers'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#000000',
            ]
        );

        $this->add_control(
            'hr0',
            [
                'type' => \Elementor\Controls_Manager::DIVIDER,
            ]
        );

        for ($i = 1; $i <= 4; $i++) {

            $this->add_control(
                'important_note_' . $i,
                [
                    'type' => \Elementor\Controls_Manager::RAW_HTML,
                    'raw' => __('Select ' . $i . ' product or variant', 'elementor-wps-bestsellers'),
                ]
            );

            $this->add_control(
                'id_product_' . $i,
                [
                    'label' => __('Select product ' . $i, 'elementor-wps-bestsellers'),
                    'type' => Controls_Manager::SELECT2,
                    'options' => $optionProduct,
                    'default' => __('Empty', 'elementor-wps-bestsellers'),
                ]
            );

            $this->add_control(
                'or_note_' . $i,
                [
                    'type' => \Elementor\Controls_Manager::RAW_HTML,
                    'raw' => __('OR', 'elementor-wps-bestsellers'),
                ]
            );

            $this->add_control(
                'id_variant_' . $i,
                [
                    'label' => __('Select variant ' . $i, 'elementor-wps-bestsellers'),
                    'type' => Controls_Manager::SELECT2,
                    'options' => $optionProductVariant,
                    'default' => __('Empty', 'elementor-wps-bestsellers'),
                ]
            );

            $this->add_control(
                'id_product_sale_' . $i,
                [
                    'label' => __('Sale price over ' . $i, 'elementor-wps'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                ]
            );

            $this->add_control(
                'id_product_color_button_' . $i,
                [
                    'label' => __('Select color button', 'elementor-wps-bestsellers'),
                    'type' => Controls_Manager::SELECT,
                    'options' => [
                        '301A46' => 'standart', 'ffffff' => 'white',
                        '000000' => 'black',
                        '795a78' => 'purple',
                        '276699' => 'blue',
                    ],
                    'default' => __('301A46', 'elementor-wps-bestsellers'),
                ]
            );

            $this->add_control(
                'id_product_color_background_' . $i,
                [
                    'label' => __('Select color background', 'elementor-wps-bestsellers'),
                    'type' => \Elementor\Controls_Manager::COLOR,
                    'default' => '#ffffff',
                ]
            );

            $this->add_control(
                'id_product_title_' . $i,
                [
                    'label' => __('Title product ' . $i, 'elementor-wps'),
                    'type' => \Elementor\Controls_Manager::TEXTAREA,
                ]
            );

            $this->add_control(
                'id_product_image_' . $i,
                [
                    'label' => __('Choose Image for product ' . $i, 'elementor-wps'),
                    'type' => \Elementor\Controls_Manager::MEDIA,
                ]
            );

            $this->add_control(
                'hr' . $i,
                [
                    'type' => \Elementor\Controls_Manager::DIVIDER,
                ]
            );

        }

        $this->end_controls_section();


        /**
         * New Arrivals
         */

        $this->start_controls_section(
            'section_content_new_arrivals',
            [
                'label' => __('Second tab', 'elementor-wps-bestsellers'),
            ]
        );

        $this->add_control(
            'title_2',
            [
                'label' => __('Title', 'elementor-wps-bestsellers'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('New arrivals', 'elementor-wps-bestsellers'),
                'placeholder' => __('Title second tab', 'elementor-wps-bestsellers'),
            ]
        );

        $this->add_control(
            'title_2_color',
            [
                'label' => __('Title color', 'elementor-wps-bestsellers'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#000000',
            ]
        );

        $this->add_control(
            'title_2_color_selected',
            [
                'label' => __('Title color selected', 'elementor-wps-bestsellers'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#000000',
            ]
        );

        $this->add_control(
            'hr0_new_arrivals',
            [
                'type' => \Elementor\Controls_Manager::DIVIDER,
            ]
        );

        for ($pna = 1; $pna <= 4; $pna++) {
            $this->add_control(
                'important_note_new_arrivals_' . $pna,
                [
                    'type' => \Elementor\Controls_Manager::RAW_HTML,
                    'raw' => __('Select ' . $pna . ' product or variant', 'elementor-wps-bestsellers'),
                ]
            );

            $this->add_control(
                'id_product_new_arrivals_' . $pna,
                [
                    'label' => __('Select product ' . $pna, 'elementor-wps-bestsellers'),
                    'type' => Controls_Manager::SELECT2,
                    'options' => $optionProduct,
                    'default' => __('Empty', 'elementor-wps-bestsellers'),
                ]
            );

            $this->add_control(
                'or_note_new_arrivals_' . $pna,
                [
                    'type' => \Elementor\Controls_Manager::RAW_HTML,
                    'raw' => __('OR', 'elementor-wps-bestsellers'),
                ]
            );

            $this->add_control(
                'id_variant_new_arrivals_' . $pna,
                [
                    'label' => __('Select variant '. $pna, 'elementor-wps-bestsellers'),
                    'type' => Controls_Manager::SELECT2,
                    'options' => $optionProductVariant,
                    'default' => __('Empty', 'elementor-wps-bestsellers'),
                ]
            );

            $this->add_control(
                'id_product_sale_new_arrivals_' . $pna,
                [
                    'label' => __('Sale price over ' . $pna, 'elementor-wps'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                ]
            );

            $this->add_control(
                'id_product_color_button_new_arrivals_' . $pna,
                [
                    'label' => __('Select color button', 'elementor-wps-bestsellers'),
                    'type' => Controls_Manager::SELECT,
                    'options' => [
                        '301A46' => 'standart', 'ffffff' => 'white',
                        '000000' => 'black',
                        '795a78' => 'purple',
                        '276699' => 'blue',
                    ],
                    'default' => __('301A46', 'elementor-wps-bestsellers'),
                ]
            );

            $this->add_control(
                'id_product_color_background_new_arrivals_' . $pna,
                [
                    'label' => __('Select color background', 'elementor-wps-bestsellers'),
                    'type' => \Elementor\Controls_Manager::COLOR,
                    'default' => '#ffffff',
                ]
            );

            $this->add_control(
                'id_product_title_new_arrivals_' . $pna,
                [
                    'label' => __('Title product ' . $pna, 'elementor-wps'),
                    'type' => \Elementor\Controls_Manager::TEXTAREA,
                ]
            );

            $this->add_control(
                'id_product_image_new_arrivals_' . $pna,
                [
                    'label' => __('Choose Image for product ' . $pna, 'elementor-wps'),
                    'type' => \Elementor\Controls_Manager::MEDIA,
                ]
            );

            $this->add_control(
                'hr_new_arrivals' . $pna,
                [
                    'type' => \Elementor\Controls_Manager::DIVIDER,
                ]
            );
        }

        $this->end_controls_section();


        /**
         * Clearance
         */

        $this->start_controls_section(
            'section_content_clearance',
            [
                'label' => __('Third tab ', 'elementor-wps-bestsellers'),
            ]
        );

        $this->add_control(
            'title_3',
            [
                'label' => __('Title', 'elementor-wps-bestsellers'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Clearance', 'elementor-wps-bestsellers'),
                'placeholder' => __('Title third tab', 'elementor-wps-bestsellers'),
            ]
        );

        $this->add_control(
            'title_3_color',
            [
                'label' => __('Title color', 'elementor-wps-bestsellers'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#000000',
            ]
        );

        $this->add_control(
            'title_3_color_selected',
            [
                'label' => __('Title color selected', 'elementor-wps-bestsellers'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#000000',
            ]
        );

        $this->add_control(
            'hr0_clearance',
            [
                'type' => \Elementor\Controls_Manager::DIVIDER,
            ]
        );

        for ($pc = 1; $pc <= 4; $pc++) {
            $this->add_control(
                'important_note_clearance_' . $pc,
                [
                    'type' => \Elementor\Controls_Manager::RAW_HTML,
                    'raw' => __('Select ' . $pc . ' product or variant', 'elementor-wps-bestsellers'),
                ]
            );

            $this->add_control(
                'id_product_clearance_' . $pc,
                [
                    'label' => __('Select product ' . $pc, 'elementor-wps-bestsellers'),
                    'type' => Controls_Manager::SELECT2,
                    'options' => $optionProduct,
                    'default' => __('Empty', 'elementor-wps-bestsellers'),
                ]
            );

            $this->add_control(
                'or_note_clearance_' . $pc,
                [
                    'type' => \Elementor\Controls_Manager::RAW_HTML,
                    'raw' => __('OR', 'elementor-wps-bestsellers'),
                ]
            );

            $this->add_control(
                'id_variant_clearance_' . $pc,
                [
                    'label' => __('Select variant ' . $pc, 'elementor-wps-bestsellers'),
                    'type' => Controls_Manager::SELECT2,
                    'options' => $optionProductVariant,
                    'default' => __('Empty', 'elementor-wps-bestsellers'),
                ]
            );

            $this->add_control(
                'id_product_sale_clearance_' . $pc,
                [
                    'label' => __('Sale price over ' . $pc, 'elementor-wps'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                ]
            );

            $this->add_control(
                'id_product_color_button_clearance_' . $pc,
                [
                    'label' => __('Select color button', 'elementor-wps-bestsellers'),
                    'type' => Controls_Manager::SELECT,
                    'options' => [
                        '301A46' => 'standart', 'ffffff' => 'white',
                        '000000' => 'black',
                        '795a78' => 'purple',
                        '276699' => 'blue',
                    ],
                    'default' => __('301A46', 'elementor-wps-bestsellers'),
                ]
            );

            $this->add_control(
                'id_product_color_background_clearance_' . $pc,
                [
                    'label' => __('Select color backgorund', 'elementor-wps-bestsellers'),
                    'type' => \Elementor\Controls_Manager::COLOR,
                    'default' => '#ffffff',
                ]
            );

            $this->add_control(
                'id_product_title_clearance_' . $pc,
                [
                    'label' => __('Title product ' . $pc, 'elementor-wps'),
                    'type' => \Elementor\Controls_Manager::TEXTAREA,
                ]
            );

            $this->add_control(
                'id_product_image_clearance_' . $pc,
                [
                    'label' => __('Choose Image for product ' . $pc, 'elementor-wps'),
                    'type' => \Elementor\Controls_Manager::MEDIA,
                ]
            );

            $this->add_control(
                'hr' . $pc . '_clearance',
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
        $countProduct = 4;
        /**
         * Best sellers data, first tab
         */
        for ($pbs = 1; $pbs <= $countProduct; $pbs++) {
            ${"idProduct_$pbs"} = (!empty($settings['id_product_' . $pbs]) && $settings['id_product_' . $pbs] != 'Empty') ? $settings['id_product_' . $pbs] : $settings['id_variant_' . $pbs];

            if (!empty(${"idProduct_$pbs"}) && ${"idProduct_$pbs"} != 'Empty') {
                ${"product$pbs"} = wc_get_product(${"idProduct_$pbs"});
                ${"productUrl$pbs"} = ${"product$pbs"}->get_permalink();
                ${"productName$pbs"} = (!empty($settings['id_product_title_' . $pbs])) ? $settings['id_product_title_' . $pbs] : ${"product$pbs"}->name;
                ${"imageUrl$pbs"} = (!empty($settings['id_product_image_' . $pbs]['url'])) ? $settings['id_product_image_' . $pbs]['url'] : wp_get_attachment_url(${"product$pbs"}->image_id);
                ${"priceProduct$pbs"} = (!empty(${"product$pbs"}->regular_price)) ? ${"product$pbs"}->regular_price : ${"product$pbs"}->price;

                /**
                 * update sale if exist over sale in module
                 */
                if ((${"product$pbs"}->sale_price != $settings['id_product_sale_' . $pbs]) &&
                    !empty($settings['id_product_sale_' . $pbs]) &&
                    $settings['id_product_sale_' . $pbs] != 0
                ) {
                    ${"product$pbs"}->set_sale_price($settings['id_product_sale_' . $pbs]);
                    ${"product$pbs"}->save();
                }

                ${"priceSaleProduct$pbs"} = (!empty(${"product$pbs"}->sale_price)) ? ${"product$pbs"}->sale_price : null;
                ${"percent$pbs"} = (!empty(${"product$pbs"}->sale_price)) ? (${"priceProduct$pbs"} != 0) ? (100 - ceil(${"product$pbs"}->sale_price * 100 / ${"priceProduct$pbs"})) : null : null;
            }

        }

        /**
         * New Arrivals data
         */
        for ($pna = 1; $pna <= $countProduct; $pna++) {
            ${"idProductNewArrivals_$pna"} = (!empty($settings['id_product_new_arrivals_' . $pna]) && $settings['id_product_new_arrivals_' . $pna] != 'Empty') ? $settings['id_product_new_arrivals_' . $pna] : $settings['id_variant_new_arrivals_' . $pna];

            if (!empty(${"idProductNewArrivals_$pna"}) && ${"idProductNewArrivals_$pna"} != 'Empty') {
                ${"productNewArrivals$pna"} = wc_get_product(${"idProductNewArrivals_$pna"});
                ${"productUrlNewArrivals$pna"} = ${"productNewArrivals$pna"}->get_permalink();
                ${"productNameNewArrivals$pna"} = (!empty($settings['id_product_title_new_arrivals_' . $pna])) ? $settings['id_product_title_new_arrivals_' . $pna] : ${"productNewArrivals$pna"}->name;
                ${"imageUrlNewArrivals$pna"} = (!empty($settings['id_product_image_new_arrivals_' . $pna]['url'])) ? $settings['id_product_image_new_arrivals_' . $pna]['url'] : wp_get_attachment_url(${"productNewArrivals$pna"}->image_id);
                ${"priceProductNewArrivals$pna"} = (!empty(${"productNewArrivals$pna"}->regular_price)) ? ${"productNewArrivals$pna"}->regular_price : ${"productNewArrivals$pna"}->price;

                /**
                 * update sale if exist over sale in module
                 */
                if ((${"productNewArrivals$pna"}->sale_price != $settings['id_product_sale_new_arrivals_' . $pna]) &&
                    !empty($settings['id_product_sale_new_arrivals_' . $pna]) &&
                    $settings['id_product_sale_new_arrivals_' . $pna] != 0
                ) {
                    ${"productNewArrivals$pna"}->set_sale_price($settings['id_product_sale_new_arrivals_' . $pna]);
                    ${"productNewArrivals$pna"}->save();
                }

                ${"priceSaleProductNewArrivals$pna"} = (!empty(${"productNewArrivals$pna"}->sale_price)) ? ${"productNewArrivals$pna"}->sale_price : null;
                ${"percentNewArrivals$pna"} = (!empty(${"productNewArrivals$pna"}->sale_price)) ? (${"priceProductNewArrivals$pna"} != 0) ? (100 - ceil(${"productNewArrivals$pna"}->sale_price * 100 / ${"priceProductNewArrivals$pna"})) : null : null;
            }

        }

        /**
         * Clearance data
         */
        for ($pc = 1; $pc <= $countProduct; $pc++) {
            ${"idProductClearance_$pc"} = (!empty($settings['id_product_clearance_' . $pc]) && $settings['id_product_clearance_' . $pc] != 'Empty') ? $settings['id_product_clearance_' . $pc] : $settings['id_variant_clearance_' . $pc];

            if (!empty(${"idProductClearance_$pc"}) && ${"idProductClearance_$pc"} != 'Empty') {
                ${"productClearance$pc"} = wc_get_product(${"idProductClearance_$pc"});
                ${"productUrlClearance$pc"} = ${"productClearance$pc"}->get_permalink();
                ${"productNameClearance$pc"} = (!empty($settings['id_product_title_clearance_' . $pc])) ? $settings['id_product_title_clearance_' . $pc] : ${"productClearance$pc"}->name;
                ${"imageUrlClearance$pc"} = (!empty($settings['id_product_image_clearance_' . $pc]['url'])) ? $settings['id_product_image_clearance_' . $pc]['url'] : wp_get_attachment_url(${"productClearance$pc"}->image_id);
                ${"priceProductClearance$pc"} = (!empty(${"productClearance$pc"}->regular_price)) ? ${"productClearance$pc"}->regular_price : ${"productClearance$pc"}->price;

                /**
                 * update sale if exist over sale in module
                 */
                if ((${"productClearance$pc"}->sale_price != $settings['id_product_sale_clearance_' . $pc]) &&
                    !empty($settings['id_product_sale_clearance_' . $pc]) &&
                    $settings['id_product_sale_clearance_' . $pc] != 0
                ) {
                    ${"productClearance$pc"}->set_sale_price($settings['id_product_sale_clearance_' . $pc]);
                    ${"productClearance$pc"}->save();
                }

                ${"priceSaleProductClearance$pc"} = (!empty(${"productClearance$pc"}->sale_price)) ? ${"productClearance$pc"}->sale_price : null;
                ${"percentClearance$pc"} = (!empty(${"productClearance$pc"}->sale_price)) ? (${"priceProductClearance$pc"} != 0) ? (100 - ceil(${"productClearance$pc"}->sale_price * 100 / ${"priceProductClearance$pc"})) : null : null;
            }

        }

        echo '
<style type="text/css">
    a.best-sellers{
        color:' . $settings['title_1_color'] . ';
    }    
    a.best-sellers.selected{
        color:' . $settings['title_1_color_selected'] . ';
    }
    a.new-arrivals{
        color:' . $settings['title_2_color'] . ';
    }
    a.new-arrivals.selected{
        color:' . $settings['title_2_color_selected'] . ';
    }
    a.clearance{
        color:' . $settings['title_3_color'] . ';
    }
    a.clearance.selected{
        color:' . $settings['title_3_color_selected'] . ';
    }
</style>
<div id="wps-bestsellers">
    <h2>
        <a class="best-sellers selected">' . $settings['title_1'] . '</a>
        <a class="new-arrivals">' . $settings['title_2'] . '</a>
        <a class="clearance"">' . $settings['title_3'] . '</a>
    </h2>
    <section class="best-sellers" style="">
        <header>
            <h3><a href="/wps-bestsellers">' . $settings['title_1'] . '</a></h3>
        </header>
        <div class="offers">
            <div class="offer dark right" style="background-color:' . $settings['id_product_color_background_1'] . ';">
                <div class="photo">
                    <a href="' . $productUrl1 . '">
                        <img data-src="' . $imageUrl1 . '"
                             height="181" width="181"
                             src="' . $imageUrl1 . '">
                    </a>
                </div>
                <div class="content">
                    <h2>
                        <a href="' . $productUrl1 . '">
                            ' . $productName1 . '
                        </a>
                    </h2>
                    <h3 style="background-color:#' . $settings['id_product_color_button_1'] . ';">
                        <a href="' . $productUrl1 . '">
                        <span class="list-price">
                            ' . $priceProduct1 . '
                        </span>
                            <span class="sale-price">' . $priceSaleProduct1 . '</span>
                            <span class="discount">save ' . $percent1 . '%</span>
                        </a>
                    </h3>
                </div>
            </div>

            <div class="offer dark"  style="background-color:' . $settings['id_product_color_background_2'] . ';">
               <div class="photo">
                    <a href="' . $productUrl2 . '">
                        <img data-src="' . $imageUrl2 . '"
                             height="181" width="181"
                             src="' . $imageUrl2 . '">
                    </a>
                </div>
                <div class="content">
                    <h2>
                        <a href="' . $productUrl2 . '">
                            ' . $productName2 . '
                        </a>
                    </h2>
                    <h3 style="background-color:#' . $settings['id_product_color_button_2'] . ';">
                        <a href="' . $productUrl2 . '">
                        <span class="list-price">
                            ' . $priceProduct2 . '
                        </span>
                            <span class="sale-price">' . $priceSaleProduct2 . '</span>
                            <span class="discount">save ' . $percent2 . '%</span>
                        </a>
                    </h3>
                </div>
            </div>


            <div class="offer dark" style="background-color:' . $settings['id_product_color_background_3'] . ';">
               <div class="photo">
                    <a href="' . $productUrl3 . '">
                        <img data-src="' . $imageUrl3 . '"
                             height="181" width="181"
                             src="' . $imageUrl3 . '">
                    </a>
                </div>
                <div class="content">
                    <h2>
                        <a href="' . $product_3->slug . '">
                            ' . $productName3 . '
                        </a>
                    </h2>
                    <h3 style="background-color:#' . $settings['id_product_color_button_3'] . ';">
                        <a href="' . $productUrl3 . '">
                        <span class="list-price">
                            ' . $priceProduct3 . '
                        </span>
                            <span class="sale-price">' . $priceSaleProduct3 . '</span>
                            <span class="discount">save ' . $percent3 . '%</span>
                        </a>
                    </h3>
                </div>
            </div>

            <div class="offer dark right" style="background-color:' . $settings['id_product_color_background_4'] . ';">
               <div class="photo">
                    <a href="' . $productUrl4 . '">
                        <img data-src="' . $imageUrl4 . '"
                             height="181" width="181"
                             src="' . $imageUrl4 . '">
                    </a>
                </div>
                <div class="content">
                    <h2>
                        <a href="' . $productUrl4 . '">
                            ' . $productName4 . '
                        </a>
                    </h2>
                    <h3 style="background-color:#' . $settings['id_product_color_button_4'] . ';">
                        <a href="' . $productUrl4 . '">
                        <span class="list-price">
                            ' . $priceProduct4 . '
                        </span>
                            <span class="sale-price">' . $priceSaleProduct4 . '</span>
                            <span class="discount">save ' . $percent4 . '%</span>
                        </a>
                    </h3>
                </div>
            </div>
        </div>
    </section>
    
    <section class="new-arrivals" style="display: none;">
        <header>
            <h3><a href="/wps-bestsellers">' . $settings['title_1'] . '</a></h3>
        </header>
        <div class="offers">
            <div class="offer dark" style="background-color:' . $settings['id_product_color_background_new_arrivals_1'] . ';">
                <div class="photo">
                    <a href="' . $productUrlNewArrivals1 . '">
                        <img data-src="' . $imageUrlNewArrivals1 . '"
                             height="181" width="181"
                             src="' . $imageUrlNewArrivals1 . '">
                    </a>
                </div>
                <div class="content">
                    <h2>
                        <a href="' . $productUrlNewArrivals1 . '">
                            ' . $productNameNewArrivals1 . '
                        </a>
                    </h2>
                    <h3 style="background-color:#' . $settings['id_product_color_button_new_arrivals_1'] . ';">
                        <a href="' . $productUrlNewArrivals1 . '">
                        <span class="list-price">
                            ' . $priceProductNewArrivals1 . '
                        </span>
                            <span class="sale-price">' . $priceSaleProductNewArrivals1 . '</span>
                            <span class="discount">save ' . $percentNewArrivals1 . '%</span>
                        </a>
                    </h3>
                </div>
            </div>

            <div class="offer dark "  style="background-color:' . $settings['id_product_color_background_new_arrivals_2'] . ';">
               <div class="photo">
                    <a href="' . $productUrlNewArrivals2 . '">
                        <img data-src="' . $imageUrlNewArrivals2 . '"
                             height="181" width="181"
                             src="' . $imageUrlNewArrivals2 . '">
                    </a>
                </div>
                <div class="content">
                    <h2>
                        <a href="' . $productUrlNewArrivals2 . '">
                            ' . $productNameNewArrivals2 . '
                        </a>
                    </h2>
                    <h3 style="background-color:#' . $settings['id_product_color_button_new_arrivals_2'] . ';">
                        <a href="' . $productUrlNewArrivals2 . '">
                        <span class="list-price">
                            ' . $priceProductNewArrivals2 . '
                        </span>
                            <span class="sale-price">' . $priceSaleProductNewArrivals2 . '</span>
                            <span class="discount">save ' . $percentNewArrivals2 . '%</span>
                        </a>
                    </h3>
                </div>
            </div>


            <div class="offer dark right" style="background-color:' . $settings['id_product_color_background_new_arrivals_3'] . ';">
               <div class="photo">
                    <a href="' . $productUrlNewArrivals3 . '">
                        <img data-src="' . $imageUrlNewArrivals3 . '"
                             height="181" width="181"
                             src="' . $imageUrlNewArrivals3 . '">
                    </a>
                </div>
                <div class="content">
                    <h2>
                        <a href="' . $productUrlNewArrivals3 . '">
                            ' . $productNameNewArrivals3 . '
                        </a>
                    </h2>
                    <h3 style="background-color:#' . $settings['id_product_color_button_new_arrivals_3'] . ';">
                        <a href="' . $productUrlNewArrivals3 . '">
                        <span class="list-price">
                            ' . $priceProductNewArrivals3 . '
                        </span>
                            <span class="sale-price">' . $priceSaleProductNewArrivals3 . '</span>
                            <span class="discount">save ' . $percentNewArrivals3 . '%</span>
                        </a>
                    </h3>
                </div>
            </div>

            <div class="offer dark right" style="background-color:' . $settings['id_product_color_background_new_arrivals_4'] . ';">
               <div class="photo">
                    <a href="/' . $productUrlNewArrivals4 . '">
                        <img data-src="' . $imageUrlNewArrivals4 . '"
                             height="181" width="181"
                             src="' . $imageUrlNewArrivals4 . '">
                    </a>
                </div>
                <div class="content">
                    <h2>
                        <a href="' . $productUrlNewArrivals4 . '">
                            ' . $productNameNewArrivals4 . '
                        </a>
                    </h2>
                    <h3 style="background-color:#' . $settings['id_product_color_button_new_arrivals_4'] . ';">
                        <a href="' . $productUrlNewArrivals4 . '">
                        <span class="list-price">
                            ' . $priceProductNewArrivals4 . '
                        </span>
                            <span class="sale-price">' . $priceSaleProductNewArrivals4 . '</span>
                            <span class="discount">save ' . $percentNewArrivals4 . '%</span>
                        </a>
                    </h3>
                </div>
            </div>
        </div>
    </section>
    
    <section class="clearance" style="display: none;">
        <header>
            <h3><a href="/wps-bestsellers">' . $settings['title_1'] . '</a></h3>
        </header>
        <div class="offers">
            <div class="offer dark" style="background-color:' . $settings['id_product_color_background_clearance_1'] . ';">
                <div class="photo">
                    <a href="' . $productUrlClearance1 . '">
                        <img data-src="' . $imageUrlClearance1 . '"
                             height="181" width="181"
                             src="' . $imageUrlClearance1 . '">
                    </a>
                </div>
                <div class="content">
                    <h2>
                        <a href="' . $productUrlClearance1 . '">
                            ' . $productNameClearance1 . '
                        </a>
                    </h2>
                    <h3 style="background-color:#' . $settings['id_product_color_button_clearance_1'] . ';">
                        <a href="' . $productUrlClearance1 . '">
                        <span class="list-price">
                            ' . $priceProductClearance1 . '
                        </span>
                            <span class="sale-price">' . $priceSaleProductClearance1 . '</span>
                            <span class="discount">save ' . $percentClearance1 . '%</span>
                        </a>
                    </h3>
                </div>
            </div>

            <div class="offer dark right"  style="background-color:' . $settings['id_product_color_background_clearance_2'] . ';">
               <div class="photo">
                    <a href="' . $productUrlClearance2 . '">
                        <img data-src="' . $imageUrlClearance2 . '"
                             height="181" width="181"
                             src="' . $imageUrlClearance2 . '">
                    </a>
                </div>
                <div class="content">
                    <h2>
                        <a href="' . $productUrlClearance2 . '">
                            ' . $productNameClearance2 . '
                        </a>
                    </h2>
                    <h3 style="background-color:#' . $settings['id_product_color_button_clearance_2'] . ';">
                        <a href="' . $productUrlClearance2 . '">
                        <span class="list-price">
                            ' . $priceProductClearance2 . '
                        </span>
                            <span class="sale-price">' . $priceSaleProductClearance2 . '</span>
                            <span class="discount">save ' . $percentClearance2 . '%</span>
                        </a>
                    </h3>
                </div>
            </div>


            <div class="offer dark" style="background-color:' . $settings['id_product_color_background_clearance_3'] . ';">
               <div class="photo">
                    <a href="' . $productUrlClearance3 . '">
                        <img data-src="' . $imageUrlClearance3 . '"
                             height="181" width="181"
                             src="' . $imageUrlClearance3 . '">
                    </a>
                </div>
                <div class="content">
                    <h2>
                        <a href="' . $productUrlClearance3 . '">
                            ' . $productNameClearance3 . '
                        </a>
                    </h2>
                    <h3 style="background-color:#' . $settings['id_product_color_button_clearance_3'] . ';">
                        <a href="' . $productUrlClearance3 . '">
                        <span class="list-price">
                            ' . $priceProductClearance3 . '
                        </span>
                            <span class="sale-price">' . $priceSaleProductClearance3 . '</span>
                            <span class="discount">save ' . $percentClearance3 . '%</span>
                        </a>
                    </h3>
                </div>
            </div>

            <div class="offer dark right" style="background-color:' . $settings['id_product_color_background_clearance_4'] . ';">
               <div class="photo">
                    <a href="' . $productUrlClearance4 . '">
                        <img data-src="' . $imageUrlClearance4 . '"
                             height="181" width="181"
                             src="' . $imageUrlClearance4 . '">
                    </a>
                </div>
                <div class="content">
                    <h2>
                        <a href="' . $productUrlClearance4 . '">
                            ' . $productNameClearance4 . '
                        </a>
                    </h2>
                    <h3 style="background-color:#' . $settings['id_product_color_button_clearance_4'] . ';">
                        <a href="' . $productUrlClearance4 . '">
                        <span class="list-price">
                            ' . $priceProductClearance4 . '
                        </span>
                            <span class="sale-price">' . $priceSaleProductClearance4 . '</span>
                            <span class="discount">save ' . $percentClearance4 . '%</span>
                        </a>
                    </h3>
                </div>
            </div>
        </div>
    </section>
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
