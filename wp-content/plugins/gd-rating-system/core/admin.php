<?php

if (!defined('ABSPATH')) exit;

class gdrts_admin_core extends d4p_admin_core {
    public $plugin = 'gd-rating-system';

    function __construct() {
        parent::__construct();

        $this->url = GDRTS_URL;

        add_action('gdrts_load', array(&$this, 'core'));
        add_filter('set-screen-option', array(&$this, 'screen_options_grid_rows_save'), 10, 3);
        add_filter('gdrts_load_admin_page_log', array(&$this, 'help_log'));
    }

    public function admin_meta() {
        if (current_user_can('edit_posts')) {
            $post_types = get_post_types(array('public' => true), 'objects');

            foreach (array_keys($post_types) as $post_type) {
                add_meta_box('gdrts-metabox', __("GD Rating System", "gd-rating-system"), array(&$this, 'metabox_post'), $post_type, 'normal', 'high');
                add_action('save_post_'.$post_type, array(&$this, 'metabox_post_save'), 10, 3);
            }
        }
    }

    public function metabox_post_save($post_id, $post, $update) {
        if (isset($_POST['gdrts'])) {
            do_action('gdrts_admin_metabox_save_post', $post);
        }
    }

    public function metabox_post() {
        global $post_ID;

        if (current_user_can('edit_post', $post_ID)) {
            include(GDRTS_PATH.'forms/meta/post.php');
        } else {
            _e("You don't have rights to control these settings", "gd-rating-system");
        }
    }

    public function screen_options_grid_rows_save($status, $option, $value) {
        if ($option == 'gdrts_rows_per_page_ratings') {
            return $value;
        }

        if ($option == 'gdrts_rows_per_page_votes') {
            return $value;
        }

        return $status;
    }

    public function screen_options_grid_rows_ratings() {
        $args = array(
            'label' => __("Rows", "gd-rating-system"),
            'default' => 25,
            'option' => 'gdrts_rows_per_page_ratings'
        );

        add_screen_option('per_page', $args);

        require_once(GDRTS_PATH.'core/grids/ratings.php');

        $load_table = new gdrts_grid_ratings();
    }

    public function screen_options_grid_rows_votes() {
        $args = array(
            'label' => __("Rows", "gd-rating-system"),
            'default' => 25,
            'option' => 'gdrts_rows_per_page_votes'
        );

        add_screen_option('per_page', $args);

        require_once(GDRTS_PATH.'core/grids/votes.php');

        $load_table = new gdrts_grid_votes();
    }

    public function core() {
        parent::core();

        $this->init_ready();

        if (gdrts_settings()->is_install()) {
            add_action('admin_notices', array(&$this, 'install_notice'));
        }
    }

    public function install_notice() {
        if (current_user_can('install_plugins') && $this->page === false) {
            echo '<div class="updated"><p>';
            echo __("GD Rating System is activated and it needs to finish installation.", "gd-rating-system");
            echo ' <a href="admin.php?page=gd-rating-system-front">'.__("Click Here", "gd-rating-system").'</a>.';
            echo '</p></div>';
        }
    }

    public function init_ready() {
        $this->menu_items = array(
            'front' => array('title' => __("Overview", "gd-rating-system"), 'icon' => 'home'),
            'about' => array('title' => __("About", "gd-rating-system"), 'icon' => 'info-circle'),
            'settings' => array('title' => __("Settings", "gd-rating-system"), 'icon' => 'cogs'),
            'rules' => array('title' => __("Rules", "gd-rating-system"), 'icon' => 'star-o'),
            'ratings' => array('title' => __("Ratings Items", "gd-rating-system"), 'icon' => 'star-half-o'),
            'log' => array('title' => __("Votes Log", "gd-rating-system"), 'icon' => 'file-text-o'),
            'transfer' => array('title' => __("Transfer Data", "gd-rating-system"), 'icon' => 'exchange'),
            'information' => array('title' => __("Information", "gd-rating-system"), 'icon' => 'info-circle'),
            'tools' => array('title' => __("Tools", "gd-rating-system"), 'icon' => 'wrench')
        );
    }

    public function admin_init() {
        do_action('gdrts_admin_load_modules');

        d4p_include('grid', 'classes', GDRTS_D4PLIB);

        if (isset($_GET['panel']) && $_GET['panel'] != '') {
            $this->panel = trim($_GET['panel']);
        }

        if (isset($_POST['gdrts_handler']) && $_POST['gdrts_handler'] == 'postback') {
            require_once(GDRTS_PATH.'core/admin/postback.php');

            $postback = new gdrts_admin_postback();
        }

        do_action('gdrts_admin_init');
    }

