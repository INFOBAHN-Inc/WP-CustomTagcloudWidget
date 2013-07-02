<?php
/*
Plugin Name: Custom Tag Cloud
Description: タグクラウドのカスタマイズ
Author: s.ashiakwa
Version: 0.1
*/

/**
 * Custom_Walker_Category_Checklist
 * 管理画面の Form チェックリスト出力
 *
 * @package WordPress
 * @subpackage custom-tag-cloud
 * @author s.ashiakwa
 */
class Custom_Walker_Category_Checklist extends Walker
{
    /**
     * @var string
     */
    public $tree_type = "category";

    /**
     * @var array
     */
    public $db_fields = array("parent" => "parent", "id" => "term_id");

    /**
     * @var string
     */
    protected $_name = "";

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->_name = $name;
    }

    /**
     * @see Walker::start_lvl()
     * @param string &$output
     * @param int   $depth
     * @param array $args
     */
    public function start_lvl(&$output, $depth = 0, $args = array())
    {
        $indent  = str_repeat("\t", $depth);
        $output .= $indent . '<ul class="children">';
    }

    /**
     * @see Walker::end_lvl()
     * @param string &$output
     * @param int   $depth
     * @param array $args
     */
    public function end_lvl(&$output, $depth = 0, $args = array())
    {
        $indent = str_repeat("\t", $depth);
        $output .= "$indent</ul>\n";
    }

    /**
     * @see Walker::start_el()
     * @param string &$output
     * @param int   $depth
     * @param array $args
     * @param int   $id
     */
    public function start_el(&$output, $category, $depth, $args, $id = 0)
    {
        extract($args);

        if (empty($taxonomy)) {
            $taxonomy = "category";
        }

        $name = $this->_name;

        if (is_null($selected_cats)) {
            $selected_cats = array();
        }

        $output .= "<li id=\"{$taxonomy}-{$category->term_id}\">"
            .	'<label class="selectit">'
            .		'<input value="' . $category->term_id . '" type="checkbox" name="'.$name.'[]" id="in-'.$taxonomy.'-' . $category->term_id . '"' . checked(in_array($category->term_id, $selected_cats), true, false) . disabled( empty( $args['disabled'] ), false, false ) . ' />'
                    . esc_html( apply_filters("the_category", $category->name )) . " (" . esc_html($category->category_count) . ")"
            .	'</label>';
    }

    /**
     * @see Walker::end_el()
     * @param string &$output
     * @param int   $depth
     * @param array $args
     */
    public function end_el(&$output, $category, $depth = 0, $args = array())
    {
        $output .= "</li>\n";
    }
}

/**
 * Custom_Tag_Cloud
 *
 * @package WordPress
 * @subpackage custom-tag-cloud
 * @author s.ashiakwa
 */
class Custom_Tag_Cloud extends WP_Widget
{
    private $_default_template = "widget-html.php";

    /**
     * __construct
     */
    public function __construct()
    {
        $widget_ops = array(
            "description" => "タグクラウドのカスタマイズ",
        );
        parent::__construct("CustomTagCloud", "Custom Tag Cloud", $widget_ops);
    }

    /**
     * (non-PHPdoc)
     * @see WP_Widget::widget()
     * @param array $args
     * @param array $instance
     */
    public function widget($args, $instance)
    {
        extract($args);
        include $this->_get_template_path($args, $instance);
    }

    /**
     * HTML出力ファイルのパスを探す
     * @param  array  $args
     * @param  array  $instance
     * @return string
     */
    protected function _get_template_path($args, $instance)
    {
        $default = $this->_default_template;
        
        $file    = apply_filters("custom_tag_cloud_get_template", $default);

        if (is_readable(STYLESHEETPATH . "/" . $file)) {
            return STYLESHEETPATH . "/" . $file;
        }

        if (is_readable(TEMPLATEPATH . "/" . $file)) {
            return TEMPLATEPATH . "/" . $file;
        }

        return __DIR__ . "/" . $file;
    }

    /**
     * (non-PHPdoc)
     * @see WP_Widget::update()
     * @param array $new_instance
     * @param array $old_instance
     */
    public function update($new_instance, $old_instance)
    {
        return $new_instance;
    }

    /**
     * (non-PHPdoc)
     * @see WP_Widget::form()
     * @param array
     */
    public function form($instance)
    {
        $walker   = new Custom_Walker_Category_Checklist();
        $walker->setName($this->get_field_name("categories"));

        include 'form-html.php';
    }
}

add_action("widgets_init", function () {
    return register_widget("Custom_Tag_Cloud");
});
