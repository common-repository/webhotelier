<?php
/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @package    Wp_Webhotelier
 * @subpackage Wp_Webhotelier/includes
 * @author     WPlugged <support@wplugged.com>
 */
class Wp_Webhotelier_Deactivator
{

    public static function deactivate()
    {
        if (!current_user_can('activate_plugins')) {
            return;
        }
        
        $plugin = isset($_REQUEST['plugin']) ? $_REQUEST['plugin'] : '';
        
        // Checks admin nonce and returns either true or die();
        check_admin_referer("deactivate-plugin_{$plugin}");

        $noticeOptionName = 'wp-webhotelier-' . md5('disable-done-notice');

        $noticeOption = get_site_option($noticeOptionName);
        if (!$noticeOption) {
            return;
        }
        delete_site_option($noticeOptionName);
    }

}
