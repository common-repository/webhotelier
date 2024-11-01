<?php

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Wp_Webhotelier
 * @subpackage Wp_Webhotelier/public
 * @author     WPlugged <support@wplugged.com>
 */
class Wp_Webhotelier_Public
{
    /**
     * The ID of this plugin.
     *
     * @var string    $plugin_name    The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @var string    $version    The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @param string    $plugin_name       The name of the plugin.
     * @param string    $version    The version of this plugin.
     */
    public function __construct($plugin_name, $version)
    {
        $this->plugin_name = $plugin_name;
        $this->version     = $version;
    }

    /**
     * Register the stylesheets for the public-facing side of the site.
     */
    public function enqueue_styles()
    {
        wp_enqueue_style($this->plugin_name . '-flatpickr', plugin_dir_url(__FILE__) . 'css/flatpickr.min.css', [], $this->version, 'all');
        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/wp-webhotelier-public.css', [], $this->version, 'all');
        $wp_options = get_option($this->plugin_name . '_options');
        if (!empty($wp_options[$this->plugin_name . '-custom-css'])) {
            wp_add_inline_style($this->plugin_name, $wp_options[$this->plugin_name . '-custom-css']);
        }
    }

    /**
     * Register the JavaScript for the public-facing side of the site.
     */
    public function enqueue_scripts()
    {
        $wp_options = Wp_Webhotelier_Helper::getOptions();

        $calendar_date_format = $wp_options[$this->plugin_name . '-calendar-date-format'];
        if (!$calendar_date_format) {
            $calendar_date_format = 'F, J Y';
        }

        wp_enqueue_script($this->plugin_name . '-flatpickr', plugin_dir_url(__FILE__) . 'js/flatpickr.min.js', ['jquery'], $this->version, true);

        $current_locale = Wp_Webhotelier_Helper::getCurrentLang();
        if (strlen($current_locale) > 2) {
            $current_locale = strtolower(substr($current_locale, 0, 2));
        }

        if (file_exists(WP_PLUGIN_DIR . DIRECTORY_SEPARATOR . 'webhotelier' . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'js' . DIRECTORY_SEPARATOR . 'l10n' . DIRECTORY_SEPARATOR . $current_locale . '.js')) {
            wp_enqueue_script($this->plugin_name . '-flatpickr-' . $current_locale, plugin_dir_url(__FILE__) . 'js/l10n/' . $current_locale . '.js', [$this->plugin_name . '-flatpickr'], $this->version, true);
        }

        wp_register_script($this->plugin_name . '-public', plugin_dir_url(__FILE__) . 'js/wp-webhotelier-public.js', ['jquery', $this->plugin_name . '-flatpickr'], $this->version, true);

        wp_localize_script($this->plugin_name . '-public', 'wp_webhotelier_js_settings', [
            'calendar_date_format' => $calendar_date_format,
            'flatpickr_l10n'       => $current_locale
        ]);
        wp_enqueue_script($this->plugin_name . '-public');
    }
}
