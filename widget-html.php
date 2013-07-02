<?php
/**
 * admin-html.php
 *
 * @package WordPress
 * @subpackage custom-tag-cloud
 * @global $name, $id, $description, $class, $before_widget,
 * $after_widget, $before_title, $after_title, $widget_id, $widget_name, $instance
 */
?>
<!-- Custom Tag Cloud Plugin -->
<?php echo $before_widget; ?>
<?php if ($instance['title']) : ?>
    <?php echo $before_title, esc_html($instance['title']), $after_title; ?>
<?php endif;?>
    <p class="tags">
<?php
$categories = $instance['categories'];
foreach ($categories as $id) :
    $tag = get_category($id);

    if (!$tag) {
        continue;
    }

    $classes = implode(" ", array(
        esc_attr($tag->slug),
    ));
?>
        <a href="<?php echo get_category_link($tag);?>" class="<?php echo  $classes; ?>" data-category-count="<?php echo esc_attr($tag->category_count)?>"><?php echo $tag->name; ?></a>
<?php endforeach; ?>
    </p>
<?php echo $after_widget; ?>
<!-- Custom Tag Cloud Plugin -->
