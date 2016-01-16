<?php

include(GDRTS_PATH.'forms/shared/top.php');

$_status = isset($_GET['status']) && !empty($_GET['status']) ? $_GET['status'] : '';

?>

<div class="d4p-content-right d4p-content-full">
    <form method="get" action="">
        <input type="hidden" name="page" value="gd-rating-system-log" />
        <input type="hidden" value="getback" name="gdrts_handler" />
        <input type="hidden" value="<?php echo $_status; ?>" name="status" />

        <?php

        require_once(GDRTS_PATH.'core/grids/votes.php');

        $_grid = new gdrts_grid_votes();
        $_grid->prepare_items();
        $_grid->views();
        $_grid->display();

        ?>
    </form>
</div>

<?php 

include(GDRTS_PATH.'forms/shared/bottom.php');
include(GDRTS_PATH.'forms/dialogs/log.php');
