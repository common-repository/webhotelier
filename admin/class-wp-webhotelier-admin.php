<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wp_Webhotelier
 * @subpackage Wp_Webhotelier/admin
 * @author     WPlugged <support@wplugged.com>
 */
class Wp_Webhotelier_Admin
{
    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $plugin_name    The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $version    The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string    $plugin_name       The name of this plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct($plugin_name, $version)
    {
        $this->plugin_name = $plugin_name;
        $this->version     = $version;
    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_styles()
    {
        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/wp-webhotelier-admin.css', [], $this->version, 'all');
    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts()
    {
        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/wp-webhotelier-admin.js', ['jquery'], $this->version, false);
        wp_localize_script($this->plugin_name, 'dismissible_notice', ['nonce' => wp_create_nonce('dismissible-notice')]);
    }

    /**
     * This function creates the plugin's options with the use of Codestar Framework.
     *
     * @return void
     */
    public function create_options()
    {
        if (!class_exists('CSF')) {
            return;
        }

        $config_options = Wp_Webhotelier_Helper::getOptionsConfig();

        // Set a unique slug-like ID
        $prefix = 'wp-webhotelier_options';

        // Create options
        CSF::createOptions($prefix, $config_options['framework-options']);

        // Create the config sections
        foreach ($config_options['sections'] as $section) {
            CSF::createSection($prefix, $section);
        }
    }

    /**
     * Adds the donation markup into the action
     *
     * @return void
     */
    public function add_donation_markup()
    {
        include __DIR__ . '/partials/wp-webhotelier-paypal-code.php';
    }

    /**
     * Adds a notice in the admin page informing the user of the purpose of the plugin
     *
     * @return void
     */
    public function add_notice_markup()
    {
        if (is_admin() &&
            isset($_GET['page']) &&
            sanitize_key($_GET['page']) == 'wp-webhotelier_options' &&
            $this->is_admin_notice_active('disable-done-notice-forever')) {
            include __DIR__ . '/partials/wp-webhotelier-notice-markup.php';
        }
    }

    /**
     * Handles Ajax request to persist notices dismissal.
     * Uses check_ajax_referer to verify nonce.
     */
    public function dismiss_admin_notice()
    {
        $option_name        = sanitize_text_field($_POST['option_name']);
        $dismissible_length = sanitize_text_field($_POST['dismissible_length']);
        if ('forever' != $dismissible_length) {
            $dismissible_length = (0 == absint($dismissible_length)) ? 1 : $dismissible_length;
            $dismissible_length = strtotime(absint($dismissible_length) . ' days');
        }
        check_ajax_referer('dismissible-notice', 'nonce');
        $this->set_admin_notice_cache($option_name, $dismissible_length);
        wp_die();
    }

    /**
     * Is admin notice active?
     *
     * @param string $arg data-dismissible content of notice.
     *
     * @return bool
     */
    public function is_admin_notice_active($arg)
    {
        $array = explode('-', $arg);
        array_pop($array);
        $option_name = implode('-', $array);
        $db_record   = $this->get_admin_notice_cache($option_name);
        if ('forever' == $db_record) {
            return false;
        } elseif (absint($db_record) >= time()) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * Returns admin notice cached timeout.
     *
     * @param string|bool $id admin notice name or false.
     *
     * @return array|bool The timeout. False if expired.
     */
    public function get_admin_notice_cache($id = false)
    {
        if (!$id) {
            return false;
        }
        $cache_key = $this->plugin_name . '-' . md5($id);
        $timeout   = get_site_option($cache_key);
        $timeout   = ('forever' === $timeout) ? time() + 60 : $timeout;
        if (empty($timeout) || time() > $timeout) {
            return false;
        }
        return $timeout;
    }

    /**
     * Sets admin notice timeout in site option.
     *
     * @param string      $id       Data Identifier.
     * @param string|bool $timeout  Timeout for admin notice.
     *
     * @return bool
     */
    public function set_admin_notice_cache($id, $timeout)
    {
        $cache_key = $this->plugin_name . '-' . md5($id);
        update_site_option($cache_key, $timeout);
        return true;
    }
}
