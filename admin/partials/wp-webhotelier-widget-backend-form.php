<?php
/**
 * Provide the widget admin form
 *
 * @link       https://wplugged.com
 * @since      1.0.0
 *
 * @package    Wp_Webhotelier
 * @subpackage Wp_Webhotelier/admin/partials
 */
?>
<p>
    <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_attr_e('Title:');?></label>
    <input 
    class="widefat" 
    id="<?php echo esc_attr($this->get_field_id('title')); ?>"
    name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text"
    value="<?php echo esc_attr($instance['title']); ?>" 
    placeholder="<?php esc_attr_e('Optional Title')?>" />
</p>
<p>
    <label for="<?php echo esc_attr($this->get_field_id('url')); ?>"><?php esc_attr_e('Booking URL:', 'wp_webhotelier');?></label>
    <input
    class="widefat"
    id="<?php echo esc_attr($this->get_field_id('url')); ?>"
    name="<?php echo esc_attr($this->get_field_name('url')); ?>"
    type="text"
    value="<?php echo esc_attr($instance['url']); ?>">
</p>
<p>
    <label for="<?php echo esc_attr($this->get_field_id('checkout-date')); ?>"><?php esc_attr_e('Nights or Checkout Date:', 'wp_webhotelier');?></label>
    <select
    class="widefat"
    id="<?php echo esc_attr($this->get_field_id('checkout-date')); ?>"
    name="<?php echo esc_attr($this->get_field_name('checkout-date')); ?>" >
    <option value="1" <?php echo (esc_attr($instance['checkout-date'])) ? 'selected="selected"' : ""; ?> ><?php esc_attr_e('Checkout Date', 'wp-webhotelier') ?></option>
    <option value="0" <?php echo (!esc_attr($instance['checkout-date'])) ? 'selected="selected"' : ""; ?> ><?php esc_attr_e('Number of Nights', 'wp-webhotelier') ?></option>

    </select>
</p>
<p style="display: <?php echo (!esc_attr($instance['checkout-date'])) ? 'block' : 'none' ?>;">
    <label for="<?php echo esc_attr($this->get_field_id('max-nights')); ?>"><?php esc_attr_e('Max Nights', 'wp_webhotelier');?>:</label>
    <input
    class="widefat"
    id="<?php echo esc_attr($this->get_field_id('max-nights')); ?>"
    name="<?php echo esc_attr($this->get_field_name('max-nights')); ?>"
    type="number"
    min=1
    value="<?php echo esc_attr($instance['max-nights']); ?>">
</p>
<p>
    <label for="<?php echo esc_attr($this->get_field_id('max-rooms')); ?>"><?php esc_attr_e('Max Rooms', 'wp_webhotelier');?>:</label>
    <input
    class="widefat"
    id="<?php echo esc_attr($this->get_field_id('max-rooms')); ?>"
    name="<?php echo esc_attr($this->get_field_name('max-rooms')); ?>"
    type="number"
    min=1
    value="<?php echo esc_attr($instance['max-rooms']); ?>">
</p>
<p>
    <label for="<?php echo esc_attr($this->get_field_id('max-adults')); ?>"><?php esc_attr_e('Max Adults', 'wp_webhotelier');?>:</label>
    <input
    class="widefat"
    id="<?php echo esc_attr($this->get_field_id('max-adults')); ?>"
    name="<?php echo esc_attr($this->get_field_name('max-adults')); ?>"
    type="number"
    min=1
    value="<?php echo esc_attr($instance['max-adults']); ?>">
</p>
<p>
    <label for="<?php echo esc_attr($this->get_field_id('max-children')); ?>"><?php esc_attr_e('Max Children', 'wp_webhotelier');?>:</label>
    <input
    class="widefat"
    id="<?php echo esc_attr($this->get_field_id('max-children')); ?>"
    name="<?php echo esc_attr($this->get_field_name('max-children')); ?>"
    type="number"
    min=0
    value="<?php echo esc_attr($instance['max-children']); ?>">
