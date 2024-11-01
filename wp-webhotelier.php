<?php

/**
 * @wordpress-plugin
 * Plugin Name:       WebHotelier for WordPress
 * Plugin URI:        https://wplugged.com/docs/webhotelier-for-wordpress/
 * Description:       Create and manage WebHotelier Forms easily through your WordPress
 * Version:           1.9.1
 * Author:            WPlugged
 * Author URI:        https://wplugged.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wp-webhotelier
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

/**
 * Current plugin version.
 */
define('WP_WEBHOTELIER_VERSION', '1.9.1');


/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wp-webhotelier-activator.php
 */
function activate_wp_webhotelier()
{
    require_once plugin_dir_path(__FILE__) . 'includes/class-wp-webhotelier-activator.php';
    Wp_Webhotelier_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wp-webhotelier-deactivator.php
 */
function deactivate_wp_webhotelier()
{
    require_once plugin_dir_path(__FILE__) . 'includes/class-wp-webhotelier-deactivator.php';
    Wp_Webhotelier_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_wp_webhotelier');
register_deactivation_hook(__FILE__, 'deactivate_wp_webhotelier');

/**
 * Run the activator process on each upgrade
 *
 * @param object $upgrader_object
 * @param array $options
 * @return void
 */
function wp_webhotelier_upgrader($upgrader_object, $options)
{
	require_once plugin_dir_path(__FILE__) . 'includes/class-wp-webhotelier-activator.php';

    if ($options['action'] == 'update' && $options['type'] == 'plugin' && isset($options['plugins'])) {
        foreach ($options['plugins'] as $each_plugin) {
            if ($each_plugin == plugin_basename(__FILE__)) {
                Wp_Webhotelier_Activator::activate();
            }
        }
    }
}
add_action('upgrader_process_complete', 'wp_webhotelier_upgrader', 10, 2);

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path(__FILE__) . 'includes/class-wp-webhotelier.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 */
function run_wp_webhotelier()
{
    $plugin = new Wp_Webhotelier();
    $plugin->run();
}
run_wp_webhotelier();
