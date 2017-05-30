<?php
namespace Bush\WordPress;


class PostType
{
    /**
     * @var string Post type. (max. 20 characters, cannot contain capital letters or spaces)
     */
    protected $name;

    /**
     * @var string A singular descriptive name for the post type marked for translation.
     */
    protected $singular_name;

    /**
     * @var string A plural descriptive name for the post type marked for translation.
     */
    protected $plural_name;

    /**
     * @var array labels - An array of labels for this post type. By default,
     * post labels are used for non-hierarchical post types and page labels for hierarchical ones.
     *
     * <ul>
     * <li>name - general name for the post type, usually plural. The same as, and overridden by $post_type_object->label</li>
     * <li>singular_name - name for one object of this post type. Defaults to value of 'name'.</li>
     * <li>menu_name - the menu name text. This string is the name to give menu items. Defaults to a value of 'name'.</li>
     * <li>
     *  name_admin_bar - name given for the "Add New" dropdown on admin bar.
     *  Defaults to 'singular_name' if it exists, 'name' otherwise.
     * </li>
     * <li>all_items - the all items text used in the menu. Default is the value of 'name'.</li>
     * <li>
     *  add_new - the add new text. The default is "Add New" for both hierarchical and non-hierarchical post types.
     *  When internationalizing this string, please use a gettext context matching your post type.
     *  Example: _x('Add New', 'product');
     * </li>
     * <li>add_new_item - the add new item text. Default is Add New Post/Add New Page</li>
     * <li>
     *  edit_item - the edit item text. In the UI, this label is used as the main header on the post's editing panel.
        * The default is "Edit Post" for non-hierarchical and "Edit Page" for hierarchical post types.
     * </li>
     * <li>new_item - the new item text. Default is "New Post" for non-hierarchical and "New Page" for hierarchical post types.</li>
     * <li>view_item - the view item text. Default is View Post/View Page</li>
     * <li>search_items - the search items text. Default is Search Posts/Search Pages</li>
     * <li>not_found - the not found text. Default is No posts found/No pages found</li>
     * <li>not_found_in_trash - the not found in trash text. Default is No posts found in Trash/No pages found in Trash.</li>
     * <li>parent_item_colon - the parent text. This string is used only in hierarchical post types. Default is "Parent Page".</li>
     * </ul>
     */
    protected $labels;

    /**
     * @var string A short descriptive summary of what the post type is.
     */
    protected $description;

    /**
     * @var bool Controls how the type is visible to authors (show_in_nav_menus, show_ui)
     * and readers (exclude_from_search, publicly_queryable).
     *
     * <b>true</b> - Implies exclude_from_search: false, publicly_queryable: true, show_in_nav_menus: true, and show_ui:true.
     * The built-in types attachment, page, and post are similar to this.
     *
     * <b>false</b> - Implies exclude_from_search: true, publicly_queryable: false, show_in_nav_menus: false, and show_ui: false.
     * The built-in types nav_menu_item and revision are similar to this.
     * Best used if you'll provide your own editing and viewing interfaces (or none at all).
     */
    protected $public;

    /**
     * @var bool Whether to exclude posts with this post type from front end search results.
     *
     * <b>true</b> - site/?s=search-term will not include posts of this post type.
     * <b>false</b> - site/?s=search-term will include posts of this post type.
     *
     * <b>Note:</b> If you want to show the posts's list that are associated to taxonomy's terms,
     * you must set exclude_from_search to false
     * (ie : for call site_domaine/?taxonomy_slug=term_slug or site_domaine/taxonomy_slug/term_slug).
     * If you set to true, on the taxonomy page (ex: taxonomy.php)
     * WordPress will not find your posts and/or pagination will make 404 error...
     */
    protected $exclude_from_search;

    /**
     * @var bool Whether queries can be performed on the front end as part of parse_request().
     *
     * <b>Note:</b> The queries affected include the following (also initiated when rewrites are handled)
     * ?post_type={post_type_key}
     * ?{post_type_key}={single_post_slug}
     * ?{post_type_query_var}={single_post_slug}
     *
     * <b>Note:</b> If query_var is empty, null, or a boolean FALSE, WordPress will still attempt to interpret it (4.2.2) and previews/views of your custom post will return 404s.
     */
    protected $publicly_queryable;

    /**
     * @var bool Whether to generate a default UI for managing this post type in the admin.
     *
     * <b>false</b> - do not display a user-interface for this post type
     * <b>true</b> - display a user-interface (admin panel) for this post type
     *
     * <b>Note:</b> _built-in post types, such as post and page, are intentionally set to false.
     */
    protected $show_ui;

    /**
     * @var bool Whether post_type is available for selection in navigation menus.
     */
    protected $show_in_nav_menus;

    /**
     * @var bool Whether to make this post type available in the WordPress admin bar.
    Default: value of the show_in_menu argument
     */
    protected $show_in_admin_bar;

    /**
     * @var int The position in the menu order the post type should appear. show_in_menu must be true.
     */
    protected $menu_position;