</p>
<p>
    <label for="<?php echo esc_attr($this->get_field_id('max-infants')); ?>"><?php esc_attr_e('Max Infants', 'wp_webhotelier');?>:</label>
    <input
    class="widefat"
    id="<?php echo esc_attr($this->get_field_id('max-infants')); ?>"
    name="<?php echo esc_attr($this->get_field_name('max-infants')); ?>"
    type="number"
    min=0
    value="<?php echo esc_attr($instance['max-infants']); ?>">
</p>
<p style="display: <?php echo (!esc_attr($instance['checkout-date'])) ? 'block' : 'none' ?>;">
    <label for="<?php echo esc_attr($this->get_field_id('default-nights')); ?>"><?php esc_attr_e('Default Nights', 'wp_webhotelier');?>:</label>
    <input
    class="widefat"
    id="<?php echo esc_attr($this->get_field_id('default-nights')); ?>"
    name="<?php echo esc_attr($this->get_field_name('default-nights')); ?>"
    type="number"
    min=1
    value="<?php echo esc_attr($instance['default-nights']); ?>">
</p>
<p>
    <label for="<?php echo esc_attr($this->get_field_id('default-rooms')); ?>"><?php esc_attr_e('Default Rooms', 'wp_webhotelier');?>:</label>
    <input
    class="widefat"
    id="<?php echo esc_attr($this->get_field_id('default-rooms')); ?>"
    name="<?php echo esc_attr($this->get_field_name('default-rooms')); ?>"
    type="number"
    min=1
    value="<?php echo esc_attr($instance['default-rooms']); ?>">
</p>
<p>
    <label for="<?php echo esc_attr($this->get_field_id('default-adults')); ?>"><?php esc_attr_e('Default Adults', 'wp_webhotelier');?>:</label>
    <input
    class="widefat"
    id="<?php echo esc_attr($this->get_field_id('default-adults')); ?>"
    name="<?php echo esc_attr($this->get_field_name('default-adults')); ?>"
    type="number"
    min=1
    value="<?php echo esc_attr($instance['default-adults']); ?>">
</p>
<p>
    <label for="<?php echo esc_attr($this->get_field_id('default-children')); ?>"><?php esc_attr_e('Default Children', 'wp_webhotelier');?>:</label>
    <input
    class="widefat"
    id="<?php echo esc_attr($this->get_field_id('default-children')); ?>"
    name="<?php echo esc_attr($this->get_field_name('default-children')); ?>"
    type="number"
    min=0
    value="<?php echo esc_attr($instance['default-children']); ?>">
</p>
<p>
    <label for="<?php echo esc_attr($this->get_field_id('default-infants')); ?>"><?php esc_attr_e('Default Infants', 'wp_webhotelier');?>:</label>
    <input
    class="widefat"
    id="<?php echo esc_attr($this->get_field_id('default-infants')); ?>"
    name="<?php echo esc_attr($this->get_field_name('default-infants')); ?>"
    type="number"
    min=0
    value="<?php echo esc_attr($instance['default-infants']); ?>">
</p>
<p>
    <label for="<?php echo esc_attr($this->get_field_id('days-after-checkin-allowed')); ?>"><?php esc_attr_e('Days from today that Check-in is allowed', 'wp_webhotelier');?>:</label>
    <input
    class="widefat"
    id="<?php echo esc_attr($this->get_field_id('days-after-checkin-allowed')); ?>"
    name="<?php echo esc_attr($this->get_field_name('days-after-checkin-allowed')); ?>"
    type="number"
    min=0
    value="<?php echo esc_attr($instance['days-after-checkin-allowed']); ?>">
</p>
<label for="<?php echo esc_attr($this->get_field_id('opening-day')); ?>"><?php esc_attr_e('Opening Day and Month of the Hotel', 'wp_webhotelier');?>:</label>
<div style="display: flex; flex-direction:row; margin: 5px 0 10px 0">
    <select
    class="widefat"
    id="<?php echo esc_attr($this->get_field_id('opening-day')); ?>"
    name="<?php echo esc_attr($this->get_field_name('opening-day')); ?>"
    >
    <?php foreach (range(1,31) as $day): ?>
        <option value="<?php echo $day ?>" <?php echo (esc_attr($instance['opening-day']) == $day) ? "selected" : ""; ?>><?php echo $day ?></option>
    <?php endforeach; ?>
    </select>
    <select
    class="widefat"
    id="<?php echo esc_attr($this->get_field_id('opening-month')); ?>"
    name="<?php echo esc_attr($this->get_field_name('opening-month')); ?>"
    >
    <?php foreach (range(1,12) as $month): ?>
        <option value="<?php echo $month ?>" <?php echo (esc_attr($instance['opening-month']) == $month) ? "selected" : ""; ?>><?php echo (new DateTime())->createFromFormat('m', $month)->format('F'); ?></option>
    <?php endforeach; ?>
    </select>
