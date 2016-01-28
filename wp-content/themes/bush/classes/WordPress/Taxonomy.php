<?php
namespace Bush\WordPress;


class Taxonomy
{
    /**
     * @var string The name of the taxonomy.
     * Name should only contain lowercase letters and the underscore character,
     * and not be more than 32 characters long
     */
    protected $name;

    /**
     * @var array|string Name of the object type for the taxonomy object.
     * Object-types can be built-in Post Type or any Custom Post Type that may be registered.
     */
    protected $attached_to;

    /**
     * @var array An array of labels for this taxonomy.
     * By default tag labels are used for non-hierarchical types and category labels for hierarchical ones.
     *
     * <ul>
     *  <li>
     *      name - general name for the taxonomy, usually plural. The same as and overridden by $tax->label.
     *      Default is _x( 'Post Tags', 'taxonomy general name' ) or _x( 'Categories', 'taxonomy general name' ).
     *      When internationalizing this string, please use a gettext context matching your post type.
     *      Example: _x('Writers', 'taxonomy general name');
     *  </li>
     *  <li>
     *      singular_name - name for one object of this taxonomy.
     *      Default is _x( 'Post Tag', 'taxonomy singular name' ) or _x( 'Category', 'taxonomy singular name' ).
     *      When internationalizing this string, please use a gettext context matching your post type.
     *      Example: _x('Writer', 'taxonomy singular name');
     * </li>
     *  <li>
     *      menu_name - the menu name text. This string is the name to give menu items.
     *      If not set, defaults to value of name label.
     * </li>
     *  <li>all_items - the all items text. Default is __( 'All Tags' ) or __( 'All Categories' )</li>
     *  <li>edit_item - the edit item text. Default is __( 'Edit Tag' ) or __( 'Edit Category' )</li>
     *  <li>view_item - the view item text, Default is __( 'View Tag' ) or __( 'View Category' )</li>
     *  <li>update_item - the update item text. Default is __( 'Update Tag' ) or __( 'Update Category' )</li>
     *  <li>add_new_item - the add new item text. Default is __( 'Add New Tag' ) or __( 'Add New Category' )</li>
     *  <li>new_item_name - the new item name text. Default is __( 'New Tag Name' ) or __( 'New Category Name' )</li>
     *  <li>
     *      parent_item - the parent item text. This string is not used on non-hierarchical taxonomies such as post tags.
     *      Default is null or __( 'Parent Category' )
     *  </li>
     *  <li>parent_item_colon - The same as parent_item, but with colon : in the end null, __( 'Parent Category:' )</li>
     *  <li>search_items - the search items text. Default is __( 'Search Tags' ) or __( 'Search Categories' )</li>
     *  <li>
     *      popular_items - the popular items text. This string is not used on hierarchical taxonomies.
     *      Default is __( 'Popular Tags' ) or null
     *  </li>
     *  <li>
     *      separate_items_with_commas - the separate item with commas text used in the taxonomy meta box.
     *      This string is not used on hierarchical taxonomies. Default is __( 'Separate tags with commas' ), or null
     *  </li>
     *  <li>
     *      add_or_remove_items - the add or remove items text and used in the meta box when JavaScript is disabled.
     *      This string is not used on hierarchical taxonomies.
     *      Default is __( 'Add or remove tags' ) or null
     *  </li>
     *  <li>
     *      choose_from_most_used - the choose from most used text used in the taxonomy meta box.
     *      This string is not used on hierarchical taxonomies.
     *      Default is __( 'Choose from the most used tags' ) or null
     *  </li>
     *  <li>
     *      not_found (3.6+) - the text displayed via clicking 'Choose from the most used tags'
     *      in the taxonomy meta box when no tags are available and (4.2+) -
     *      the text used in the terms list table when there are no items for a taxonomy.
     *      Default is __( 'No tags found.' ) or __( 'No categories found.' )</li>
     * </ul>
     */
    protected $label;

    /**
     * @var bool If the taxonomy should be publicly queryable.
     */
    protected $public;

