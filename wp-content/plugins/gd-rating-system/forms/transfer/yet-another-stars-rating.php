<div class="d4p-group d4p-group-import d4p-group-important">
    <h3><?php _e("Important", "gd-rating-system"); ?></h3>
    <div class="d4p-group-inner">
        <?php _e("This tool can import rating data from Yet Another Stars Rating plugin. There are some important things you need to know about import process.", "gd-rating-system"); ?>
        <ul style="list-style: inside disc; font-weight: normal;">
            <li><?php _e("This tool can transfer posts ratings and number of votes, author reviews along with votes log data.", "gd-rating-system"); ?></li>
            <li><?php _e("Imported data will be marked with special import flag and will be skipped later if you decide to use this tool again.", "gd-rating-system"); ?></li>
            <li><?php _e("For import process to work, Yet Another Stars Rating database tables 'wp_yasr_log' and 'wp_yasr_votes' must be present.", "gd-rating-system"); ?></li>
            <li><?php _e("Yet Another Stars Rating plugin database tables will not be modified in any way or deleted during this import process.", "gd-rating-system"); ?></li>
        </ul>
    </div>
</div>

<?php

require_once(GDRTS_PATH.'core/transfer/yet-another-stars-rating.php');

$transfer = new gdrts_transfer_yet_another_stars_rating();

if (!$transfer->db_tables_exist()) {
    
?>

<div class="d4p-group d4p-group-import d4p-group-important">
    <h3><?php _e("Import not possible", "gd-rating-system"); ?></h3>
    <div class="d4p-group-inner">
        <?php _e("Required database tables not found. Import process can't proceed.", "gd-rating-system"); ?>
    </div>
</div>

<?php
    
} else {

?>

<div class="d4p-group d4p-group-import">
    <h3><?php _e("Import: Star Ratings Votes", "gd-rating-system"); ?></h3>
    <div class="d4p-group-inner">
        <table class="form-table">
            <tbody>
                <tr valign="top">
                    <th scope="row"><?php _e("Import", "gd-rating-system"); ?></th>
                    <td>
                        <div class="d4p-setting-bool">
                            <label for="gdrtstools_transfer_yet_another_stars_rating_stars_rating_active">
                                <input type="checkbox" class="widefat" id="gdrtstools_transfer_yet_another_stars_rating_stars_rating_active" name="gdrtstools[transfer][yet-another-stars-rating][stars-rating][active]"><?php _e("Enabled", "gd-rating-system"); ?>
                            </label>
                        </div>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"><?php _e("How to import", "gd-rating-system"); ?></th>
                    <td>
                        <div class="d4p-setting-number">
                            <select class="widefat" name="gdrtstools[transfer][yet-another-stars-rating][stars-rating][method]">
                                <option selected="selected" value="log"><?php _e("Rating based on ratings log only", "gd-rating-system"); ?></option>
                                <option value="data"><?php _e("Rating results only", "gd-rating-system"); ?> (<?php _e("Not recommended", "gd-rating-system"); ?>)</option>
                            </select>
                            <em><?php _e("Rating log might contain incomplete list of ratings compared to rating results, but these ratings include more information and can be edited or deleted later.", "gd-rating-system"); ?><br/>
                            <strong><?php _e("If you import rating results only, you will not have votes distribution information since rating results are aggregated. To get votes distribution you must use log based import.", "gd-rating-system"); ?></strong></em>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<div class="d4p-group d4p-group-import">
    <h3><?php _e("Import: Overall / Author Ratings", "gd-rating-system"); ?></h3>
    <div class="d4p-group-inner">
        Stars Review rating method is available only in GD Rating System Pro. You can upgrade to GD Rating System Pro <a target="_blank" href="https://rating.dev4press.com/">here</a>.
        <p style="font-weight: normal; margin: 10px 0 0;">To learn more about the features available in Pro version only, check out this <a target="_blank" href="https://rating.dev4press.com/free-vs-pro-plugin/">FREE vs. PRO</a> comparison.</p>
    </div>
</div>

<?php }
