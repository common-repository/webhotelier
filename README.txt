=== WebHotelier for WordPress ===
Contributors: sotiris_k, wplugged
Donate link: https://ko-fi.com/wplugged
Tags: forms, hotel, webhotelier
Requires at least: 4.9
Tested up to: 6.4
Stable tag: 1.9.1
Requires PHP: 5.6
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

This WordPress Plugin is a form generator/manager exlusively designed to aid WebHotelier Clients on generating and managing forms which are linked to their WebHotelier accounts so that their website visitors can directly search for room availability. WebHotelier for WordPress helps you create shortcodes and widgets to customize how the booking experince looks and feels for your customer. You can choose out of 3 predefined layouts for your form or you can add your own CSS if you wish.

== Description ==

This WordPress Plugin is a form generator/manager exlusively designed to aid WebHotelier Clients on generating and managing forms which are linked to their WebHotelier accounts so that their website visitors can directly search for room availability. 

WebHotelier for WordPress helps you create shortcodes and widgets to customize how the booking experince looks and feels for your customer. 

You can choose out of 3 predefined layouts for your form or you can add your own CSS if you wish.

== Installation ==

1. Upload `webhotelier` folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Go to the newly generated admin menu called 'WebHotelier Options'

 == Screenshots == 

 1. The WebHotelier Availability Form
 2. Admin Form Field Settings
 3. Admin Form Customization Settings
 4. Admin Widget

== Frequently Asked Questions ==

= Is this a reservation form? =

No. It is a search availability form which requires a WebHotelier Account.

= What if I don't have a WebHotelier Account? =

It's not too late to [join WebHotelier](https://www.webhotelier.net/join) and enjoy the many perks, this plugin included, that such a partnership entails.

= Can I put this form anywhere I want? =

If a shortcode inside your posts or a widget on your sidebar or footer or header isn't satisfying your needs then you can manually go into your theme and use the following PHP code anywhere you deem fit.

`
<?php echo do_shortcode('[wp-webhotelier]'); ?>
`

Since this is technically still a shortcode, you can customize it with everything that is listed in the [documentation](https://wplugged.com/docs/webhotelier-for-wordpress/shortcode/).

== Changelog ==

= 1.9.1 =
* Removes unused code

= 1.9.0 =
* Complete refactoring of the Gutenberg block
* Fixes a shortcode bug related to the opening and closing dates
* Fixes a bug occuring solely on Safari

= 1.8.2 =
* Fixes some deprecation notices
* Tested up to WordPress 6.4.3

= 1.8.1 =
* Fixes a default option check
* Tested up to WordPress 6.4

= 1.8.0 =
* Updates codestar framework to 2.3.0
* Tested up to WordPress 6.2.2

= 1.7.7 =
* Fixes a legacy widget bug related to the opening and closing dates

= 1.7.6 =
* Updates codestart framework to v2.2.9
* Tested up to wordpress 6.1.1

= 1.7.5 =
* Adds a title attribute to flatpickr inputs for accessibility tools to not display related errors
* Updates flatpickr
* Updates admin framework
* Tested up to WordPress 6.0

= 1.7.4 =
* Fixes a PHP Notice
* Tested up to WordPress 5.9

= 1.7.3 =
* Adds more robust activation logic

= 1.7.2 =
* Adds a fix for the upgrade process

= 1.7.1 =
* Updates Greek translation

= 1.7 =
* Replaces Titan framework completely

= 1.6.1 =
* Fixes a framework bug

= 1.6 =
* Changes the way flatpickr displays enabled dates based on the opening and closing dates of the form. The year part is ignored.

= 1.5 =
* Adds the ability to define your custom calendar date format

= 1.4 =
* Adds the ability for the calendar to load its respected locale

= 1.3 =
* Adds the ability to choose default nights, rooms, adults, children and infants

= 1.2.2 =
* Adds a better fix for orientation

= 1.2.1 =
* Fixes a form orientation error

= 1.2.0 =
* Adds compatibility ensurance with WP 5.6.2
* Adds the choice of opening WebHotelier in a new tab
* Adds the current locale as an instruction to WebHotelier to open the respected locale in its platform if it exists

= 1.1.7 =
* Adds compatibility ensurance with WP 5.6.1
* Fixes the nights field
* Fixes the closing date

= 1.1.6 =
* Adds compatibility ensurance with WP 5.5.3

= 1.1.5 =
* Fixes a custom CSS class error
* Adds compatibility ensurance with WP 5.3

= 1.1.4 =
* Fixes a PHP Notice
* Optimization changes

= 1.1.3 =
* Fixes a plugin activation error

= 1.1.2 =
* Fixes a Gutenberg error

= 1.1.1 =
* Fixes an update error

= 1.1.0 =
* Adds the ability to choose how many days forward you want the default check-in date to be.
* Adds Opening and Closing Dates of the Hotel(s) to correctly calculate each year the correct default Check-in date

= 1.0.3 =
* Fixes a Flatpickr position issue
* Fixes Custom CSS not being removed when it has been emptied

= 1.0.2 =
* Fixes a script loading error

= 1.0.1 =
* Updates Flatpickr Library
* Fixes Custom CSS

= 1.0 =
* First version of WebHotelier for WordPress