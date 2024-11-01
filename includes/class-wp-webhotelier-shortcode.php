<?php

/**
 * The shortcodes functionality of the plugin.
 *
 * Defines the plugin name, version, and the shortcode.
 *
 * @package    Wp_Webhotelier
 * @subpackage Wp_Webhotelier/shortcode
 * @author     WPlugged <support@wplugged.com>
 */
class Wp_Webhotelier_Shortcode
{
    /**
     * The ID of this plugin.
     *
     * @var      string    $plugin_name    The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @var      string    $plugin_version
     */
    private $plugin_version;

    /**
     * Counter of how many times the shortcode has been shown
     *
     * @var integer
     */
    public static $shortcode_class_id = 0;

    /**
     * The ID html attribute for each shortcode rendered
     *
     * @var string
     */
    private $my_shortcode_id_num;

    public function __construct($plugin_name, $plugin_version)
    {
        $this->plugin_name    = $plugin_name;
        $this->plugin_version = $plugin_version;
        add_shortcode('wp-webhotelier', [$this, 'form_creation']);
    }

    /**
     * Returns the unique id for each instance of this class.
     * Mostly used to identify unique form elements.
     *
     * @return string
     */
    public function getId()
    {
        return 's-' . $this->my_shortcode_id_num;
    }

    /**
     * Outputs the HTML of the shortcode
     *
     * @return void
     */
    public function form_creation($atts = [], $content = null, $tag = 'wp-webhotelier')
    {
        $wp_options = Wp_Webhotelier_Helper::getOptions();

        // normalize attribute keys, lowercase
        $atts = array_change_key_case((array) $atts, CASE_LOWER);

        $default_client_options = [
            'url',
            'max-nights',
            'max-rooms',
            'max-adults',
            'max-children',
            'max-infants',
            'default-nights',
            'default-rooms',
            'default-adults',
            'default-children',
            'default-infants',
            'orientation',
            'checkout-date',
            'css-class',
            'days-after-checkin-allowed',
            'opening-closing-dates',
            'blank-target'
        ];

        $default_shortcode_atts = [];
        foreach ($default_client_options as $value) {
            $default_shortcode_atts[$value] = $wp_options[$this->plugin_name . '-' . $value];
        }

        // override default attributes with user attributes
        $wp_webhotelier_atts = shortcode_atts($default_shortcode_atts, $atts, $tag);

        if (is_array($wp_webhotelier_atts['opening-closing-dates'])) {
            $wp_webhotelier_atts['opening-date'] = (new DateTimeImmutable())->createFromFormat('d/m', $wp_webhotelier_atts['opening-closing-dates']['from'])->format('Y-m-d');
            $wp_webhotelier_atts['closing-date'] = (new DateTimeImmutable())->createFromFormat('d/m', $wp_webhotelier_atts['opening-closing-dates']['to'])->format('Y-m-d');
        }
        if (is_string($wp_webhotelier_atts['opening-closing-dates']) && strpos($wp_webhotelier_atts['opening-closing-dates'], ' to ') !== false) {
            $dates                               = explode(' to ', $wp_webhotelier_atts['opening-closing-dates']);
            $wp_webhotelier_atts['opening-date'] = $dates[0];
            $wp_webhotelier_atts['closing-date'] = $dates[1];
        }

        $wp_webhotelier_atts['default-date'] = Wp_Webhotelier_Helper::createDefaultDate($wp_webhotelier_atts['opening-date'], $wp_webhotelier_atts['closing-date'], $wp_webhotelier_atts['days-after-checkin-allowed']);

        //setting the id of the current view (and my_id for the page) of the loaded shortcode
        $this->my_shortcode_id_num = ++self::$shortcode_class_id;
        $my_id                     = $this->getId();

        ob_start();
        include plugin_dir_path(__FILE__) . '../public/partials/wp-webhotelier-form.php';
        return ob_get_clean();
    }
}
