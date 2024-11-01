<?php
/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @package    Wp_Webhotelier
 * @subpackage Wp_Webhotelier/includes
 * @author     WPlugged <support@wplugged.com>
 */
class Wp_Webhotelier_Activator
{
    public static function activate()
    {
        $wp_options = get_option('wp-webhotelier_options');
        if (!$wp_options || is_array($wp_options)) {
            return;
        }
        $wp_options = unserialize($wp_options);
        if (!empty($wp_options['wp-webhotelier-opening-closing-dates'])) {
            $opening_closing_dates = explode(' to ', $wp_options['wp-webhotelier-opening-closing-dates']);
            if (!empty($opening_closing_dates[0]) && !empty($opening_closing_dates[1])) {
                $wp_options['wp-webhotelier-opening-closing-dates'] = [
                    'from' => (new DateTime())->createFromFormat('Y-m-d', $opening_closing_dates[0])->format('d/m'),
                    'to'   => (new DateTime())->createFromFormat('Y-m-d', $opening_closing_dates[1])->format('d/m')
                ];
            }
        }
        update_option('wp-webhotelier_options', $wp_options);
    }
}
