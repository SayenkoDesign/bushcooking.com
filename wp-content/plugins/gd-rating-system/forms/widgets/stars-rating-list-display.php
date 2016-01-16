<h4><?php _e("Template and style", "gd-rating-system"); ?></h4>
<table>
    <tbody>
        <tr>
            <td class="cell-left">
                <label for="<?php echo $this->get_field_id('template'); ?>"><?php _e("Template", "gd-rating-system"); ?>:</label>
                <?php d4p_render_select(gdrts_admin_shared::data_list_templates('stars-rating', 'list'), array('id' => $this->get_field_id('template'), 'class' => 'widefat', 'name' => $this->get_field_name('template'), 'selected' => $instance['template'])); ?>
            </td>
            <td class="cell-right">
                <label for="<?php echo $this->get_field_id('style_class'); ?>"><?php _e("Additional CSS Class", "gd-rating-system"); ?>:</label>
                <input class="widefat" id="<?php echo $this->get_field_id('style_class'); ?>" name="<?php echo $this->get_field_name('style_class'); ?>" type="text" value="<?php echo esc_attr($instance['style_class']); ?>" />
            </td>
        </tr>
        <tr>
            <td class="cell-left">
                <label for="<?php echo $this->get_field_id('style_type'); ?>"><?php _e("Style Type", "gd-rating-system"); ?>:</label>
                <?php d4p_render_select(gdrts_admin_shared::data_list_style_type(), array('id' => $this->get_field_id('style_type'), 'class' => 'widefat', 'name' => $this->get_field_name('style_type'), 'selected' => $instance['style_type'])); ?>
            </td>
            <td class="cell-right">
                <label for="<?php echo $this->get_field_id('style_size'); ?>"><?php _e("Size (px)", "gd-rating-system"); ?>:</label>
                <input class="widefat d4p-setting-integer" id="<?php echo $this->get_field_id('style_size'); ?>" name="<?php echo $this->get_field_name('style_size'); ?>" type="text" value="<?php echo esc_attr($instance['style_size']); ?>" />
            </td>
        </tr>
        <tr>
            <td class="cell-left">
                <label for="<?php echo $this->get_field_id('style_font_name'); ?>"><?php _e("Font Icon", "gd-rating-system"); ?>:</label>
                <?php d4p_render_select(gdrts_admin_shared::data_list_style_font_name(), array('id' => $this->get_field_id('style_font_name'), 'class' => 'widefat', 'name' => $this->get_field_name('style_font_name'), 'selected' => $instance['style_font_name'])); ?>
            </td>
            <td class="cell-right">
                <label for="<?php echo $this->get_field_id('style_image_name'); ?>"><?php _e("Image", "gd-rating-system"); ?>:</label>
                <?php d4p_render_select(gdrts_admin_shared::data_list_style_image_name(), array('id' => $this->get_field_id('style_image_name'), 'class' => 'widefat', 'name' => $this->get_field_name('style_image_name'), 'selected' => $instance['style_image_name'])); ?>
            </td>
        </tr>
    </tbody>
</table>
