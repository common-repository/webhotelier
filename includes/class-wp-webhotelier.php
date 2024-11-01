<?php
/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @package    Wp_Webhotelier
 * @subpackage Wp_Webhotelier/includes
 * @author     WPlugged <support@wplugged.com>
 */
class Wp_Webhotelier
{
    /**
     * The loader that's responsible for maintaining and registering all hooks that power
     * the plugin.
     *
     * @var Wp_Webhotelier_Loader    $loader    Maintains and registers all hooks for the plugin.
     */
    protected $loader;

    /**
     * The unique identifier of this plugin.
     *
     * @var string
     */
    protected $plugin_name;

    /**
     * The current version of the plugin.
     *
     * @var string
     */
    protected $version;

    /**
     * Define the core functionality of the plugin.
     *
     * Set the plugin name and the plugin version that can be used throughout the plugin.
     * Load the dependencies, define the locale, and set the hooks for the admin area and
     * the public-facing side of the site.
     *
     */
    public function __construct()
    {
        $this->version     = WP_WEBHOTELIER_VERSION;
        $this->plugin_name = 'wp-webhotelier';

        $this->load_dependencies();
        $this->set_locale();
        $this->define_admin_hooks();
        $this->define_public_hooks();
        $this->define_shortcodes();
        $this->define_widgets();
        
        Wp_Webhotelier_Activator::activate();
    }

    /**
     * Load the required dependencies for this plugin.
     *
     * Create an instance of the loader which will be used to register the hooks
     * with WordPress.
     */
    private function load_dependencies()
    {
        /**
         * The file responsible for doing all activation logic before everything else
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-wp-webhotelier-activator.php';

        /**
         * The file responsible for including the Codestar Framework
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/codestar-framework/codestar-framework.php';

        /**
         * The helper class.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-wp-webhotelier-helper.php';

        /**
         * The class responsible for orchestrating the actions and filters of the
         * core plugin.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-wp-webhotelier-loader.php';

        /**
         * The class responsible for defining internationalization functionality
         * of the plugin.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-wp-webhotelier-i18n.php';

        /**
         * The class responsible for defining all actions that occur in the admin area.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-wp-webhotelier-admin.php';

        /**
         * The class responsible for defining all actions that occur in the public-facing
         * side of the site.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'public/class-wp-webhotelier-public.php';

        /**
         * The class responsible for adding the shortcode.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-wp-webhotelier-shortcode.php';

        /**
         * The class responsible for adding the widget.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-wp-webhotelier-widget.php';

        /**
         * The class responsible for adding the Gutenberg block.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'block/wp-webhotelier-block.php';

        $this->loader = new Wp_Webhotelier_Loader();
    }

    /**
     * Define the locale for this plugin for internationalization.
     *
     * Uses the Wp_Webhotelier_i18n class in order to set the domain and to register the hook
     * with WordPress.
     */
    private function set_locale()
    {
        $plugin_i18n = new Wp_Webhotelier_i18n();

        $this->loader->add_action('plugins_loaded', $plugin_i18n, 'load_plugin_textdomain');
    }

    /**
     * Register all of the hooks related to the admin area functionality
     * of the plugin.
     */
    private function define_admin_hooks()
    {
        global $pagenow;

        $plugin_admin = new Wp_Webhotelier_Admin($this->get_plugin_name(), $this->get_version());
        $plugin_admin->create_options();

        $this->loader->add_action('wp_ajax_dismiss_admin_notice_wp-webhotelier', $plugin_admin, 'dismiss_admin_notice');

        if (isset($_GET['page']) && sanitize_key($_GET['page']) == 'wp-webhotelier_options') {
            $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_styles');
            $this->loader->add_filter('csf_options_after', $plugin_admin, 'add_donation_markup');
            $this->loader->add_filter('csf_options_before', $plugin_admin, 'add_notice_markup');
        }

        if ((isset($_GET['page']) && sanitize_key($_GET['page']) == 'wp-webhotelier_options') || $pagenow == 'widgets.php') {
            $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts');
        }
    }

    /**
     * Register all of the hooks related to the public-facing functionality
     * of the plugin.
     */
    private function define_public_hooks()
    {
        $plugin_public = new Wp_Webhotelier_Public($this->get_plugin_name(), $this->get_version());
        $this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_styles');
        $this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_scripts');   
    }

    /**
     * Register shortcodes
     *
     * @return void
     */
    private function define_shortcodes()
    {
        $shortcode = new Wp_Webhotelier_Shortcode($this->get_plugin_name(), $this->get_version());
    }

    /**
     * Register widgets
     *
     * @return void
     */
    private function define_widgets()
    {
        add_action('widgets_init', function () {
            register_widget('Wp_Webhotelier_Widget');
        });
    }

    /**
     * Run the loader to execute all of the hooks with WordPress.
     */
    public function run()
    {
        $this->loader->run();
    }

    /**
     * The name of the plugin used to uniquely identify it within the context of
     * WordPress and to define internationalization functionality.
     *
     * @return    string    The name of the plugin.
     */
    public function get_plugin_name()
    {
        return $this->plugin_name;
    }

    /**
     * The reference to the class that orchestrates the hooks with the plugin.
     *
     * @return    Wp_Webhotelier_Loader    Orchestrates the hooks of the plugin.
     */
    public function get_loader()
    {
        return $this->loader;
    }

    /**
     * Retrieve the version number of the plugin.
     *
     * @return    string    The version number of the plugin.
     */
    public function get_version()
    {
        return $this->version;
    }
}
