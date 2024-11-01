<?php
/**
 * Functions to register client-side assets (scripts and stylesheets) for the
 * Gutenberg block.
 *
 * @package webhotelier
 */
function wp_webhotelier_register_block()
{
    $wp_options = Wp_Webhotelier_Helper::getOptions();

    $prefix_options = 'wp-webhotelier-';

    $opening_date = (new DateTime())->createFromFormat('d/m', $wp_options[$prefix_options . 'opening-closing-dates']['from']);
    $closing_date = (new DateTime())->createFromFormat('d/m', $wp_options[$prefix_options . 'opening-closing-dates']['to']);

    register_block_type(__DIR__ . '/build', [
        'attributes'      => [
            'url'                        => ['type' => 'string', 'default' => $wp_options[$prefix_options . 'url']],
            'max-nights'                 => ['type' => 'number', 'default' => $wp_options[$prefix_options . 'max-nights']],
            'max-rooms'                  => ['type' => 'number', 'default' => $wp_options[$prefix_options . 'max-rooms']],
            'max-adults'                 => ['type' => 'number', 'default' => $wp_options[$prefix_options . 'max-adults']],
            'max-children'               => ['type' => 'number', 'default' => $wp_options[$prefix_options . 'max-children']],
            'max-infants'                => ['type' => 'number', 'default' => $wp_options[$prefix_options . 'max-infants']],
            'default-nights'             => ['type' => 'number', 'default' => $wp_options[$prefix_options . 'default-nights']],
            'default-rooms'              => ['type' => 'number', 'default' => $wp_options[$prefix_options . 'default-rooms']],
            'default-adults'             => ['type' => 'number', 'default' => $wp_options[$prefix_options . 'default-adults']],
            'default-children'           => ['type' => 'number', 'default' => $wp_options[$prefix_options . 'default-children']],
            'default-infants'            => ['type' => 'number', 'default' => $wp_options[$prefix_options . 'default-infants']],
            'orientation'                => ['type' => 'string', 'default' => $wp_options[$prefix_options . 'orientation']],
            'checkout-date'              => ['type' => 'string', 'default' => ($wp_options[$prefix_options . 'checkout-date']) ? '1' : '0'],
            'opening-date'               => ['type' => 'string', 'default' => ($opening_date) ? $opening_date->format('Y-m-d\TH:i:s') : current_time('Y-m-d\TH:i:s')],
            'closing-date'               => ['type' => 'string', 'default' => ($closing_date) ? $closing_date->format('Y-m-d\TH:i:s') : current_time('Y-m-d\TH:i:s')],
            'days-after-checkin-allowed' => ['type' => 'number', 'default' => $wp_options[$prefix_options . 'days-after-checkin-allowed']],
            'blank-target'               => ['type' => 'string', 'default' => ($wp_options[$prefix_options . 'blank-target']) ? '1' : '0'],
            'css-class'                  => ['type' => 'string', 'default' => $wp_options[$prefix_options . 'css-class']]
        ],
        'render_callback' => 'wp_webhotelier_render_shortcode_block'
    ]);
}

add_action('init', 'wp_webhotelier_register_block');

function wp_webhotelier_render_shortcode_block($wp_webhotelier_atts)
{
    $opening_date_object                          = (new DateTime())->createFromFormat('Y-m-d\TH:i:s', $wp_webhotelier_atts['opening-date']);
    $closing_date_object                          = (new DateTime())->createFromFormat('Y-m-d\TH:i:s', $wp_webhotelier_atts['closing-date']);
    $wp_webhotelier_atts['opening-closing-dates'] = $opening_date_object->format('Y-m-d') . ' to ' . $closing_date_object->format('Y-m-d');
    $shortcode_atts                               = '';

    foreach ($wp_webhotelier_atts as $att_key => $att_value) {
        $shortcode_atts .= $att_key . '="' . $att_value . '" ';
    }

    return do_shortcode('[wp-webhotelier ' . trim($shortcode_atts) . ']');
}
