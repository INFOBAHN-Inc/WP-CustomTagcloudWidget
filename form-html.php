<?php
/**
 * admin-html.html
 * 管理画面に
 * @package WordPress
 * @subpackage maincategory
 */
?>
<!-- Custom Tag Cloud Plugin -->
<p>
    <label>Title: <input type="text" name="<?php echo esc_attr($this->get_field_name('title')); ?>" value="<?php echo esc_attr($instance['title']); ?>" /></label>
</p>
<div class="categorydiv">
<p>
    Categories:
    <ul class="categorychecklist"><?php
    wp_list_categories(array(
        "title_li"      => "",
        "style"         => "list",
        'hide_empty'    => false,
        'hierarchical'  => 1,
        "walker"        => $walker,
        "selected_cats" => $instance['categories'],
    ));
?></ul>
</p>
</div>