</div>
<label for="<?php echo esc_attr($this->get_field_id('closing-day')); ?>"><?php esc_attr_e('Closing Day and Month of the Hotel', 'wp_webhotelier');?>:</label>
<div style="display: flex; flex-direction:row; margin: 5px 0 10px 0">
    <select
    class="widefat"
    id="<?php echo esc_attr($this->get_field_id('closing-day')); ?>"
    name="<?php echo esc_attr($this->get_field_name('closing-day')); ?>"
    >
    <?php foreach (range(1,31) as $day): ?>
        <option value="<?php echo $day ?>" <?php echo (esc_attr($instance['closing-day']) == $day) ? "selected" : ""; ?>><?php echo $day ?></option>
    <?php endforeach; ?>
    </select>
    <select
    class="widefat"
    id="<?php echo esc_attr($this->get_field_id('closing-month')); ?>"
    name="<?php echo esc_attr($this->get_field_name('closing-month')); ?>"
    >
    <?php foreach (range(1,12) as $month): ?>
        <option value="<?php echo $month ?>" <?php echo (esc_attr($instance['closing-month']) == $month) ? "selected" : ""; ?>><?php echo (new DateTime())->createFromFormat('m', $month)->format('F'); ?></option>
    <?php endforeach; ?>
    </select>
</div>
<p>
    <label for="<?php echo esc_attr($this->get_field_id('blank-target')); ?>"><?php esc_attr_e('Open WebHotelier in new tab', 'wp_webhotelier');?>:</label>
    <select
    class="widefat"
    id="<?php echo esc_attr($this->get_field_id('blank-target')); ?>"
    name="<?php echo esc_attr($this->get_field_name('blank-target')); ?>" >
    <option value="1" <?php echo (esc_attr($instance['blank-target'])) ? 'selected="selected"' : ""; ?> ><?php esc_attr_e('Yes', 'wp-webhotelier') ?></option>
    <option value="0" <?php echo (!esc_attr($instance['blank-target'])) ? 'selected="selected"' : ""; ?> ><?php esc_attr_e('No', 'wp-webhotelier') ?></option>

    </select>
</p>
<p>
    <label for="<?php echo esc_attr($this->get_field_id('orientation')); ?>"><?php esc_attr_e('Form Orientation:', 'wp_webhotelier');?></label>
    <select
    class="widefat"
    id="<?php echo esc_attr($this->get_field_id('orientation')); ?>"
    name="<?php echo esc_attr($this->get_field_name('orientation')); ?>"
    >
    <option value="horizontal" <?php echo esc_attr($instance['orientation']) === "horizontal" ? "selected" : ""; ?>><?php _e('Horizontal', 'wp-webhotelier')?></option>
    <option value="vertical" <?php echo esc_attr($instance['orientation']) === "vertical" ? "selected" : ""; ?>><?php _e('Vertical', 'wp-webhotelier')?></option>
    <option value="fluid" <?php echo esc_attr($instance['orientation']) === "fluid" ? "selected" : ""; ?>><?php _e('Fluid', 'wp-webhotelier')?></option>
    </select>
</p>
<p>
    <label for="<?php echo esc_attr($this->get_field_id('css-class')); ?>"><?php esc_attr_e('Custom CSS Class:', 'wp_webhotelier');?></label>
    <input
    class="widefat"
    id="<?php echo esc_attr($this->get_field_id('css-class')); ?>"
    name="<?php echo esc_attr($this->get_field_name('css-class')); ?>"
    type="text"
    value="<?php echo esc_attr($instance['css-class']); ?>">
</p>