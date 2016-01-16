<?php

$panels = array(
    'index' => array(
        'title' => __("Settings Index", "gd-rating-system"), 'icon' => 'cogs', 
        'info' => __("All plugin settings are split into panels, and you access each starting from the right.", "gd-rating-system")),
    'extensions' => array(
        'title' => __("Extensions", "gd-rating-system"), 'icon' => 'puzzle-piece', 
        'info' => __("From this panel you can disable and enable individual plugin addons and rating methods.", "gd-rating-system")),
    'global' => array(
        'title' => __("Global", "gd-rating-system"), 'icon' => 'cog', 
        'info' => __("All plugin settings are split into panels, and you access each starting from the right.", "gd-rating-system")),
    'administration' => array(
        'title' => __("Administration", "gd-rating-system"), 'icon' => 'dashboard', 
        'info' => __("All plugin settings are split into panels, and you access each starting from the right.", "gd-rating-system")),
    'advanced' => array(
        'title' => __("Advanced", "gd-rating-system"), 'icon' => 'cog', 
        'info' => __("All plugin settings are split into panels, and you access each starting from the right.", "gd-rating-system"))
);

$panels = apply_filters('gdrts_admin_settings_panels', $panels);

include(GDRTS_PATH.'forms/shared/top.php');

?>

<form method="post" action="">
    <?php settings_fields('gd-rating-system-settings'); ?>
    <input type="hidden" value="postback" name="gdrts_handler" />

    <div class="d4p-content-left">
        <div class="d4p-panel-scroller d4p-scroll-active">
            <div class="d4p-panel-title">
                <i class="fa fa-cogs"></i>
                <h3><?php _e("Settings", "gd-rating-system"); ?></h3>
                <?php if ($_panel != 'index') { ?>
                <h4><i class="fa fa-<?php echo $panels[$_panel]['icon']; ?>"></i> <?php echo $panels[$_panel]['title']; ?></h4>
                <?php } ?>
            </div>
            <div class="d4p-panel-info">
                <?php echo $panels[$_panel]['info']; ?>
            </div>
            <?php if ($_panel != 'index') { ?>
                <div class="d4p-panel-buttons">
                    <input type="submit" value="<?php _e("Save Settings", "gd-rating-system"); ?>" class="button-primary">
                </div>
                <div class="d4p-return-to-top">
                    <a href="#wpwrap"><?php _e("Return to top", "gd-rating-system"); ?></a>
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
                        <?php if (isset($obj['type'])) { ?>
                        <span><?php echo $obj['type']; ?></span>
                        <?php } ?>
                        <a class="button-primary" href="<?php echo $url; ?>"><?php _e("Settings Panel", "gd-rating-system"); ?></a>
                    </div>
                </div>
        
                <?php
            }
        } else {
            require_once(GDRTS_PATH.'d4plib/admin/d4p.functions.php');
            require_once(GDRTS_PATH.'d4plib/admin/d4p.settings.php');

            include(GDRTS_PATH.'core/internal.php');

            $options = new gdrts_admin_settings();

            $panel = gdrts_admin()->panel;
            $groups = $options->get($panel);

            $render = new d4pSettingsRender($panel, $groups);
            $render->base = 'gdrtsvalue';
            $render->render();
        }

        ?>
    </div>
</form>

<?php 

include(GDRTS_PATH.'forms/shared/bottom.php');

