<?php
/**
 * Adds Wp_Webhotelier_Widget widget.
 *
 * @package    Wp_Webhotelier
 * @subpackage Wp_Webhotelier/shortcode
 * @author     WPlugged <support@wplugged.com>
 */
class Wp_Webhotelier_Widget extends WP_Widget
{
    /**
     * Counter of how many times the shortcode has been shown
     *
     * @var integer
     */
    public static $widget_class_id = 0;

    /**
     * The ID html attribute for each shortcode rendered
     *
     * @var string
     */
    private $my_widget_id_num;

    /**
     * The prefix for the widget options
     *
     * @var string
     */
    private $prefix_options = 'wp-webhotelier-';

    /**
     * Register widget with WordPress.
     */
    public function __construct()
    {
        parent::__construct(
            'wp_webhotelier_widget',                                                                                // Base ID
            esc_html__('Webhotelier Widget Form', 'wp_webhotelier'),                                                // Name
            ['description' => esc_html__('Display a Webhotelier Availability Form as a widget', 'wp_webhotelier')]  // Args
        );
    }

    /**
     * Returns the unique id for each instance of this class.
     * Mostly used to identify unique form elements.
     *
     * @return string
     */
    public function getId()
    {
        return 'w-' . $this->my_widget_id_num;
    }

    /**
     * Returns the plugin's default options which have
     * been set in the plugin's admin area
     *
     * @return array
     */
    private function getDefaultOptions()
    {
        $wp_options = Wp_Webhotelier_Helper::getOptions();

        $default_options = [
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
            'checkout-date',
            'orientation',
            'css-class',
            'days-after-checkin-allowed',
            'opening-closing-dates',
            'blank-target'
        ];

        $default_atts = [];
        foreach ($default_options as $value) {
            $default_atts[$value] = $wp_options[$this->prefix_options . $value];
        }

        $default_atts['opening-date'] = (new DateTimeImmutable())->createFromFormat('d/m', $default_atts['opening-closing-dates']['from'])->format('Y-m-d');
        $default_atts['closing-date'] = (new DateTimeImmutable())->createFromFormat('d/m', $default_atts['opening-closing-dates']['to'])->format('Y-m-d');

        unset($default_atts['opening-closing-dates']);
        
        return $default_atts;
    }

    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget($args, $instance)
    {
        // Setting the id of the current view (and my_id for the page) of the loaded widget
        $this->my_widget_id_num = ++self::$widget_class_id;
        $my_id                  = $this->getId();

        $title = !empty($instance['title']) ? $instance['title'] : '';

        // This filter is documented in wp-includes/widgets/class-wp-widget-pages.php
        $title = apply_filters('widget_title', $title, $instance, $this->id_base);

        echo $args['before_widget'];
        if ($title) {
            echo $args['before_title'] . $title . $args['after_title'];
        }

        $wp_webhotelier_atts                 = wp_parse_args($instance, $this->getDefaultOptions());
        $wp_webhotelier_atts['default-date'] = Wp_Webhotelier_Helper::createDefaultDate($wp_webhotelier_atts['opening-date'], $wp_webhotelier_atts['closing-date'], $wp_webhotelier_atts['days-after-checkin-allowed']);
        require plugin_dir_path(__FILE__) . '../public/partials/wp-webhotelier-form.php';
        echo $args['after_widget'];
    }

    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param array $instance Previously saved values from database.
     */
    public function form($instance)
    {
        $instance                  = array_filter($instance, 'strlen');
        $instance                  = wp_parse_args($instance, array_merge($this->getDefaultOptions(), ['title' => '']));
        $opening_date              = explode('-', $instance['opening-date']);
        $closing_date              = explode('-', $instance['closing-date']);
        $instance['opening-day']   = $opening_date[2];
        $instance['opening-month'] = $opening_date[1];
        $instance['closing-day']   = $closing_date[2];
        $instance['closing-month'] = $closing_date[1];
        require plugin_dir_path(__FILE__) . '../admin/partials/wp-webhotelier-widget-backend-form.php';
    }

    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param array $new_instance Values just sent to be saved.
     * @param array $old_instance Previously saved values from database.
     *
     * @return array Updated safe values to be saved.
     */
    public function update($new_instance, $old_instance)
    {
        if (!empty($new_instance['title'])) {
            $new_instance['title']        = sanitize_text_field($new_instance['title']);
        }
        $new_instance                 = array_filter($new_instance, 'strlen');
        $new_instance['opening-date'] = current_time('Y') . '-' . str_pad($new_instance['opening-month'], 2, 0, STR_PAD_LEFT)  . '-' . str_pad($new_instance['opening-day'], 2, 0, STR_PAD_LEFT);
        $new_instance['closing-date'] = current_time('Y') . '-' . str_pad($new_instance['closing-month'], 2, 0, STR_PAD_LEFT)  . '-' . str_pad($new_instance['closing-day'], 2, 0, STR_PAD_LEFT);
        return $new_instance;
    }
}