    /**
     * @var string The url to the icon to be used for this menu or the name of the icon from the iconfont [1]
     */
    protected $menu_icon;

    /**
     * @var string|array The string to use to build the read, edit, and delete capabilities.
     * May be passed as an array to allow for alternative plurals when using this argument as a base to construct
     * the capabilities, e.g. array('story', 'stories')
     * the first array element will be used for the singular capabilities and the second array element for
     * the plural capabilities, this is instead of the auto generated version if no array is given which would be "storys".
     * The 'capability_type' parameter is used as a base to construct capabilities unless they are explicitly
     * set with the 'capabilities' parameter.
     * It seems that `map_meta_cap` needs to be set to false or null, to make this work
     */
    protected $capabilities;

    /**
     * @var bool Whether to use the internal default meta capability handling.
     */
    protected $map_meta_cap;

    /**
     * @var bool Whether the post type is hierarchical (e.g. page).
     * Allows Parent to be specified. The 'supports' parameter should contain 'page-attributes' to show the parent select box on the editor page.
     */
    protected $hierarchical;

    /**
     * @var array|bool An alias for calling add_post_type_support() directly.
     * As of 3.5, boolean false can be passed as value instead of an array to prevent default (title and editor) behavior.
     * <ul>
     *  <li>title</li>
     * <li>editor (content)</li>
     * <li>author</li>
     * <li>thumbnail (featured image, current theme must also support post-thumbnails)</li>
     * <li>excerpt</li>
     * <li>trackback</li>
     * <li>custom-fields</li>
     * <li>comments (also will see comment count balloon on edit screen)</li>
     * <li>revisions (will store revisions)</li>
     * <li>page-attributes (menu order, hierarchical must be true to show Parent option)</li>
     * <li>post-formats add post formats, see Post Formats</li>
     * </ul>
     */
    protected $supports;

    /**
     * @var bool|string Enables post type archives. Will use $post_type as archive slug by default.
     */
    protected $has_archive;

    /**
     * @var bool|array Triggers the handling of rewrites for this post type. To prevent rewrites, set to false.
     *
     * <ul>
     *  <li>slug - string Customize the permalink structure slug. Defaults to the $post_type value. Should be translatable.</li>
     * <li>
     *  with_front - bool Should the permalink structure be prepended with the front base.
     *  (example: if your permalink structure is /blog/, then your links will be: false->/news/, true->/blog/news/).
     *  Defaults to true
     * </li>
     * <li>feeds - bool Should a feed permalink structure be built for this post type. Defaults to has_archive value.</li>
     * <li>pages - bool Should the permalink structure provide for pagination. Defaults to true</li>
     * </ul>
     */
    protected $rewrite;

    /**
     * @var bool|string Sets the query_var key for this post type.
     *
     * <b>false</b> - Disables query_var key use. A post type cannot be loaded at /?{query_var}={single_post_slug}
     * <b>string</b> - /?{query_var_string}={single_post_slug} will work as intended.
     */
    protected $query_var;

    /**
     * PostType constructor.
     * @param string $name
     * @param string $singular_name
     * @param string $plural_name
     * @param string $description
     * @param bool $public
     * @param bool $show_ui
     * @param bool $map_meta_cap
     * @param bool $hierarchical
     * @param array|bool $supports
     * @param bool|string $has_archive
     */
    public function __construct($name, $singular_name, $plural_name, $description = '', $public = true, $show_ui = true, $map_meta_cap = true, $hierarchical = false, $supports = ['title', 'editor'], $has_archive = true)
    {
        $this->name = $name;
        $this->singular_name = $singular_name;
        $this->plural_name = $plural_name;
        $this->description = $description;
        $this->public = $public;
        $this->show_ui = $show_ui;
        $this->map_meta_cap = $map_meta_cap;
        $this->hierarchical = $hierarchical;
        $this->supports = $supports;
        $this->has_archive = $has_archive;
        $this->labels = [
            'name'               => _x($plural_name, 'post type general name'),
            'singular_name'      => _x($singular_name, 'post type singular name'),
            'menu_name'          => _x($plural_name, 'admin menu'),
            'name_admin_bar'     => _x($singular_name, 'add new on admin bar'),
            'add_new'            => _x('Add New', $singular_name),
            'add_new_item'       => __('Add New ' . $singular_name),
            'new_item'           => __('New ' . $singular_name),
            'edit_item'          => __('Edit ' . $singular_name),
            'view_item'          => __('View ' . $singular_name),
            'all_items'          => __('All ' . $plural_name),
            'search_items'       => __('Search ' . $plural_name),
            'parent_item_colon'  => __('Parent ' . $plural_name . ':'),
            'not_found'          => __('No ' . $plural_name . ' found.'),
            'not_found_in_trash' => __('No ' . $plural_name . ' found in Trash.'),
        ];
    }