    /**
     * @var bool Whether to generate a default UI for managing this taxonomy
     */
    protected $show;

    /**
     * @var bool hierarchical Is this taxonomy hierarchical (have descendants) like categories or not hierarchical like tags.
     */
    protected $hierarchical;

    /**
     * @var bool Whether this taxonomy should remember the order in which terms are added to objects.
     */
    protected $sort;

    /**
     * @var bool|array Set to false to prevent automatic URL rewriting a.k.a. "pretty permalinks". Pass an $args array to override default URL settings for permalinks as outlined below
     */
    protected $rewrite = true;

    /**
     * @var array An array of the capabilities for this taxonomy.
     *
     * <b>manage_terms</b> - 'manage_categories'
     * <b>edit_terms</b> - 'manage_categories'
     * <b>delete_terms</b> - 'manage_categories'
     * <b>assign_terms</b> - 'edit_posts'
     */
    protected $capabilities;

    /**
     * Taxonomy constructor.
     * @param string $name
     * @param array|string $attached_to
     * @param array $label
     * @param bool $public
     * @param bool $show
     * @param bool $hierarchical
     * @param bool $sort
     * @param array $capabilities
     */
    public function __construct(
        $name,
        $attached_to,
        $public = true,
        $show = true,
        $hierarchical = true,
        $sort = true,
        array $capabilities = [
            'manage_terms',
            'edit_terms',
            'delete_terms',
            'assign_terms',
        ])
    {
        $this->setName($name);
        $this->setAttachedTo($attached_to);
        $this->setLabel(__(ucwords($name)));
        $this->setPublic($public);
        $this->setShow($show);
        $this->setHierarchical($hierarchical);
        $this->setSort($sort);
        $this->setCapabilities($capabilities);

        $this->register();
    }

    public function register()
    {
        add_action('init', function() {
            register_taxonomy(
                $this->name,
                $this->attached_to,
                array(
                    'label' => $this->label,
                    'public' => $this->public,
                    'show' => $this->show,
                    'hierarchical' => $this->hierarchical,
                    'sort' => $this->sort,
                    'capabilities' => $this->capabilities,
                    'rewrite' => $this->rewrite,
                )
            );
        });
    }

    public function unregister()
    {
        add_action('init', function() {
            register_taxonomy($this->name, []);
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
     * @return Taxonomy
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return array|string
     */
    public function getAttachedTo()
    {
        return $this->attached_to;
    }

    /**
     * @param array|string $attached_to
     * @return Taxonomy
     */
    public function setAttachedTo($attached_to)
    {
        $this->attached_to = $attached_to;
        return $this;
    }

    /**
     * @return array
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @param array $label
     * @return Taxonomy
     */
    public function setLabel($label)
    {
        $this->label = $label;
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
     * @return Taxonomy
     */
    public function setPublic($public)
    {
        $this->public = $public;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isShow()
    {
        return $this->show;
    }

    /**
     * @param boolean $show
     * @return Taxonomy
     */
    public function setShow($show)
    {
        $this->show = $show;
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
     * @return Taxonomy
     */
    public function setHierarchical($hierarchical)
    {
        $this->hierarchical = $hierarchical;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isSort()
    {
        return $this->sort;
    }

    /**
     * @param boolean $sort
     * @return Taxonomy
     */
    public function setSort($sort)
    {
        $this->sort = $sort;
        return $this;
    }

    /**
     * @return array
     */
    public function getCapabilities()
    {
        return $this->capabilities;
    }

    /**
     * @param array $capabilities
     * @return Taxonomy
     */
    public function setCapabilities($capabilities)
    {
        $this->capabilities = $capabilities;
        return $this;
    }


    /**
     * @return bool|array
     */
    public function getRewrite()
    {
        return $this->rewrite;
    }

    /**
     * @param bool|array $rewrite
     * @return Taxonomy
     */
    public function setRewrite($rewrite)
    {
        $this->name = $rewrite;
        return $this;
    }

}