    public function admin_menu() {
        $parent = 'gd-rating-system-front';

        $icon = 'dashicons-star-filled';

        $this->page_ids[] = add_menu_page(
                        'GD Rating System', 
                        'Rating System', 
                        GDRTS_CAP, 
                        $parent, 
                        array(&$this, 'panel_front'), 
                        $icon);

        foreach($this->menu_items as $item => $data) {
            $this->page_ids[] = add_submenu_page($parent, 
                            'GD Rating System: '.$data['title'], 
                            $data['title'], 
                            GDRTS_CAP, 
                            'gd-rating-system-'.$item, 
                            array(&$this, 'panel_'.$item));
        }

        $this->admin_load_hooks();
    }

    public function enqueue_scripts($hook) {
        $load_admin_data = false;

        if ($this->page !== false) {
            d4p_admin_enqueue_defaults();

            wp_enqueue_style('fontawesome', GDRTS_URL.'d4plib/resources/fontawesome/css/font-awesome.min.css');

            wp_enqueue_style('d4plib-font', $this->file('css', 'font', true), array(), D4P_VERSION);
            wp_enqueue_style('d4plib-shared', $this->file('css', 'shared', true), array(), D4P_VERSION);
            wp_enqueue_style('d4plib-admin', $this->file('css', 'admin', true), array('d4plib-shared'), D4P_VERSION);

            wp_enqueue_script('d4plib-shared', $this->file('js', 'shared', true), array('jquery', 'wp-color-picker'), D4P_VERSION, true);
            wp_enqueue_script('d4plib-admin', $this->file('js', 'admin', true), array('d4plib-shared'), D4P_VERSION, true);

            wp_enqueue_style('gdrts-plugin', $this->file('css', 'plugin'), array('d4plib-admin'), gdrts_settings()->info_version);
            wp_enqueue_script('gdrts-plugin', $this->file('js', 'plugin'), array('d4plib-admin'), gdrts_settings()->info_version, true);

            do_action('gdrts_admin_enqueue_scripts', $this->page);

            $_data = array(
                'nonce' => wp_create_nonce('gdrts-admin-internal'),
                'wp_version' => GDRTS_WPV,
                'page' => $this->page,
                'panel' => $this->panel,
                'dialog_title_areyousure' => __("Are you sure you want to do this?", "gd-rating-system"),
                'dialog_content_pleasewait' => __("Please Wait...", "gd-rating-system")
            );

            if ($this->page == 'tools') {
                $_data['button_stop'] = __("Stop Process", "gd-rating-system");
                $_data['dialog_nothing'] = __("Nothing is selected, process will not start.", "gd-rating-system");
            }

            wp_localize_script('gdrts-plugin', 'gdrts_data', $_data);

            $load_admin_data = true;
        }

        if ($hook == 'post.php' || $hook == 'post-new.php') {
            wp_enqueue_media();

            wp_enqueue_style('d4plib-shared', $this->file('css', 'shared', true), array(), D4P_VERSION);
            wp_enqueue_style('d4plib-metabox', $this->file('css', 'meta', true), array('d4plib-shared'), D4P_VERSION);

            wp_enqueue_script('d4plib-shared', $this->file('js', 'shared', true), array('jquery', 'wp-color-picker'), D4P_VERSION, true);
            wp_enqueue_script('d4plib-metabox', $this->file('js', 'meta', true), array('d4plib-shared'), D4P_VERSION, true);

            wp_enqueue_style('gdrts-metabox', $this->file('css', 'meta'), array('d4plib-metabox'), gdrts_settings()->info_version);

            $load_admin_data = true;
        }

        if ($hook == 'widgets.php') {
            wp_enqueue_style('d4plib-widgets', $this->file('css', 'widgets', true), array(), D4P_VERSION);
            wp_enqueue_script('d4plib-widgets', $this->file('js', 'widgets', true), array('jquery'), D4P_VERSION, true);
        }

        if ($load_admin_data) {
            wp_localize_script('d4plib-shared', 'd4plib_admin_data', array(
                'string_media_image_title' => __("Select Image", "gd-rating-system"),
                'string_media_image_button' => __("Use Selected Image", "gd-rating-system"),
                'string_are_you_sure' => __("Are you sure you want to do this?", "gd-rating-system"),
                'string_image_not_selected' => __("Image not selected.", "gd-rating-system")
            ));
        }
    }

