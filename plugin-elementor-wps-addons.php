<?php

namespace Elementor\Wps;

/**
 * Class Plugin Elementor_Wps_Addons
 *
 * Main Plugin class
 * @since 1.0.0
 */
class Plugin_Elementor_Wps_Addons
{

    /**
     * Instance
     *
     * @since 1.0.0
     * @access private
     * @static
     *
     * @var Plugin_Elementor_Wps_Addons The single instance of the class.
     */
    private static $_instance = null;

    /**
     * Instance
     *
     * Ensures only one instance of the class is loaded or can be loaded.
     *
     * @return Plugin_Elementor_Wps_Addons An instance of the class.
     * @since 1.2.0
     * @access public
     *
     */
    public static function instance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    /**
     * widget_scripts
     *
     * Load required plugin core files.
     *
     * @since 1.2.0
     * @access public
     */
    public function widget_scripts()
    {
        wp_register_script('elementor-wps-addons', plugins_url('/assets/js/wps-addons.js', __FILE__), ['jquery'], false, true);
        wp_register_style('elementor-wps-addons', plugins_url('/assets/css/wps-addons.css', __FILE__), [], '1.0.0');
    }

    /**
     * Include Widgets files
     *
     * Load widgets files
     *
     * @since 1.2.0
     * @access private
     */
    private function include_widgets_files()
    {

        require_once(__DIR__ . '/widgets/wps-banner.php');
        require_once(__DIR__ . '/widgets/wps-bestsellers.php');
        require_once(__DIR__ . '/widgets/wps-counter.php');
        require_once(__DIR__ . '/widgets/wps-featured-deals.php');

    }

    /**
     * Register Widgets
     *
     * Register new Elementor widgets.
     *
     * @since 1.2.0
     * @access public
     */
    public function register_widgets()
    {
        // Its is now safe to include Widgets files
        $this->include_widgets_files();

        // Register Widgets
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\Wps_Banner());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\Wps_Bestsellers());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\Wps_Counter());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\Wps_Featured_Deals());
    }

    /**
     *  Plugin class constructor
     *
     * Register plugin action hooks and filters
     *
     * @since 1.2.0
     * @access public
     */
    public function __construct()
    {

        // Register widget scripts
        add_action('elementor/frontend/after_register_scripts', [$this, 'widget_scripts']);

        // Register widgets
        add_action('elementor/widgets/widgets_registered', [$this, 'register_widgets']);
    }
}

// Instantiate Plugin Class
Plugin_Elementor_Wps_Addons::instance();
