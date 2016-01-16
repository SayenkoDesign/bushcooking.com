<table class="form-table">
    <tbody>
        <tr valign="top">
            <th scope="row"><?php _e("Display Rating Block", "gd-rating-system"); ?></th>
            <td>
                <?php d4p_render_select(array_merge(array('default' => __("Default", "gd-rating-system")), gdrtsa_admin_posts()->get_list_embed_locations()), array('selected' => $_gdrts_display, 'name' => 'gdrts[posts-integration][location]')); ?>
            </td>
        </tr>
        <tr valign="top">
            <th scope="row"><?php _e("Rating Method", "gd-rating-system"); ?></th>
            <td>
                <?php d4p_render_select(array_merge(array('default' => __("Default", "gd-rating-system")), gdrtsa_admin_posts()->get_list_embed_methods()), array('selected' => $_gdrts_method, 'name' => 'gdrts[posts-integration][method]')); ?>
            </td>
        </tr>
    </tbody>
</table>
<input type="hidden" name="gdrts[posts-integration][nonce]" value="<?php echo wp_create_nonce('gdrts-posts-integration-'.$_gdrts_id); ?>" />
