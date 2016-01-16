<?php

do_action('gdrts_admin_panel_top');

$pages = gdrts_admin()->menu_items;
$_page = gdrts_admin()->page;
$_panel = gdrts_admin()->panel;

if (!empty($panels) && $_panel === false) {
    $_panel = 'index';
}

$_classes = array('d4p-wrap', 'wpv-'.GDRTS_WPV, 'd4p-page-'.$_page);

if ($_panel !== false) {
    $_classes[] = 'd4p-panel';
    $_classes[] = 'd4p-panel-'.$_panel;
}

$_message = '';
$_color = '';

if (isset($_GET['message']) && $_GET['message'] != '') {
    switch ($_GET['message']) {
        case 'saved':
            $_message = __("Settings are saved.", "gd-rating-system");
            break;
        case 'rule-removed':
            $_message = __("Rule removal operation completed.", "gd-rating-system");
            break;
        case 'removed':
            $_message = __("Removal operation completed.", "gd-rating-system");
            break;
        case 'imported':
            $_message = __("Import operation completed.", "gd-rating-system");
            break;
        case 'transfer-failed':
            $_message = __("Invalid transfer configuration. Transfer failed.", "gd-rating-system");
            $_color = 'error';
            break;
        case 'transfered':
            $_message = __("Data transfer completed.", "gd-rating-system");
            break;
        case 'nothing':
            $_message = __("Nothing done.", "gd-rating-system");
            break;
    }
}

?>
<div class="<?php echo join(' ', $_classes); ?>">
    <div class="d4p-header">
        <div class="d4p-navigator">
            <ul>
                <li class="d4p-nav-button">
                    <a href="#"><i class="fa fa-<?php echo $pages[$_page]['icon']; ?>"></i> <?php echo $pages[$_page]['title']; ?></a>
                    <ul>
                        <?php

                        foreach ($pages as $page => $obj) {
                            if ($page != $_page) {
                                echo '<li><a href="admin.php?page=gd-rating-system-'.$page.'"><i class="'.(d4p_icon_class($obj['icon'], 'fw')).'"></i> '.$obj['title'].'</a></li>';
                            } else {
                                echo '<li class="d4p-nav-current"><i class="'.(d4p_icon_class($obj['icon'], 'fw')).'"></i> '.$obj['title'].'</li>';
                            }
                        }

                        ?>
                    </ul>
                </li>
                <?php if (!empty($panels)) { ?>
                <li class="d4p-nav-button">
                    <a href="#"><i class="<?php echo d4p_icon_class($panels[$_panel]['icon']); ?>"></i> <?php echo $panels[$_panel]['title']; ?></a>
                    <ul>
                        <?php

                        foreach ($panels as $panel => $obj) {
                            if ($panel != $_panel) {
                                echo '<li><a href="admin.php?page=gd-rating-system-'.$_page.'&panel='.$panel.'"><i class="'.(d4p_icon_class($obj['icon'], 'fw')).'"></i> '.$obj['title'].'</a></li>';
                            } else {
                                echo '<li class="d4p-nav-current"><i class="'.(d4p_icon_class($obj['icon'], 'fw')).'"></i> '.$obj['title'].'</li>';
                            }
                        }

                        ?>
                    </ul>
                </li>
                <?php } ?>
            </ul>
        </div>
        <div class="d4p-plugin">
            GD Rating System
        </div>
    </div>
    <?php

    if ($_message != '') {
        echo '<div class="updated">'.$_message.'</div>';
    }

    ?>
    <div class="d4p-content">
