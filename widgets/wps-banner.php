<?php

namespace Elementor\Wps\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;


if (!defined('ABSPATH')) exit; // Exit if accessed directly

/**
 * @since 1.1.0
 */
class Wps_Banner extends \Elementor\Widget_Base
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
        return 'wps-banner';
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
        return __('Wps Banners', 'elementor-wps-banner');
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
     * Note that currently Elementor supports only one banner.
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
         * Banner
         */

        $this->start_controls_section(
            'section_content',
            [
                'label' => __('Banner with photo & video', 'elementor-wps-banner'),
            ]
        );

        $this->add_control(
            'banner_title',
            [
                'label' => __( 'Title', 'elementor-wps-banner' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __( 'Default title', 'elementor-wps-banner' ),
                'placeholder' => __( 'Banner title', 'elementor-wps-banner' ),
            ]
        );

        $this->add_control(
            'important_note',
            [
                'type' => \Elementor\Controls_Manager::RAW_HTML,
                'raw' => __('Select Photo. Only the first selected will be displayed.', 'elementor-wps-banner'),
            ]
        );

        $this->add_control(
            'gallery',
            [
                'label' => __( 'Add Images', 'plugin-domain' ),
                'type' => \Elementor\Controls_Manager::GALLERY,
                'default' => [],
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
                'raw' => __('Select Video', 'elementor-wps-banner'),
            ]
        );

        $this->add_control(
            'video',
            [
                'label' => __('Embed iframe from youtube', 'elementor-wps-banner'),
                'type' => Controls_Manager::TEXTAREA,
                'rows' => 10,
                'default' => __('Empty', 'elementor-wps-banner'),
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
         * Banner data
         */
       $gallery =  (!empty($settings['gallery'])) ? $settings['gallery'] : null;
       $video =  (!empty($settings['video'])) ? $settings['video'] : null;
       $title =  (!empty($settings['banner_title'])) ? $settings['banner_title'] : null;
       $pictWidth = ($video=== null) ? 'style="width:100%"' : '' ;

        foreach ( $gallery as $key=>$image ) {
            if($key ==0) {
                $pict =  '<img src="' . $image['url'] . '" '.$pictWidth.'>';
            }
        }


        echo '<div id="wps-content-banner"><h3>' . $title . '</h3><div class="cobranding wendyshow-com">';

        if($video!==null) {
            echo '
            <div class="youtube">
                ' . $video . '
            </div>';
        }

        if($gallery!==null) {
            echo '
            <div class="logo" '.$pictWidth.'>
                <a href="http://wendyshow.com" target="_blank">
                    ' . $pict . '
                </a>
            </div>';
        }

        echo '</div></div>';

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
