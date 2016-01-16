<?php // GDRTS Template: Shortcode // ?>

<div class="<?php gdrtsm_stars_rating()->loop()->render()->classes(); ?>">
    <div class="gdrts-inner-wrapper gdrts-grid-wrapper">
        <table>
            <thead>
                <tr>
                    <th class="gdrts-grid-order"></th>
                    <th class="gdrts-grid-item"><?php _e("Item", "gd-rating-system"); ?></th>
                    <th class="gdrts-grid-votes"><?php _e("Votes", "gd-rating-system"); ?></th>
                    <th class="gdrts-grid-rating" colspan="2"><?php _e("Rating", "gd-rating-system"); ?></th>
                </tr>
            </thead>
            <tbody>

<?php

if (gdrts_list()->have_items()) :
    while (gdrts_list()->have_items()) :
        gdrts_list()->the_item();

?>

<tr>
    <td class="gdrts-grid-order"><?php echo gdrts_list()->item()->ordinal; ?></td>
    <td class="gdrts-grid-item"><a href="<?php echo gdrts_list()->item()->url(); ?>"><?php echo gdrts_list()->item()->title(); ?></a></td>
    <td class="gdrts-grid-votes"><?php gdrtsm_stars_rating()->loop()->value('votes'); ?></td>
    <td class="gdrts-grid-rating"><?php gdrtsm_stars_rating()->loop()->value('rating'); ?></td>
    <td class="gdrts-grid-rating-stars"><?php gdrtsm_stars_rating()->loop()->render()->stars(); ?></td>
</tr>

<?php

    endwhile;

else :

?>

<tr><td colspan="4"><?php _e("No items found.", "gd-rating-system"); ?></td></tr>

<?php

endif;

?>

            </tbody>
        </table>

        <?php gdrts_list()->json(); ?>

    </div>
</div>
