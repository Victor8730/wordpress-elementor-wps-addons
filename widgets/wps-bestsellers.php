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
        $optionProduct = ['' => 'Empty'];
        $optionProductVariant = ['' => 'Empty'];
        $products = wc_get_products($args);

        foreach ($products as $product) {
            $optionProduct[$product->get_id()] = $product->get_id() . ' - ' . $product->get_name();
        }

        foreach ($products as $productVariant) {
            if ($productVariant->is_type('variable')) {
                $variation_ids = $productVariant->get_visible_children();
                foreach ($variation_ids as $variation_id) {
                    $variation = wc_get_product($variation_id);
                    $optionProductVariant[$variation_id] = $variation->get_id() . ' - ' . $variation->get_name();
                }
            }
        }


        /**
         * BestSellers
         */

        $this->start_controls_section(
            'section_content',
            [
                'label' => __('Best sellers', 'elementor-wps-bestsellers'),
            ]
        );

        $this->add_control(
            'important_note_1_0',
            [
                'type' => \Elementor\Controls_Manager::RAW_HTML,
                'raw' => __('Specify products to display on the best sellers tab', 'elementor-wps-bestsellers'),
            ]
        );

        $this->add_control(
            'hr0',
            [
                'type' => \Elementor\Controls_Manager::DIVIDER,
            ]
        );

        $this->add_control(
            'important_note_1',
            [
                'type' => \Elementor\Controls_Manager::RAW_HTML,
                'raw' => __('Select first product or variant', 'elementor-wps-bestsellers'),
            ]
        );

        $this->add_control(
            'id_product_1',
            [
                'label' => __('Select product 1', 'elementor-wps-bestsellers'),
                'type' => Controls_Manager::SELECT,
                'options' => $optionProduct,
                'default' => __('Empty', 'elementor-wps-bestsellers'),
            ]
        );

        $this->add_control(
            'or_note_1',
            [
                'type' => \Elementor\Controls_Manager::RAW_HTML,
                'raw' => __('OR', 'elementor-wps-bestsellers'),
            ]
        );

        $this->add_control(
            'id_variant_1',
            [
                'label' => __('Select variant 1', 'elementor-wps-bestsellers'),
                'type' => Controls_Manager::SELECT,
                'options' => $optionProductVariant,
                'default' => __('Empty', 'elementor-wps-bestsellers'),
            ]
        );

        $this->add_control(
            'id_product_1_color',
            [
                'label' => __('Select color button', 'elementor-wps-bestsellers'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'ffffff' => 'white',
                    '000000' => 'black',
                    '795a78' => 'purple',
                    '276699' => 'blue',
                ],
                'default' => __('000000', 'elementor-wps-bestsellers'),
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
                'raw' => __('Select second product or variant', 'elementor-wps-bestsellers'),
            ]
        );

        $this->add_control(
            'id_product_2',
            [
                'label' => __('Select product 2', 'elementor-wps-bestsellers'),
                'type' => Controls_Manager::SELECT,
                'options' => $optionProduct,
                'default' => __('Empty', 'elementor-wps-bestsellers'),
            ]
        );

        $this->add_control(
            'or_note_2',
            [
                'type' => \Elementor\Controls_Manager::RAW_HTML,
                'raw' => __('OR', 'elementor-wps-bestsellers'),
            ]
        );

        $this->add_control(
            'id_variant_2',
            [
                'label' => __('Select variant 2', 'elementor-wps-bestsellers'),
                'type' => Controls_Manager::SELECT,
                'options' => $optionProductVariant,
                'default' => __('Empty', 'elementor-wps-bestsellers'),
            ]
        );

        $this->add_control(
            'id_product_2_color',
            [
                'label' => __('Select color button', 'elementor-wps-bestsellers'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'ffffff' => 'white',
                    '000000' => 'black',
                    '795a78' => 'purple',
                    '276699' => 'blue',
                ],
                'default' => __('000000', 'elementor-wps-bestsellers'),
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
                'raw' => __('Select the third product or variant', 'elementor-wps-bestsellers'),
            ]
        );

        $this->add_control(
            'id_product_3',
            [
                'label' => __('Select product 3', 'elementor-wps-bestsellers'),
                'type' => Controls_Manager::SELECT,
                'options' => $optionProduct,
                'default' => __('Empty', 'elementor-wps-bestsellers'),
            ]
        );

        $this->add_control(
            'or_note_3',
            [
                'type' => \Elementor\Controls_Manager::RAW_HTML,
                'raw' => __('OR', 'elementor-wps-bestsellers'),
            ]
        );

        $this->add_control(
            'id_variant_3',
            [
                'label' => __('Select variant 3', 'elementor-wps-bestsellers'),
                'type' => Controls_Manager::SELECT,
                'options' => $optionProductVariant,
                'default' => __('Empty', 'elementor-wps-bestsellers'),
            ]
        );

        $this->add_control(
            'id_product_3_color',
            [
                'label' => __('Select color button', 'elementor-wps-bestsellers'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'ffffff' => 'white',
                    '000000' => 'black',
                    '795a78' => 'purple',
                    '276699' => 'blue',
                ],
                'default' => __('000000', 'elementor-wps-bestsellers'),
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
                'raw' => __('Select the fourth product or variant', 'elementor-wps-bestsellers'),
            ]
        );

        $this->add_control(
            'id_product_4',
            [
                'label' => __('Select product 4', 'elementor-wps-bestsellers'),
                'type' => Controls_Manager::SELECT,
                'options' => $optionProduct,
                'default' => __('Empty', 'elementor-wps-bestsellers'),
            ]
        );

        $this->add_control(
            'or_note_4',
            [
                'type' => \Elementor\Controls_Manager::RAW_HTML,
                'raw' => __('OR', 'elementor-wps-bestsellers'),
            ]
        );

        $this->add_control(
            'id_variant_4',
            [
                'label' => __('Select variant 4', 'elementor-wps-bestsellers'),
                'type' => Controls_Manager::SELECT,
                'options' => $optionProductVariant,
                'default' => __('Empty', 'elementor-wps-bestsellers'),
            ]
        );

        $this->add_control(
            'id_product_4_color',
            [
                'label' => __('Select color button', 'elementor-wps-bestsellers'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'ffffff' => 'white',
                    '000000' => 'black',
                    '795a78' => 'purple',
                    '276699' => 'blue',
                ],
                'default' => __('000000', 'elementor-wps-bestsellers'),
            ]
        );

        $this->end_controls_section();


        /**
         * New Arrivals
         */

        $this->start_controls_section(
            'section_content_new_arrivals',
            [
                'label' => __('New Arrivals', 'elementor-wps-bestsellers'),
            ]
        );

        $this->add_control(
            'important_note_1_0_new_arrivals',
            [
                'type' => \Elementor\Controls_Manager::RAW_HTML,
                'raw' => __('Specify products to display on the new arrivals tab', 'elementor-wps-bestsellers'),
            ]
        );

        $this->add_control(
            'hr0_new_arrivals',
            [
                'type' => \Elementor\Controls_Manager::DIVIDER,
            ]
        );

        $this->add_control(
            'important_note_1_new_arrivals',
            [
                'type' => \Elementor\Controls_Manager::RAW_HTML,
                'raw' => __('Select first product or variant', 'elementor-wps-bestsellers'),
            ]
        );

        $this->add_control(
            'id_product_1_new_arrivals',
            [
                'label' => __('Select product 1', 'elementor-wps-bestsellers'),
                'type' => Controls_Manager::SELECT,
                'options' => $optionProduct,
                'default' => __('Empty', 'elementor-wps-bestsellers'),
            ]
        );

        $this->add_control(
            'or_note_1_new_arrivals',
            [
                'type' => \Elementor\Controls_Manager::RAW_HTML,
                'raw' => __('OR', 'elementor-wps-bestsellers'),
            ]
        );

        $this->add_control(
            'id_variant_1_new_arrivals',
            [
                'label' => __('Select variant 1', 'elementor-wps-bestsellers'),
                'type' => Controls_Manager::SELECT,
                'options' => $optionProductVariant,
                'default' => __('Empty', 'elementor-wps-bestsellers'),
            ]
        );

        $this->add_control(
            'id_product_1_color_new_arrivals',
            [
                'label' => __('Select color button', 'elementor-wps-bestsellers'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'ffffff' => 'white',
                    '000000' => 'black',
                    '795a78' => 'purple',
                    '276699' => 'blue',
                ],
                'default' => __('000000', 'elementor-wps-bestsellers'),
            ]
        );

        $this->add_control(
            'hr2_new_arrivals',
            [
                'type' => \Elementor\Controls_Manager::DIVIDER,
            ]
        );


        $this->add_control(
            'important_note_2_new_arrivals',
            [
                'type' => \Elementor\Controls_Manager::RAW_HTML,
                'raw' => __('Select second product or variant', 'elementor-wps-bestsellers'),
            ]
        );

        $this->add_control(
            'id_product_2_new_arrivals',
            [
                'label' => __('Select product 2', 'elementor-wps-bestsellers'),
                'type' => Controls_Manager::SELECT,
                'options' => $optionProduct,
                'default' => __('Empty', 'elementor-wps-bestsellers'),
            ]
        );

        $this->add_control(
            'or_note_2_new_arrivals',
            [
                'type' => \Elementor\Controls_Manager::RAW_HTML,
                'raw' => __('OR', 'elementor-wps-bestsellers'),
            ]
        );

        $this->add_control(
            'id_variant_2_new_arrivals',
            [
                'label' => __('Select variant 2', 'elementor-wps-bestsellers'),
                'type' => Controls_Manager::SELECT,
                'options' => $optionProductVariant,
                'default' => __('Empty', 'elementor-wps-bestsellers'),
            ]
        );

        $this->add_control(
            'id_product_2_color_new_arrivals',
            [
                'label' => __('Select color button', 'elementor-wps-bestsellers'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'ffffff' => 'white',
                    '000000' => 'black',
                    '795a78' => 'purple',
                    '276699' => 'blue',
                ],
                'default' => __('000000', 'elementor-wps-bestsellers'),
            ]
        );

        $this->add_control(
            'hr3_new_arriwals',
            [
                'type' => \Elementor\Controls_Manager::DIVIDER,
            ]
        );


        $this->add_control(
            'important_note_3_new_arrivals',
            [
                'type' => \Elementor\Controls_Manager::RAW_HTML,
                'raw' => __('Select the third product or variant', 'elementor-wps-bestsellers'),
            ]
        );

        $this->add_control(
            'id_product_3_new_arrivals',
            [
                'label' => __('Select product 3', 'elementor-wps-bestsellers'),
                'type' => Controls_Manager::SELECT,
                'options' => $optionProduct,
                'default' => __('Empty', 'elementor-wps-bestsellers'),
            ]
        );

        $this->add_control(
            'or_note_3_new_arrivals',
            [
                'type' => \Elementor\Controls_Manager::RAW_HTML,
                'raw' => __('OR', 'elementor-wps-bestsellers'),
            ]
        );

        $this->add_control(
            'id_variant_3_new_arrivals',
            [
                'label' => __('Select variant 3', 'elementor-wps-bestsellers'),
                'type' => Controls_Manager::SELECT,
                'options' => $optionProductVariant,
                'default' => __('Empty', 'elementor-wps-bestsellers'),
            ]
        );

        $this->add_control(
            'id_product_3_color_new_arrivals',
            [
                'label' => __('Select color button', 'elementor-wps-bestsellers'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'ffffff' => 'white',
                    '000000' => 'black',
                    '795a78' => 'purple',
                    '276699' => 'blue',
                ],
                'default' => __('000000', 'elementor-wps-bestsellers'),
            ]
        );

        $this->add_control(
            'hr4_new_arrivals',
            [
                'type' => \Elementor\Controls_Manager::DIVIDER,
            ]
        );


        $this->add_control(
            'important_note_4_new_arrivals',
            [
                'type' => \Elementor\Controls_Manager::RAW_HTML,
                'raw' => __('Select the fourth product or variant', 'elementor-wps-bestsellers'),
            ]
        );

        $this->add_control(
            'id_product_4_new_arrivals',
            [
                'label' => __('Select product 4', 'elementor-wps-bestsellers'),
                'type' => Controls_Manager::SELECT,
                'options' => $optionProduct,
                'default' => __('Empty', 'elementor-wps-bestsellers'),
            ]
        );

        $this->add_control(
            'or_note_4_new_arrivals',
            [
                'type' => \Elementor\Controls_Manager::RAW_HTML,
                'raw' => __('OR', 'elementor-wps-bestsellers'),
            ]
        );

        $this->add_control(
            'id_variant_4_new_arrivals',
            [
                'label' => __('Select variant 4', 'elementor-wps-bestsellers'),
                'type' => Controls_Manager::SELECT,
                'options' => $optionProductVariant,
                'default' => __('Empty', 'elementor-wps-bestsellers'),
            ]
        );

        $this->add_control(
            'id_product_4_color_new_arrivals',
            [
                'label' => __('Select color button', 'elementor-wps-bestsellers'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'ffffff' => 'white',
                    '000000' => 'black',
                    '795a78' => 'purple',
                    '276699' => 'blue',
                ],
                'default' => __('000000', 'elementor-wps-bestsellers'),
            ]
        );

        $this->end_controls_section();


        /**
         * Clearance
         */

        $this->start_controls_section(
            'section_content_clearance',
            [
                'label' => __('Clearance', 'elementor-wps-bestsellers'),
            ]
        );

        $this->add_control(
            'important_note_1_0_clearance',
            [
                'type' => \Elementor\Controls_Manager::RAW_HTML,
                'raw' => __('Specify products to display on the Clearance tab', 'elementor-wps-bestsellers'),
            ]
        );

        $this->add_control(
            'hr0_clearance',
            [
                'type' => \Elementor\Controls_Manager::DIVIDER,
            ]
        );

        $this->add_control(
            'important_note_1_clearance',
            [
                'type' => \Elementor\Controls_Manager::RAW_HTML,
                'raw' => __('Select first product or variant', 'elementor-wps-bestsellers'),
            ]
        );

        $this->add_control(
            'id_product_1_clearance',
            [
                'label' => __('Select product 1', 'elementor-wps-bestsellers'),
                'type' => Controls_Manager::SELECT,
                'options' => $optionProduct,
                'default' => __('Empty', 'elementor-wps-bestsellers'),
            ]
        );

        $this->add_control(
            'or_note_1_clearance',
            [
                'type' => \Elementor\Controls_Manager::RAW_HTML,
                'raw' => __('OR', 'elementor-wps-bestsellers'),
            ]
        );

        $this->add_control(
            'id_variant_1_clearance',
            [
                'label' => __('Select variant 1', 'elementor-wps-bestsellers'),
                'type' => Controls_Manager::SELECT,
                'options' => $optionProductVariant,
                'default' => __('Empty', 'elementor-wps-bestsellers'),
            ]
        );

        $this->add_control(
            'id_product_1_color_clearance',
            [
                'label' => __('Select color button', 'elementor-wps-bestsellers'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'ffffff' => 'white',
                    '000000' => 'black',
                    '795a78' => 'purple',
                    '276699' => 'blue',
                ],
                'default' => __('000000', 'elementor-wps-bestsellers'),
            ]
        );

        $this->add_control(
            'hr2_clearance',
            [
                'type' => \Elementor\Controls_Manager::DIVIDER,
            ]
        );


        $this->add_control(
            'important_note_2_clearance',
            [
                'type' => \Elementor\Controls_Manager::RAW_HTML,
                'raw' => __('Select second product or variant', 'elementor-wps-bestsellers'),
            ]
        );

        $this->add_control(
            'id_product_2_clearance',
            [
                'label' => __('Select product 2', 'elementor-wps-bestsellers'),
                'type' => Controls_Manager::SELECT,
                'options' => $optionProduct,
                'default' => __('Empty', 'elementor-wps-bestsellers'),
            ]
        );

        $this->add_control(
            'or_note_2_clearance',
            [
                'type' => \Elementor\Controls_Manager::RAW_HTML,
                'raw' => __('OR', 'elementor-wps-bestsellers'),
            ]
        );

        $this->add_control(
            'id_variant_2_clearance',
            [
                'label' => __('Select variant 2', 'elementor-wps-bestsellers'),
                'type' => Controls_Manager::SELECT,
                'options' => $optionProductVariant,
                'default' => __('Empty', 'elementor-wps-bestsellers'),
            ]
        );

        $this->add_control(
            'id_product_2_color_clearance',
            [
                'label' => __('Select color button', 'elementor-wps-bestsellers'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'ffffff' => 'white',
                    '000000' => 'black',
                    '795a78' => 'purple',
                    '276699' => 'blue',
                ],
                'default' => __('000000', 'elementor-wps-bestsellers'),
            ]
        );

        $this->add_control(
            'hr3_clearance',
            [
                'type' => \Elementor\Controls_Manager::DIVIDER,
            ]
        );


        $this->add_control(
            'important_note_3_clearance',
            [
                'type' => \Elementor\Controls_Manager::RAW_HTML,
                'raw' => __('Select the third product or variant', 'elementor-wps-bestsellers'),
            ]
        );

        $this->add_control(
            'id_product_3_clearance',
            [
                'label' => __('Select product 3', 'elementor-wps-bestsellers'),
                'type' => Controls_Manager::SELECT,
                'options' => $optionProduct,
                'default' => __('Empty', 'elementor-wps-bestsellers'),
            ]
        );

        $this->add_control(
            'or_note_3_clearance',
            [
                'type' => \Elementor\Controls_Manager::RAW_HTML,
                'raw' => __('OR', 'elementor-wps-bestsellers'),
            ]
        );

        $this->add_control(
            'id_variant_3_clearance',
            [
                'label' => __('Select variant 3', 'elementor-wps-bestsellers'),
                'type' => Controls_Manager::SELECT,
                'options' => $optionProductVariant,
                'default' => __('Empty', 'elementor-wps-bestsellers'),
            ]
        );

        $this->add_control(
            'id_product_3_color_clearance',
            [
                'label' => __('Select color button', 'elementor-wps-bestsellers'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'ffffff' => 'white',
                    '000000' => 'black',
                    '795a78' => 'purple',
                    '276699' => 'blue',
                ],
                'default' => __('000000', 'elementor-wps-bestsellers'),
            ]
        );

        $this->add_control(
            'hr4_clearance',
            [
                'type' => \Elementor\Controls_Manager::DIVIDER,
            ]
        );


        $this->add_control(
            'important_note_4_clearance',
            [
                'type' => \Elementor\Controls_Manager::RAW_HTML,
                'raw' => __('Select the fourth product or variant', 'elementor-wps-bestsellers'),
            ]
        );

        $this->add_control(
            'id_product_4_clearance',
            [
                'label' => __('Select product 4', 'elementor-wps-bestsellers'),
                'type' => Controls_Manager::SELECT,
                'options' => $optionProduct,
                'default' => __('Empty', 'elementor-wps-bestsellers'),
            ]
        );

        $this->add_control(
            'or_note_4_clearance',
            [
                'type' => \Elementor\Controls_Manager::RAW_HTML,
                'raw' => __('OR', 'elementor-wps-bestsellers'),
            ]
        );

        $this->add_control(
            'id_variant_4_clearance',
            [
                'label' => __('Select variant 4', 'elementor-wps-bestsellers'),
                'type' => Controls_Manager::SELECT,
                'options' => $optionProductVariant,
                'default' => __('Empty', 'elementor-wps-bestsellers'),
            ]
        );

        $this->add_control(
            'id_product_4_color_clearance',
            [
                'label' => __('Select color button', 'elementor-wps-bestsellers'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'ffffff' => 'white',
                    '000000' => 'black',
                    '795a78' => 'purple',
                    '276699' => 'blue',
                ],
                'default' => __('000000', 'elementor-wps-bestsellers'),
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
        $idProduct_1 = (!empty($settings['id_product_1']) && $settings['id_product_1'] != 'Empty') ? $settings['id_product_1'] : $settings['id_variant_1'];
        $idProduct_2 = (!empty($settings['id_product_2']) && $settings['id_product_2'] != 'Empty') ? $settings['id_product_2'] : $settings['id_variant_2'];
        $idProduct_3 = (!empty($settings['id_product_3']) && $settings['id_product_3'] != 'Empty') ? $settings['id_product_3'] : $settings['id_variant_3'];
        $idProduct_4 = (!empty($settings['id_product_4']) && $settings['id_product_4'] != 'Empty') ? $settings['id_product_4'] : $settings['id_variant_4'];

        $product_1 = wc_get_product($idProduct_1);
        $product_2 = wc_get_product($idProduct_2);
        $product_3 = wc_get_product($idProduct_3);
        $product_4 = wc_get_product($idProduct_4);

        $productUrl1 = $product_1->get_permalink();
        $productUrl2 = $product_2->get_permalink();
        $productUrl3 = $product_3->get_permalink();
        $productUrl4 = $product_4->get_permalink();

        $imageUrl1 = wp_get_attachment_url($product_1->image_id);
        $imageUrl2 = wp_get_attachment_url($product_2->image_id);
        $imageUrl3 = wp_get_attachment_url($product_3->image_id);
        $imageUrl4 = wp_get_attachment_url($product_4->image_id);

        $priceProduct1 = (!empty($product_1->regular_price)) ? $product_1->regular_price : $product_1->price;
        $priceProduct2 = (!empty($product_2->regular_price)) ? $product_2->regular_price : $product_2->price;
        $priceProduct3 = (!empty($product_3->regular_price)) ? $product_3->regular_price : $product_3->price;
        $priceProduct4 = (!empty($product_4->regular_price)) ? $product_4->regular_price : $product_4->price;

        $percent1 = (!empty($product_1->sale_price)) ? ($priceProduct1 != 0) ? ceil($product_1->sale_price * 100 / $priceProduct1) : null : null;
        $percent2 = (!empty($product_2->sale_price)) ? ($priceProduct2 != 0) ? ceil($product_2->sale_price * 100 / $priceProduct2) : null : null;
        $percent3 = (!empty($product_3->sale_price)) ? ($priceProduct3 != 0) ? ceil($product_3->sale_price * 100 / $priceProduct3) : null : null;
        $percent4 = (!empty($product_4->sale_price)) ? ($priceProduct4 != 0) ? ceil($product_4->sale_price * 100 / $priceProduct4) : null : null;

        /**
         * New Arrivals data
         */
        $idProduct_1_new_arrivals = (!empty($settings['id_product_1_new_arrivals']) && $settings['id_product_1_new_arrivals'] != 'Empty') ? $settings['id_product_1_new_arrivals'] : $settings['id_variant_1_new_arrivals'];
        $idProduct_2_new_arrivals = (!empty($settings['id_product_2_new_arrivals']) && $settings['id_product_2_new_arrivals'] != 'Empty') ? $settings['id_product_2_new_arrivals'] : $settings['id_variant_2_new_arrivals'];
        $idProduct_3_new_arrivals = (!empty($settings['id_product_3_new_arrivals']) && $settings['id_product_3_new_arrivals'] != 'Empty') ? $settings['id_product_3_new_arrivals'] : $settings['id_variant_3_new_arrivals'];
        $idProduct_4_new_arrivals = (!empty($settings['id_product_4_new_arrivals']) && $settings['id_product_4_new_arrivals'] != 'Empty') ? $settings['id_product_4_new_arrivals'] : $settings['id_variant_4_new_arrivals'];

        $product_1_new_arrivals = wc_get_product($idProduct_1_new_arrivals);
        $product_2_new_arrivals = wc_get_product($idProduct_2_new_arrivals);
        $product_3_new_arrivals = wc_get_product($idProduct_3_new_arrivals);
        $product_4_new_arrivals = wc_get_product($idProduct_4_new_arrivals);

        $productUrl1_new_arrivals = $product_1_new_arrivals->get_permalink();
        $productUrl2_new_arrivals = $product_2_new_arrivals->get_permalink();
        $productUrl3_new_arrivals = $product_3_new_arrivals->get_permalink();
        $productUrl4_new_arrivals = $product_4_new_arrivals->get_permalink();

        $imageUrl1_new_arrivals = wp_get_attachment_url($product_1_new_arrivals->image_id);
        $imageUrl2_new_arrivals = wp_get_attachment_url($product_2_new_arrivals->image_id);
        $imageUrl3_new_arrivals = wp_get_attachment_url($product_3_new_arrivals->image_id);
        $imageUrl4_new_arrivals = wp_get_attachment_url($product_4_new_arrivals->image_id);

        $priceProduct1_new_arrivals = (!empty($product_1_new_arrivals->regular_price)) ? $product_1_new_arrivals->regular_price : $product_1_new_arrivals->price;
        $priceProduct2_new_arrivals = (!empty($product_2_new_arrivals->regular_price)) ? $product_2_new_arrivals->regular_price : $product_2_new_arrivals->price;
        $priceProduct3_new_arrivals = (!empty($product_3_new_arrivals->regular_price)) ? $product_3_new_arrivals->regular_price : $product_3_new_arrivals->price;
        $priceProduct4_new_arrivals = (!empty($product_4_new_arrivals->regular_price)) ? $product_4_new_arrivals->regular_price : $product_4_new_arrivals->price;

        $percent1_new_arrivals = (!empty($product_1_new_arrivals->sale_price)) ? ($priceProduct1_new_arrivals != 0) ? ceil($product_1_new_arrivals->sale_price * 100 / $priceProduct1_new_arrivals) : null : null;
        $percent2_new_arrivals = (!empty($product_2_new_arrivals->sale_price)) ? ($priceProduct2_new_arrivals != 0) ? ceil($product_2_new_arrivals->sale_price * 100 / $priceProduct2_new_arrivals) : null : null;
        $percent3_new_arrivals = (!empty($product_3_new_arrivals->sale_price)) ? ($priceProduct3_new_arrivals != 0) ? ceil($product_3_new_arrivals->sale_price * 100 / $priceProduct3_new_arrivals) : null : null;
        $percent4_new_arrivals = (!empty($product_4_new_arrivals->sale_price)) ? ($priceProduct4_new_arrivals != 0) ? ceil($product_4_new_arrivals->sale_price * 100 / $priceProduct4_new_arrivals) : null : null;

        /**
         * Clearance data
         */
        $idProduct_1_clearance = (!empty($settings['id_product_1_clearance']) && $settings['id_product_1_clearance'] != 'Empty') ? $settings['id_product_1_clearance'] : $settings['id_variant_1_clearance'];
        $idProduct_2_clearance = (!empty($settings['id_product_2_clearance']) && $settings['id_product_2_clearance'] != 'Empty') ? $settings['id_product_2_clearance'] : $settings['id_variant_2_clearance'];
        $idProduct_3_clearance = (!empty($settings['id_product_3_clearance']) && $settings['id_product_3_clearance'] != 'Empty') ? $settings['id_product_3_clearance'] : $settings['id_variant_3_clearance'];
        $idProduct_4_clearance = (!empty($settings['id_product_4_clearance']) && $settings['id_product_4_clearance'] != 'Empty') ? $settings['id_product_4_clearance'] : $settings['id_variant_4_clearance'];

        $product_1_clearance = wc_get_product($idProduct_1_clearance);
        $product_2_clearance = wc_get_product($idProduct_2_clearance);
        $product_3_clearance = wc_get_product($idProduct_3_clearance);
        $product_4_clearance = wc_get_product($idProduct_4_clearance);

        $productUrl1_clearance = $product_1_clearance->get_permalink();
        $productUrl2_clearance = $product_2_clearance->get_permalink();
        $productUrl3_clearance = $product_3_clearance->get_permalink();
        $productUrl4_clearance = $product_4_clearance->get_permalink();

        $imageUrl1_clearance = wp_get_attachment_url($product_1_clearance->image_id);
        $imageUrl2_clearance = wp_get_attachment_url($product_2_clearance->image_id);
        $imageUrl3_clearance = wp_get_attachment_url($product_3_clearance->image_id);
        $imageUrl4_clearance = wp_get_attachment_url($product_4_clearance->image_id);

        $priceProduct1_clearance = (!empty($product_1_clearance->regular_price)) ? $product_1_clearance->regular_price : $product_1_clearance->price;
        $priceProduct2_clearance = (!empty($product_2_clearance->regular_price)) ? $product_2_clearance->regular_price : $product_2_clearance->price;
        $priceProduct3_clearance = (!empty($product_3_clearance->regular_price)) ? $product_3_clearance->regular_price : $product_3_clearance->price;
        $priceProduct4_clearance = (!empty($product_4_clearance->regular_price)) ? $product_4_clearance->regular_price : $product_4_clearance->price;

        $percent1_clearance = (!empty($product_1_clearance->sale_price)) ? ($priceProduct1_clearance != 0) ? ceil($product_1_clearance->sale_price * 100 / $priceProduct1_clearance) : null : null;
        $percent2_clearance = (!empty($product_2_clearance->sale_price)) ? ($priceProduct2_clearance != 0) ? ceil($product_2_clearance->sale_price * 100 / $priceProduct2_clearance) : null : null;
        $percent3_clearance = (!empty($product_3_clearance->sale_price)) ? ($priceProduct3_clearance != 0) ? ceil($product_3_clearance->sale_price * 100 / $priceProduct3_clearance) : null : null;
        $percent4_clearance = (!empty($product_4_clearance->sale_price)) ? ($priceProduct4_clearance != 0) ? ceil($product_4_clearance->sale_price * 100 / $priceProduct4_clearance) : null : null;


        echo '<div id="wps-bestsellers">
    <h2>
        <a class="best-sellers selected">Best Sellers</a>
        <a class="new-arrivals">New Arrivals</a>
        <a class="clearance">Clearance</a>
    </h2>
    <section class="best-sellers" style="">
        <header>
            <h1><a href="/wps-bestsellers">Best Sellers</a></h1>
            <a class="more" href="/wps-bestsellers">More</a>
        </header>
        <div class="offers">
            <div class="offer dark" style="background-color:#ffffff;">
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
                            ' . $product_1->name . '
                        </a>
                    </h2>
                    <h3 style="background-color:#' . $settings['id_product_1_color'] . ';">
                        <a href="' . $productUrl1 . '">
                        <span class="list-price">
                            ' . $priceProduct1 . '
                        </span>
                            <span class="sale-price">' . $product_1->sale_price . '</span>
                            <span class="discount">save ' . $percent1 . '%</span>
                        </a>
                    </h3>
                </div>
            </div>

            <div class="offer dark"  style="background-color:#ffffff;">
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
                            ' . $product_2->name . '
                        </a>
                    </h2>
                    <h3 style="background-color:#' . $settings['id_product_2_color'] . ';">
                        <a href="' . $productUrl2 . '">
                        <span class="list-price">
                            ' . $priceProduct2 . '
                        </span>
                            <span class="sale-price">' . $product_2->sale_price . '</span>
                            <span class="discount">save ' . $percent2 . '%</span>
                        </a>
                    </h3>
                </div>
            </div>


            <div class="offer dark" style="background-color:#ffffff;">
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
                            ' . $product_3->name . '
                        </a>
                    </h2>
                    <h3 style="background-color:#' . $settings['id_product_3_color'] . ';">
                        <a href="' . $productUrl3 . '">
                        <span class="list-price">
                            ' . $priceProduct3 . '
                        </span>
                            <span class="sale-price">' . $product_3->sale_price . '</span>
                            <span class="discount">save ' . $percent3 . '%</span>
                        </a>
                    </h3>
                </div>
            </div>

            <div class="offer dark" style="background-color:#ffffff;">
               <div class="photo">
                    <a href="' . $productUrl4 . '">
                        <img data-src="' . $imageUrl4 . '"
                             height="181" width="181"
                             src="' . $imageUrl4 . '">
                    </a>
                </div>
                <div class="content">
                    <h2>
                        <a href="' . $productUrl4. '">
                            ' . $product_4->name . '
                        </a>
                    </h2>
                    <h3 style="background-color:#' . $settings['id_product_4_color'] . ';">
                        <a href="' . $productUrl4 . '">
                        <span class="list-price">
                            ' . $priceProduct4 . '
                        </span>
                            <span class="sale-price">' . $product_4->sale_price . '</span>
                            <span class="discount">save ' . $percent4 . '%</span>
                        </a>
                    </h3>
                </div>
            </div>
        </div>
    </section>
    
    <section class="new-arrivals" style="display: none;">
        <header>
            <h1><a href="/wps-bestsellers">Best Sellers</a></h1>
            <a class="more" href="/wps-bestsellers">More</a>
        </header>
        <div class="offers">
            <div class="offer dark" style="background-color:#ffffff;">
                <div class="photo">
                    <a href="' . $productUrl1_new_arrivals . '">
                        <img data-src="' . $imageUrl1_new_arrivals . '"
                             height="181" width="181"
                             src="' . $imageUrl1_new_arrivals . '">
                    </a>
                </div>
                <div class="content">
                    <h2>
                        <a href="' . $productUrl1_new_arrivals . '">
                            ' . $product_1_new_arrivals->name . '
                        </a>
                    </h2>
                    <h3 style="background-color:#' . $settings['id_product_1_color_new_arrivals'] . ';">
                        <a href="' . $productUrl1_new_arrivals . '">
                        <span class="list-price">
                            ' . $priceProduct1_new_arrivals . '
                        </span>
                            <span class="sale-price">' . $product_1_new_arrivals->sale_price . '</span>
                            <span class="discount">save ' . $percent1_new_arrivals . '%</span>
                        </a>
                    </h3>
                </div>
            </div>

            <div class="offer dark"  style="background-color:#ffffff;">
               <div class="photo">
                    <a href="' . $productUrl2_new_arrivals . '">
                        <img data-src="' . $imageUrl2_new_arrivals . '"
                             height="181" width="181"
                             src="' . $imageUrl2_new_arrivals . '">
                    </a>
                </div>
                <div class="content">
                    <h2>
                        <a href="' . $productUrl2_new_arrivals . '">
                            ' . $product_2_new_arrivals->name . '
                        </a>
                    </h2>
                    <h3 style="background-color:#' . $settings['id_product_2_color_new_arrivals'] . ';">
                        <a href="' . $productUrl2_new_arrivals . '">
                        <span class="list-price">
                            ' . $priceProduct2_new_arrivals . '
                        </span>
                            <span class="sale-price">' . $product_2_new_arrivals->sale_price . '</span>
                            <span class="discount">save ' . $percent2_new_arrivals . '%</span>
                        </a>
                    </h3>
                </div>
            </div>


            <div class="offer dark" style="background-color:#ffffff;">
               <div class="photo">
                    <a href="' . $productUrl3_new_arrivals . '">
                        <img data-src="' . $imageUrl3_new_arrivals . '"
                             height="181" width="181"
                             src="' . $imageUrl3_new_arrivals . '">
                    </a>
                </div>
                <div class="content">
                    <h2>
                        <a href="' . $productUrl3_new_arrivals . '">
                            ' . $product_3_new_arrivals->name . '
                        </a>
                    </h2>
                    <h3 style="background-color:#' . $settings['id_product_3_color_new_arrivals'] . ';">
                        <a href="' . $productUrl3_new_arrivals . '">
                        <span class="list-price">
                            ' . $priceProduct3_new_arrivals . '
                        </span>
                            <span class="sale-price">' . $product_3_new_arrivals->sale_price . '</span>
                            <span class="discount">save ' . $percent3_new_arrivals . '%</span>
                        </a>
                    </h3>
                </div>
            </div>

            <div class="offer dark" style="background-color:#ffffff;">
               <div class="photo">
                    <a href="/' . $productUrl4_new_arrivals . '">
                        <img data-src="' . $imageUrl4_new_arrivals . '"
                             height="181" width="181"
                             src="' . $imageUrl4_new_arrivals . '">
                    </a>
                </div>
                <div class="content">
                    <h2>
                        <a href="' . $productUrl4_new_arrivals . '">
                            ' . $product_4_new_arrivals->name . '
                        </a>
                    </h2>
                    <h3 style="background-color:#' . $settings['id_product_4_color_new_arrivals'] . ';">
                        <a href="' . $productUrl4_new_arrivals . '">
                        <span class="list-price">
                            ' . $priceProduct4_new_arrivals . '
                        </span>
                            <span class="sale-price">' . $product_4_new_arrivals->sale_price . '</span>
                            <span class="discount">save ' . $percent4_new_arrivals . '%</span>
                        </a>
                    </h3>
                </div>
            </div>
        </div>
    </section>
    
    <section class="clearance" style="display: none;">
        <header>
            <h1><a href="/wps-bestsellers">Best Sellers</a></h1>
            <a class="more" href="/wps-bestsellers">More</a>
        </header>
        <div class="offers">
            <div class="offer dark" style="background-color:#ffffff;">
                <div class="photo">
                    <a href="' . $productUrl1_clearance . '">
                        <img data-src="' . $imageUrl1_clearance . '"
                             height="181" width="181"
                             src="' . $imageUrl1_clearance . '">
                    </a>
                </div>
                <div class="content">
                    <h2>
                        <a href="' . $productUrl1_clearance . '">
                            ' . $product_1_clearance->name . '
                        </a>
                    </h2>
                    <h3 style="background-color:#' . $settings['id_product_1_color_clearance'] . ';">
                        <a href="' . $productUrl1_clearance . '">
                        <span class="list-price">
                            ' . $priceProduct1_clearance . '
                        </span>
                            <span class="sale-price">' . $product_1_clearance->sale_price . '</span>
                            <span class="discount">save ' . $percent1_clearance . '%</span>
                        </a>
                    </h3>
                </div>
            </div>

            <div class="offer dark"  style="background-color:#ffffff;">
               <div class="photo">
                    <a href="' . $productUrl2_clearance . '">
                        <img data-src="' . $imageUrl2_clearance . '"
                             height="181" width="181"
                             src="' . $imageUrl2_clearance . '">
                    </a>
                </div>
                <div class="content">
                    <h2>
                        <a href="' . $productUrl2_clearance . '">
                            ' . $product_2_clearance->name . '
                        </a>
                    </h2>
                    <h3 style="background-color:#' . $settings['id_product_2_color_clearance'] . ';">
                        <a href="' . $productUrl2_clearance . '">
                        <span class="list-price">
                            ' . $priceProduct2_clearance . '
                        </span>
                            <span class="sale-price">' . $product_2_clearance->sale_price . '</span>
                            <span class="discount">save ' . $percent2_clearance . '%</span>
                        </a>
                    </h3>
                </div>
            </div>


            <div class="offer dark" style="background-color:#ffffff;">
               <div class="photo">
                    <a href="' . $productUrl3_clearance . '">
                        <img data-src="' . $imageUrl3_clearance . '"
                             height="181" width="181"
                             src="' . $imageUrl3_clearance . '">
                    </a>
                </div>
                <div class="content">
                    <h2>
                        <a href="' . $productUrl3_clearance . '">
                            ' . $product_3_clearance->name . '
                        </a>
                    </h2>
                    <h3 style="background-color:#' . $settings['id_product_3_color_clearance'] . ';">
                        <a href="' . $productUrl3_clearance . '">
                        <span class="list-price">
                            ' . $priceProduct3_clearance . '
                        </span>
                            <span class="sale-price">' . $product_3_clearance->sale_price . '</span>
                            <span class="discount">save ' . $percent3_clearance . '%</span>
                        </a>
                    </h3>
                </div>
            </div>

            <div class="offer dark" style="background-color:#ffffff;">
               <div class="photo">
                    <a href="' . $productUrl4_clearance . '">
                        <img data-src="' . $imageUrl4_clearance . '"
                             height="181" width="181"
                             src="' . $imageUrl4_clearance . '">
                    </a>
                </div>
                <div class="content">
                    <h2>
                        <a href="' . $productUrl4_clearance . '">
                            ' . $product_4_clearance->name . '
                        </a>
                    </h2>
                    <h3 style="background-color:#' . $settings['id_product_4_color_clearance'] . ';">
                        <a href="' . $productUrl4_clearance . '">
                        <span class="list-price">
                            ' . $priceProduct4_clearance . '
                        </span>
                            <span class="sale-price">' . $product_4_clearance->sale_price . '</span>
                            <span class="discount">save ' . $percent4_clearance . '%</span>
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