    public function admin_load_hooks() {
        foreach ($this->page_ids as $id) {
            add_action('load-'.$id, array(&$this, 'load_admin_page'));
        }

        add_action('load-rating-system_page_gd-rating-system-ratings', array(&$this, 'screen_options_grid_rows_ratings'));
        add_action('load-rating-system_page_gd-rating-system-log', array(&$this, 'screen_options_grid_rows_votes'));
    }

    public function load_admin_page() {
        $screen = get_current_screen();
        $id = $screen->id;

        if ($id == 'toplevel_page_gd-rating-system-front') {
            $this->page = 'front';
        } else if (substr($id, 0, 36) == 'rating-system_page_gd-rating-system-') {
            $this->page = substr($id, 36);
        }

        if ($this->page && isset($_GET['gdrts_handler']) && $_GET['gdrts_handler'] == 'getback') {
            require_once(GDRTS_PATH.'core/admin/getback.php');

            $getback = new gdrts_admin_getback();
        }

        $this->help_tab_sidebar('gd-rating-system', 'GD Rating System');

        do_action('gdrts_load_admin_page_'.$this->page);

        if ($this->panel !== false && $this->panel != '') {
            do_action('gdrts_load_admin_page_'.$this->page.'_'.$this->panel);
        }

        $this->help_tab_getting_help('gd-rating-system');
    }

    public function help_log() {
        $screen = get_current_screen();

        $render = '<p>'.__("Here are few important pointers about this panel. Make sure you understand the limitations and basic rules for using this panel.", "gd-rating-system").'</p>';

        $render.= '<ul>';
        $render.= '<li>'.__("Deleting votes from the log will recalculate object ratings. If you delete one vote, plugin will take previous vote by the user for the object, if available. This way it is undoing the revoting.", "gd-rating-system").'</li>';
        $render.= '<li>'.__("It is not recommended to use 'Remove from Log' option because it will just remove log entry, it will not recaulcaulte object rating. If you don't understand this option, do not use it. This option is disabled by default, and it can be enabled from plugin settings.", "gd-rating-system").'</li>';
        $render.= '<li>'.__("If log takes too long to load, disable GEO Location flags for votes IP's from plugin settings.", "gd-rating-system").'</li>';
        $render.= '<li>'.__("Do not mess with votes log in database directly, or you might delete something that will cause problems to the way plugin works.", "gd-rating-system").'</li>';
        $render.= '</ul>';

        $screen->add_help_tab(
            array(
                'id' => 'gdseo-help-log',
                'title' => __("Votes Log", "gd-rating-system"),
                'content' => $render
            )
        );
    }

    public function title() {
        return 'GD Rating System';
    }

    public function install_or_update() {
        $install = gdrts_settings()->is_install();
        $update = gdrts_settings()->is_update();

        if ($install) {
            include(GDRTS_PATH.'forms/install.php');
        } else if ($update) {
            include(GDRTS_PATH.'forms/update.php');
        }

        return $install || $update;
    }

    public function panel_front() {
        if (!$this->install_or_update()) {
            include(GDRTS_PATH.'forms/front.php');
        }
    }

    public function panel_about() {
        if (!$this->install_or_update()) {
            include(GDRTS_PATH.'forms/about.php');
        }
    }

    public function panel_settings() {
        if (!$this->install_or_update()) {
            include(GDRTS_PATH.'forms/settings.php');
        }
    }

    public function panel_rules() {
        if (!$this->install_or_update()) {
            if (isset($_GET['action']) && $_GET['action'] == 'rule') {
                include(GDRTS_PATH.'forms/rule.php');
            } else {
                include(GDRTS_PATH.'forms/rules.php');
            }
        }
    }

    public function panel_ratings() {
        if (!$this->install_or_update()) {
            include(GDRTS_PATH.'forms/ratings.php');
        }
    }

    public function panel_log() {
        if (!$this->install_or_update()) {
            include(GDRTS_PATH.'forms/log.php');
        }
    }

    public function panel_transfer() {
        if (!$this->install_or_update()) {
            include(GDRTS_PATH.'forms/transfer.php');
        }
    }

    public function panel_information() {
        if (!$this->install_or_update()) {
            include(GDRTS_PATH.'forms/information.php');
        }
    }

    public function panel_tools() {
        if (!$this->install_or_update()) {
            include(GDRTS_PATH.'forms/tools.php');
        }
    }
}

global $_gdrts_core_admin;
$_gdrts_core_admin = new gdrts_admin_core();

function gdrts_admin() {
    global $_gdrts_core_admin;
    return $_gdrts_core_admin;
}