    public function register()
    {
        $args = [
            'labels' => $this->labels,
            'description' => __($this->description),
            'public' => $this->public,
            'has_archive' => $this->has_archive,
            'show_ui' => $this->show_ui,
            'hierarchical' => $this->hierarchical,
            'supports' => $this->supports,
            'map_meta_cap' => $this->map_meta_cap,
            'menu_icon' => $this->menu_icon,
        ];
        add_action('init', function() use($args) {
            register_post_type($this->name, $args);
        });
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return PostType
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getSingularName()
    {
        return $this->singular_name;
    }

    /**
     * @param string $singular_name
     * @return PostType
     */
    public function setSingularName($singular_name)
    {
        $this->singular_name = $singular_name;
        return $this;
    }

    /**
     * @return string
     */
    public function getPluralName()
    {
        return $this->plural_name;
    }

    /**
     * @param string $plural_name
     * @return PostType
     */
    public function setPluralName($plural_name)
    {
        $this->plural_name = $plural_name;
        return $this;
    }

    /**
     * @return array
     */
    public function getLabels()
    {
        return $this->labels;
    }

    /**
     * @param array $labels
     * @return PostType
     */
    public function setLabels($labels)
    {
        $this->labels = $labels;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return PostType
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isPublic()
    {
        return $this->public;
    }

    /**
     * @param boolean $public
     * @return PostType
     */
    public function setPublic($public)
    {
        $this->public = $public;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isExcludeFromSearch()
    {
        return $this->exclude_from_search;
    }

    /**
     * @param boolean $exclude_from_search
     * @return PostType
     */
    public function setExcludeFromSearch($exclude_from_search)
    {
        $this->exclude_from_search = $exclude_from_search;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isPubliclyQueryable()
    {
        return $this->publicly_queryable;
    }

    /**
     * @param boolean $publicly_queryable
     * @return PostType
     */
    public function setPubliclyQueryable($publicly_queryable)
    {
        $this->publicly_queryable = $publicly_queryable;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isShowUi()
    {
        return $this->show_ui;
    }

    /**
     * @param boolean $show_ui
     * @return PostType
     */
    public function setShowUi($show_ui)
    {
        $this->show_ui = $show_ui;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isShowInNavMenus()
    {
        return $this->show_in_nav_menus;
    }

    /**
     * @param boolean $show_in_nav_menus
     * @return PostType
     */
    public function setShowInNavMenus($show_in_nav_menus)
    {
        $this->show_in_nav_menus = $show_in_nav_menus;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isShowInAdminBar()
    {
        return $this->show_in_admin_bar;
    }

    /**
     * @param boolean $show_in_admin_bar
     * @return PostType
     */
    public function setShowInAdminBar($show_in_admin_bar)
    {
        $this->show_in_admin_bar = $show_in_admin_bar;
        return $this;
    }

    /**
     * @return int
     */
    public function getMenuPosition()
    {
        return $this->menu_position;
    }

    /**
     * @param int $menu_position
     * @return PostType
     */
    public function setMenuPosition($menu_position)
    {
        $this->menu_position = $menu_position;
        return $this;
    }

    /**
     * @return string
     */
    public function getMenuIcon()
    {
        return $this->menu_icon;
    }

    /**
     * @param string $menu_icon
     * @return PostType
     */
    public function setMenuIcon($menu_icon)
    {
        $this->menu_icon = $menu_icon;
        return $this;
    }

    /**
     * @return array|string
     */
    public function getCapabilities()
    {
        return $this->capabilities;
    }

    /**
     * @param array|string $capabilities
     * @return PostType
     */
    public function setCapabilities($capabilities)
    {
        $this->capabilities = $capabilities;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isMapMetaCap()
    {
        return $this->map_meta_cap;
    }

    /**
     * @param boolean $map_meta_cap
     * @return PostType
     */
    public function setMapMetaCap($map_meta_cap)
    {
        $this->map_meta_cap = $map_meta_cap;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isHierarchical()
    {
        return $this->hierarchical;
    }

    /**
     * @param boolean $hierarchical
     * @return PostType
     */
    public function setHierarchical($hierarchical)
    {
        $this->hierarchical = $hierarchical;
        return $this;
    }

    /**
     * @return array|bool
     */
    public function getSupports()
    {
        return $this->supports;
    }

    /**
     * @param array|bool $supports
     * @return PostType
     */
    public function setSupports($supports)
    {
        $this->supports = $supports;
        return $this;
    }

    /**
     * @return bool|string
     */
    public function getHasArchive()
    {
        return $this->has_archive;
    }

    /**
     * @param bool|string $has_archive
     * @return PostType
     */
    public function setHasArchive($has_archive)
    {
        $this->has_archive = $has_archive;
        return $this;
    }

    /**
     * @return array|bool
     */
    public function getRewrite()
    {
        return $this->rewrite;
    }

    /**
     * @param array|bool $rewrite
     * @return PostType
     */
    public function setRewrite($rewrite)
    {
        $this->rewrite = $rewrite;
        return $this;
    }

    /**
     * @return bool|string
     */
    public function getQueryVar()
    {
        return $this->query_var;
    }

    /**
     * @param bool|string $query_var
     * @return PostType
     */
    public function setQueryVar($query_var)
    {
        $this->query_var = $query_var;
        return $this;
    }

}