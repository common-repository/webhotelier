<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       https://wplugged.com
 *
 * @package    Wp_Webhotelier
 * @subpackage Wp_Webhotelier/public/partials
 */
?>
<div class="wp-webhotelier">
    <?php do_action('wp-webhotelier-pre-form'); ?>
    <form 
    id="form-wp-webhotelier-<?php echo $my_id ?>" 
    method="POST" 
    action="<?php echo $wp_webhotelier_atts['url'] ?>" 
    class="wp-webhotelier-form<?php echo ($wp_webhotelier_atts['orientation'] == "vertical") ? '-stacked' : '' ?> <?php echo $wp_webhotelier_atts['css-class'] ?>" 
    data-default-date="<?php echo $wp_webhotelier_atts['default-date'] ?>" 
    data-closing-date="<?php echo $wp_webhotelier_atts['closing-date'] ?>"
    data-opening-date="<?php echo $wp_webhotelier_atts['opening-date'] ?>"
    target="<?php echo (isset($wp_webhotelier_atts['blank-target']) && $wp_webhotelier_atts['blank-target']) ? "_blank" : "_self"; ?>"
    >
        <div class="wp-webhotelier-form-wrap">
            <?php do_action('wp-webhotelier-in-start-form'); ?>
            <div class="wp-webhotelier-fields">
                <?php if ($wp_webhotelier_atts['orientation'] == "fluid") : ?>
                    <div class="wp-webhotelier-group-fluid">
                    <?php endif; ?>
                    <div class="wp-webhotelier-control-group">
                        <div class="wp-webhotelier-control-input">
                            <label for="wp-webhotelier-checkin-<?php echo $my_id ?>"><?php _e('Check-in', 'wp-webhotelier') ?></label>
                            <input type="text" id="wp-webhotelier-checkin-<?php echo $my_id ?>" name="checkin" value="" />
                        </div>
                    </div>
                    <div class="wp-webhotelier-control-group">
                        <?php if ($wp_webhotelier_atts['checkout-date']) : ?>
                            <label for="wp-webhotelier-checkout-<?php echo $my_id ?>"><?php _e('Check-out', 'wp-webhotelier') ?></label>
                            <input type="text" id="wp-webhotelier-checkout-<?php echo $my_id ?>" name="checkout" value="" />
                        <?php else : ?>
                            <label for="wp-webhotelier-num-nights-<?php echo $my_id ?>"><?php _e('Nights', 'wp-webhotelier'); ?></label>
                            <select name="nights" id="wp-webhotelier-num-nights-<?php echo $my_id ?>">
                                <?php foreach (range(1, $wp_webhotelier_atts['max-nights']) as $value) : ?>
                                    <option value="<?php echo $value ?>" <?php echo (isset($wp_webhotelier_atts['default-nights']) && $wp_webhotelier_atts['default-nights'] == $value)? 'selected="selected"' : '' ?>>
                                        <?php echo $value ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        <?php endif; ?>
                    </div>
                    <?php if ($wp_webhotelier_atts['orientation'] == "fluid") : ?>
                    </div>
                    <div class="wp-webhotelier-group-fluid">
                    <?php endif; ?>
                    <div class="wp-webhotelier-control-group">
                        <label for="wp-webhotelier-rooms-<?php echo $my_id ?>"><?php _e('Rooms', 'wp-webhotelier'); ?></label>
                        <select name="rooms" id="wp-webhotelier-rooms-<?php echo $my_id ?>">
                            <?php foreach (range(1, $wp_webhotelier_atts['max-rooms']) as $value) : ?>
                                <option value="<?php echo $value ?>" <?php echo (isset($wp_webhotelier_atts['default-rooms']) && $wp_webhotelier_atts['default-rooms'] == $value)? 'selected="selected"' : '' ?>>
                                    <?php echo $value ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="wp-webhotelier-control-group">
                        <label for="wp-webhotelier-adults-<?php echo $my_id ?>"><?php _e('Adults', 'wp-webhotelier') ?></label>
                        <select name="adults" id="wp-webhotelier-adults-<?php echo $my_id ?>">
                            <?php foreach (range(1, $wp_webhotelier_atts['max-adults']) as $value) : ?>
                                <option value="<?php echo $value ?>" <?php echo (isset($wp_webhotelier_atts['default-adults']) && $wp_webhotelier_atts['default-adults'] == $value)? 'selected="selected"' : '' ?>>
                                    <?php echo $value ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <?php if ($wp_webhotelier_atts['max-children'] != 0) : ?>
                        <div class="wp-webhotelier-control-group">
                            <label for="wp-webhotelier-children-<?php echo $my_id ?>"><?php _e('Children', 'wp-webhotelier') ?></label>
                            <select name="children" id="wp-webhotelier-children-<?php echo $my_id ?>">
                                <?php foreach (range(0, $wp_webhotelier_atts['max-children']) as $value) : ?>
                                    <option value="<?php echo $value ?>" <?php echo (isset($wp_webhotelier_atts['default-children']) && $wp_webhotelier_atts['default-children'] == $value)? 'selected="selected"' : '' ?>>
                                        <?php echo $value ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    <?php endif; ?>
                    <?php if ($wp_webhotelier_atts['max-infants'] != 0) : ?>
                        <div class="wp-webhotelier-control-group">
                            <label for="wp-webhotelier-infants-<?php echo $my_id ?>"><?php _e('Infants', 'wp-webhotelier') ?></label>
                            <select name="infants" id="wp-webhotelier-infants-<?php echo $my_id ?>">
                                <?php foreach (range(0, $wp_webhotelier_atts['max-infants']) as $value) : ?>
                                    <option value="<?php echo $value ?>" <?php echo (isset($wp_webhotelier_atts['default-infants']) && $wp_webhotelier_atts['default-infants'] == $value)? 'selected="selected"' : '' ?>>
                                        <?php echo $value ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    <?php endif; ?>
                    <div class="wp-webhotelier-control-group">
                        <button class="wp-webhotelier-button" type="submit" id="wp-webhotelier-submit-<?php echo $my_id ?>">
                            <?php _e('Search availability', 'wp-webhotelier') ?>
                        </button>
                    </div>
                    <?php if ($wp_webhotelier_atts['orientation'] == "fluid") : ?>
                    </div>
                <?php endif; ?>
            </div>
            <?php do_action('wp-webhotelier-in-end-form'); ?>
        </div>
        <input type="hidden" name="lang" value="<?php echo Wp_Webhotelier_Helper::getCurrentLang() ?>">
    </form>
    <?php do_action('wp-webhotelier-after-form'); ?>
</div>