<?php
/**
 * Helper class.
 *
 * @package    Wp_Webhotelier
 * @author     WPlugged <support@wplugged.com>
 */

class Wp_Webhotelier_Helper
{
    /**
     * Returns the next available date for check in in format 'Y-m-d'
     *
     * @param string $opening_date
     * @param string $closing_date
     * @param string $days_after_checkin
     * @return string
     */
    public static function createDefaultDate($opening_date, $closing_date, $days_after_checkin = 0)
    {
        if (!$opening_date || !$closing_date) {
            return (new DateTime())->add(new DateInterval('P1D'))->format('Y-m-d');
        }

        $opening_date = DateTime::createFromFormat('Y-m-d', $opening_date);
        $opening_date->setDate(current_time('Y'), $opening_date->format('m'), $opening_date->format('d'));

        $closing_date = DateTime::createFromFormat('Y-m-d', $closing_date);
        $closing_date->setDate(current_time('Y'), $closing_date->format('m'), $closing_date->format('d'));

        $current_date_plus_interval = (new DateTime())->add(new DateInterval('P' . $days_after_checkin . 'D'));

        if ($closing_date < $opening_date) {
            $closing_date->add(new DateInterval('P1Y'));
        }
        if ($current_date_plus_interval <= $opening_date) {
            return $opening_date->format('Y-m-d');
        }
        if ($current_date_plus_interval <= $closing_date) {
            return $current_date_plus_interval->format('Y-m-d');
        }
        if ($current_date_plus_interval > $closing_date) {
            $opening_date->add(new DateInterval('P1Y'));
            return $opening_date->format('Y-m-d');
        }
    }

    public static function getCurrentLang()
    {
        $locale = get_locale();

        // support Polylang
        if (function_exists('pll_current_language')) {
            $locale = pll_current_language();
        }

        // support WPML
        if (defined('ICL_LANGUAGE_CODE')) {
            $locale = ICL_LANGUAGE_CODE;
        }

        return $locale;
    }

    public static function getOptions()
    {
        $wp_options = get_option('wp-webhotelier_options');

        $config_options = self::getOptionsConfig();

        foreach ($config_options['sections'] as $section) {
            foreach ($section['fields'] as $field) {
                if (isset($wp_options[$field['id']])) {
                    continue;
                }
                if (isset($field['default'])) {
                    $wp_options[$field['id']] = $field['default'];
                }
            }
        }

        return $wp_options;
    }

