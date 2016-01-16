<?php

$panels = array();

include(GDRTS_PATH.'forms/shared/top.php');

$pages = gdrts_admin()->menu_items;

?>

<div class="d4p-front-left">
    <div class="d4p-front-title" style="height: auto;">
        <h1 style="font-size: 95px; line-height: 0.95; letter-spacing: -4px; text-align: right;">
            <span>GD RATING</span><span>SYSTEM</span>
            <span style="font-size: 48px; letter-spacing: 1px">
                <?php echo strtoupper(gdrts_settings()->info->edition); ?> 
                <em style="font-weight: 100; font-style: normal;"><?php _e("Edition", "gd-rating-system"); ?></em>
            </span>
        </h1>
        <h5><?php 

            _e("Version", "gd-rating-system");
            echo': '.gdrts_settings()->info->version.' - '.  gdrts_settings()->info->codename;

            if (gdrts_settings()->info->status != 'stable') {
                echo ' - <span style="color: red; font-weight: bold;">'.strtoupper(gdrts_settings()->info->status).'</span>';
            }
            
            ?></h5>
    </div>
    <div class="d4p-front-title" style="height: auto; margin-top: 20px; text-align: center; font-size: 18px; font-weight: bold;">
        You can upgrade to GD Rating System Pro <a target="_blank" href="https://rating.dev4press.com/">here</a>.
        <p style="font-size: 15px; font-weight: normal; margin: 10px 0 0;">To learn more about the features available in Pro version only, <br/>check out this <a target="_blank" href="https://rating.dev4press.com/free-vs-pro-plugin/">FREE vs. PRO</a> comparison.</p>
    </div>
    <div class="d4p-front-dev4press">
        &copy; 2008 - 2015. Dev4Press - <a target="_blank" href="https://www.dev4press.com/">www.dev4press.com</a> | 
                                        <a target="_blank" href="https://rating.dev4press.com/">rating.dev4press.com</a>
    </div>
</div>
<div class="d4p-front-right">
    <?php

    foreach ($pages as $page => $obj) {
        if ($page == 'front') continue;

        $url = 'admin.php?page=gd-rating-system-'.$page;

        ?>

            <div class="d4p-options-panel">
                <i class="fa fa-<?php echo $obj['icon']; ?>"></i>
                <h5><?php echo $obj['title']; ?></h5>
                <div>
                    <a class="button-primary" href="<?php echo $url; ?>"><?php _e("Open", "gd-rating-system"); ?></a>
                </div>
            </div>

        <?php
    }

    ?>
</div>

<?php 

include(GDRTS_PATH.'forms/shared/bottom.php');

