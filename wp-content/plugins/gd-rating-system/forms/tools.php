<?php

$panels = array(
    'index' => array(
        'title' => __("Tools Index", "gd-rating-system"), 'icon' => 'wrench', 
        'info' => __("All plugin tools are split into several panels, and you access each starting from the right.", "gd-rating-system")),
    'updater' => array(
        'title' => __("Recheck and Update", "gd-rating-system"), 'icon' => 'refresh', 
        'button' => 'none', 'button_text' => '',
        'info' => __("Recheck plugin database tables, check for new templates and clean cache.", "gd-rating-system")),
    'recalc' => array(
        'title' => __("Recalculate Data", "gd-rating-system"), 'icon' => 'calculator', 
        'button' => 'button', 'button_text' => __("Recalculate", "gd-rating-system"),
        'info' => __("Recalculate various data used by the plugin based on the votes log.", "gd-rating-system")),
    'export' => array(
        'title' => __("Export Settings", "gd-rating-system"), 'icon' => 'download', 
        'button' => 'button', 'button_text' => __("Export", "gd-rating-system"),
        'info' => __("Export all plugin settings into file.", "gd-rating-system")),
    'import' => array(
        'title' => __("Import Settings", "gd-rating-system"), 'icon' => 'upload', 
        'button' => 'submit', 'button_text' => __("Import", "gd-rating-system"),
        'info' => __("Import all plugin settings from export file.", "gd-rating-system")),
    'remove' => array(
        'title' => __("Reset / Remove", "gd-rating-system"), 'icon' => 'remove', 
        'button' => 'submit', 'button_text' => __("Remove", "gd-rating-system"),
        'info' => __("Remove selected plugin settings, database tables and optionally disable plugin.", "gd-rating-system"))
);

include(GDRTS_PATH.'forms/shared/top.php');

?>

<form method="post" action="" enctype="multipart/form-data">
    <?php settings_fields('gd-rating-system-tools'); ?>
    <input type="hidden" value="<?php echo $_panel; ?>" name="gdrtstools[panel]" />
    <input type="hidden" value="postback" name="gdrts_handler" />

    <div class="d4p-content-left">
        <div class="d4p-panel-scroller d4p-scroll-active">
            <div class="d4p-panel-title">
                <i class="fa fa-wrench"></i>
                <h3><?php _e("Tools", "gd-rating-system"); ?></h3>
                <?php if ($_panel != 'index') { ?>
                <h4><i class="fa fa-<?php echo $panels[$_panel]['icon']; ?>"></i> <?php echo $panels[$_panel]['title']; ?></h4>
                <?php } ?>
            </div>
            <div class="d4p-panel-info">
                <?php echo $panels[$_panel]['info']; ?>
            </div>
            <?php if ($_panel != 'index' && $panels[$_panel]['button'] != 'none') { ?>
                <div class="d4p-panel-buttons">
                    <input id="gdrts-tool-<?php echo $_panel; ?>" class="button-primary" type="<?php echo $panels[$_panel]['button']; ?>" value="<?php echo $panels[$_panel]['button_text']; ?>" />
                </div>
            <?php } ?>
        </div>
    </div>
    <div class="d4p-content-right">
        <?php

        if ($_panel == 'index') {
            foreach ($panels as $panel => $obj) {
                if ($panel == 'index') continue;

                $url = 'admin.php?page=gd-rating-system-'.$_page.'&panel='.$panel;

                ?>

                <div class="d4p-options-panel">
                    <i class="fa fa-<?php echo $obj['icon']; ?>"></i>
                    <h5><?php echo $obj['title']; ?></h5>
                    <div>
                        <a class="button-primary" href="<?php echo $url; ?>"><?php _e("Tools Panel", "gd-rating-system"); ?></a>
                    </div>
                </div>

                <?php
            }
        } else {
            include(GDRTS_PATH.'forms/panels/'.$_panel.'.php');
        }

        ?>
    </div>
</form>

<?php 

include(GDRTS_PATH.'forms/shared/bottom.php');