    public static function getOptionsConfig()
    {
        $prefix = 'wp-webhotelier_options';

        return [
            'framework-options' => [
                'menu_title'      => 'WebHotelier' . ' ' . __('Options', 'wp-webhotelier'),
                'menu_slug'       => $prefix,
                'show_bar_menu'   => false,
                'framework_title' => 'WebHotelier Options <small>by WPlugged.com</small>',
                'footer_credit'   => ' '
            ],
            'sections' => [
                [
                    'id'      => 'webhotelier_form_fields_settings',
                    'title'   => __('Form Fields Settings', 'wp-webhotelier'),
                    'fields'  => [
                        [
                            'title'       => __('WebHotelier URL', 'wp-webhotelier'),
                            'id'          => 'wp-webhotelier-url',
                            'type'        => 'text',
                            'desc'        => __('This is the URL of the hotel\'s reservation page', 'wp-webhotelier'),
                            'placeholder' => 'https://example.reserve-online-net'
                        ],
                        [
                            'title'    => __('Max Nights', 'wp-webhotelier'),
                            'id'       => 'wp-webhotelier-max-nights',
                            'type'     => 'number',
                            'desc'     => __('The maximum number of nights one can choose to make a reservation', 'wp-webhotelier'),
                            'default'  => '7',
                        ],
                        [
                            'title'    => __('Max Rooms', 'wp-webhotelier'),
                            'id'       => 'wp-webhotelier-max-rooms',
                            'type'     => 'number',
                            'desc'     => __('The maximum number of rooms one can choose to make a reservation', 'wp-webhotelier'),
                            'default'  => '5',
                        ],
                        [
                            'title'    => __('Max Adults', 'wp-webhotelier'),
                            'id'       => 'wp-webhotelier-max-adults',
                            'type'     => 'number',
                            'desc'     => __('The maximum number of adults one can choose to make a reservation', 'wp-webhotelier'),
                            'default'  => '10',
                        ],
                        [
                            'title'    => __('Max Children', 'wp-webhotelier'),
                            'id'       => 'wp-webhotelier-max-children',
                            'type'     => 'number',
                            'desc'     => __('The maximum number of children one can choose to make a reservation', 'wp-webhotelier'),
                            'default'  => '10',
                        ],
                        [
                            'title'    => __('Max Infants', 'wp-webhotelier'),
                            'id'       => 'wp-webhotelier-max-infants',
                            'type'     => 'number',
                            'desc'     => __('The maximum number of infants one can choose to make a reservation', 'wp-webhotelier'),
                            'default'  => '10',
                        ],
                        [
                            'title'    => __('Default Nights', 'wp-webhotelier'),
                            'id'       => 'wp-webhotelier-default-nights',
                            'type'     => 'number',
                            'default'  => '2',
                        ],
                        [
                            'title'    => __('Default Rooms', 'wp-webhotelier'),
                            'id'       => 'wp-webhotelier-default-rooms',
                            'type'     => 'number',
                            'default'  => '1',
                        ],
                        [
                            'title'    => __('Default Adults', 'wp-webhotelier'),
                            'id'       => 'wp-webhotelier-default-adults',
                            'type'     => 'number',
                            'default'  => '2',
                        ],
                        [
                            'title'    => __('Default Children', 'wp-webhotelier'),
                            'id'       => 'wp-webhotelier-default-children',
                            'type'     => 'number',
                            'default'  => '0',
                        ],
                        [
                            'title'    => __('Default Infants', 'wp-webhotelier'),
                            'id'       => 'wp-webhotelier-default-infants',
                            'type'     => 'number',
                            'default'  => '0',
                        ],
                        [
                            'title'    => __('Days from today that Check-in is allowed', 'wp-webhotelier'),
                            'id'       => 'wp-webhotelier-days-after-checkin-allowed',
                            'type'     => 'number',
                            'desc'     => __('The number of days from current day that check-in is allowed', 'wp-webhotelier'),
                            'default'  => '1',
                        ],
                        [
                            'title'             => __('Opening and Closing Dates', 'wp-webhotelier'),
                            'id'                => 'wp-webhotelier-opening-closing-dates',
                            'type'              => 'date',
                            'desc'              => __('The day and the month for the Opening and Closing Dates of the hotel respectively', 'wp-webhotelier'),
                            'from_to'           => true,
                            'settings'          => [
                                'dateFormat' => 'dd/mm',
                                'showWeek'   => false,
                            ],
                            'default' => [
                                'from' => '01/05',
                                'to'   => '30/10'
                            ]
                        ],
                    ]
                ],
                [
                    'id'      => 'webhotelier_form_customization_settings',
                    'title'   => __('Form Customization Settings', 'wp-webhotelier'),
                    'fields'  => [
                        [
                            'title'    => __('Orientation', 'wp-webhotelier'),
                            'id'       => 'wp-webhotelier-orientation',
                            'type'     => 'radio',
                            'options'  => [
                                'vertical'   => __('Vertical', 'wp-webhotelier'),
                                'horizontal' => __('Horizontal', 'wp-webhotelier'),
                                'fluid'      => __('Fluid', 'wp-webhotelier')
                            ],
                            'desc'    => __('Select the layout orientation', 'wp-webhotelier'),
                            'default' => 'horizontal'
                        ],
                        [
                            'title'    => __('Replace Nights with Checkout Date', 'wp-webhotelier'),
                            'id'       => 'wp-webhotelier-checkout-date',
                            'type'     => 'checkbox',
                            'default'  => false
                        ],
                        [
                            'title'        => __('Open WebHotelier in new tab', 'wp-webhotelier'),
                            'id'           => 'wp-webhotelier-blank-target',
                            'type'         => 'checkbox',
                            'default'      => true
                        ],
                        [
                            'title'    => __('Calendar Date Format', 'wp-webhotelier'),
                            'id'       => 'wp-webhotelier-calendar-date-format',
                            'type'     => 'text',
                            'desc'     => __('Using PHP\'s date format strings, customize the calendar\'s date format however you want', 'wp-webhotelier'),
                            'default'  => 'F, J Y'
                        ],
                        [
                            'title'        => __('Custom CSS Class', 'wp-webhotelier'),
                            'id'           => 'wp-webhotelier-css-class',
                            'type'         => 'text',
                            'desc'         => __('Add your custom CSS Class which will be assigned to the form element', 'wp-webhotelier'),
                            'placeholder'  => 'my-custom-css-class',
                            'default'      => ''
                        ],
                        [
                            'title'    => __('Custom CSS', 'wp-webhotelier'),
                            'id'       => 'wp-webhotelier-custom-css',
                            'type'     => 'code_editor',
                            'desc'     => __('Put your Custom CSS rules here. Useful when you have added a Custom CSS Class previously', 'wp-webhotelier'),
                            'settings' => [
                                'mode'  => 'css',
                                'theme' => 'monokai'
                            ]
                        ],
                    ]
                ]
            ]
        ];
    }
}
