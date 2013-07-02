# WP Custom Tagcloud

任意のカテゴリをサイドバーウィジェットとして表示するプラグイン

## USAGE

### HTML テンプレートの変更

custom_tag_cloud_get_template フックを呼び出す。

```php
add_filter("custom_tag_cloud_get_template", function ($template) {
    return $new_template;
});
```

ファイルは、 STYLESHEETPATH, TEMPLATEPATH, の順検索される。
HTMLのカスタマイズは widget-html.php を参照。
