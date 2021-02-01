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
            $optionProduct[$product->get_id()] = $product->get_id(). ' - ' .$product->get_name();
        }

        foreach ($products as $productVariant) {
            if ($productVariant->is_type('variable')) {
                $variation_ids = $productVariant->get_visible_children();
                foreach ($variation_ids as $variation_id) {
                    $variation = wc_get_product($variation_id);
                    $optionProductVariant[$variation_id] = $variation->get_id(). ' - ' .$variation->get_name();
                }
            }
        }


        $this->start_controls_section(
            'section_content',
            [
                'label' => __('Product', 'elementor-wps'),
            ]
        );

        $this->add_control(
            'important_note',
            [
                'type' => \Elementor\Controls_Manager::RAW_HTML,
                'raw' => __('You can select either product only or product variant only. If you have selected a product, in the product variant select Empty. Or the other way around. If the product has variants, then you need to choose a product variant!', 'elementor-wps'),
            ]
        );

        $this->add_control(
            'id_product',
            [
                'label' => __('Select product', 'elementor-wps'),
                'type' => Controls_Manager::SELECT,
                'options' => $optionProduct,
                'default' => __('Empty', 'elementor-wps'),
            ]
        );

        $this->add_control(
            'or_note',
            [
                'type' => \Elementor\Controls_Manager::RAW_HTML,
                'raw' => __('OR', 'elementor-wps'),
            ]
        );

        $this->add_control(
            'id_variant',
            [
                'label' => __('Select variant', 'elementor-wps'),
                'type' => Controls_Manager::SELECT,
                'options' => $optionProductVariant,
                'default' => __('Empty', 'elementor-wps'),
            ]
        );

        $this->add_control(
            'hr',
            [
                'type' => \Elementor\Controls_Manager::DIVIDER,
            ]
        );


        $this->add_control(
            'important_note_id_container_hide',
            [
                'type' => \Elementor\Controls_Manager::RAW_HTML,
                'raw' => __('Select the product to come after. Enter the product of the next deal', 'elementor-wps'),
            ]
        );

        $this->add_control(
            'id_product_next',
            [
                'label' => __('Select product', 'elementor-wps'),
                'type' => Controls_Manager::SELECT,
                'options' => $optionProduct,
                'default' => __('Empty', 'elementor-wps'),
            ]
        );

        $this->add_control(
            'or_note_next',
            [
                'type' => \Elementor\Controls_Manager::RAW_HTML,
                'raw' => __('OR', 'elementor-wps'),
            ]
        );

        $this->add_control(
            'id_variant_next',
            [
                'label' => __('Select variant', 'elementor-wps'),
                'type' => Controls_Manager::SELECT,
                'options' => $optionProductVariant,
                'default' => __('Empty', 'elementor-wps'),
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
        $idProduct = (!empty($settings['id_product']) && $settings['id_product']!='Empty') ? $settings['id_product'] : $settings['id_variant'];
        $product = wc_get_product($idProduct);
        $idProductNext = (!empty($settings['id_product_next']) && $settings['id_product_next']!='Empty') ? $settings['id_product_next'] : $settings['id_variant_next'];
        $productNext = wc_get_product($idProductNext);

        echo '<script>        
        jQuery(function(){
            let ts = new Date("' . $product->get_date_on_sale_to() . '");	
            let now = new Date();	
            let stock = "' . $product->get_stock_status() . '"; 
            let quantity = "' . $product->get_stock_quantity() . '"; 
            let countdown = jQuery(\'#countdown' . $idProduct . '\');   
            let a = "' . is_admin() . '";
            	if((now < ts) && (stock === "instock" || quantity > 0)){
                    countdown.countdown({
                        timestamp	: ts
                    });	
	            }else{     
            	   if(a!=1){
            	       let overlay = countdown.closest(".elementor-section").children(".elementor-background-overlay");
            	        overlay.addClass("overlay-wps");
            	        overlay.append( "<div class=\'sold-or-expired\'>Sold or Expired<br>Next Sale Starts</div>" );
            	   }
	            }
        });
        </script>';
        echo '<div id="countdown' . $idProduct . '"></div>';    

if(date("Y-m-d H:i:s")>$product->get_date_on_sale_to() ||  $product->get_stock_status() != "instock" || $product->get_stock_quantity() < 1) {
    echo '<script>
        jQuery(function(){
            let ts = new Date("' . $productNext->get_date_on_sale_from() . '");
            let now = new Date();
            let stock = "' . $productNext->get_stock_status() . '";
            let countdown = jQuery(\'#countdown' . $idProductNext . '\');
            let a = "' . is_admin() . '";
            	if(now < ts && stock === "instock"){
                    countdown.countdown({
                        timestamp	: ts
                    });
	            }
        });
        </script>';
    echo '<div id="countdown' . $idProductNext . '" style="z-index: 999; position: relative;"></div>';
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
