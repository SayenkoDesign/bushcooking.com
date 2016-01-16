<?php

$_tab = $instance['_tab'];

?>

<div class="d4plib-widget gdrts-widget">
    <div class="d4plib-widget-tabs">
        <input class="d4plib-widget-active-tab" value="<?php echo $_tab; ?>" id="<?php echo $this->get_field_id('_tab'); ?>" name="<?php echo $this->get_field_name('_tab'); ?>" type="hidden" />
        <?php

        foreach ($_tabs as $tab => $obj) {
            $class = 'd4plib-widget-tab d4plib-tabname-'.$tab;

            if (isset($obj['class'])) {
                $class.= ' '.$obj['class'];
            }

            if ($tab == $_tab) {
                $class.= ' d4plib-tab-active';
            }

            echo '<a href="#'.$tab.'" class="'.$class.'">'.$obj['name'].'</a>';
        }

        ?>
    </div>
    <div class="d4plib-widget-tabs-content">
        <?php

        $first = true;
        foreach ($_tabs as $tab => $obj) {
            $class = 'd4plib-tab-content d4plib-tabname-'.$tab;

            if (isset($obj['class'])) {
                $class.= ' '.$obj['class'];
            }

            if ($tab == $_tab) {
                $class.= ' d4plib-content-active';
            }

            echo '<div class="'.$class.'">';

            foreach ($obj['include'] as $inc) {
                include(GDRTS_PATH.'forms/widgets/'.$inc.'.php');
            }

            echo '</div>';
        }

        ?>
    </div>
</div>