<?php

class FrontVariables
{
  public function __construct()
  {
  }

  // Global javaScript variables
  public function output_variables()
  {
    global $Route;

    $vars = [
      'site' => [
        'name' => BLOG_NAME,
        'url' => BLOG_URL,
        'copyright' => Util::get_copyright_year(),
        'primary_navigation' => $this->get_primary_navigation(),
      ],
      'per_page' => $this->get_per_page(),
      'categories_exclude' => $this->get_categories_exclude(),
      'is_preview' => is_preview(),
      'is_logined' => is_user_logged_in(),
      'is_shared' => $this->is_shared(),
      'routes' => $Route->get_routes(),
      'nonce' => wp_create_nonce('wp_rest'),
    ];
    $vars = json_encode($vars, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_UNESCAPED_UNICODE);

    echo '<script>';
    echo 'var WP = ' . $vars;
    echo '</script>' . PHP_EOL;
  }

  private function get_per_page()
  {
    return (int) get_option('posts_per_page');
  }

  private function get_categories_exclude()
  {
    $exclude_category = (int) get_option('kiku_exclude_category_frontpage');
    return $exclude_category ? $exclude_category : 0;
  }

  private function is_shared()
  {
    return [
      'twitter' => (bool) get_option('kiku_share_btn_twitter'),
      'facebook' => (bool) get_option('kiku_share_btn_facebook'),
      'hatena' => (bool) get_option('kiku_share_btn_hatena'),
      'line' => (bool) get_option('kiku_share_btn_line'),
    ];
  }

  public function get_primary_navigation()
  {
    if (!has_nav_menu(PRIMARY_NAVIGATION_NAME)) {
      return null;
    }

    // transient で一時的にキャッシュしたデータをロード
    $key = CACHE_PREFIX . md5(PRIMARY_NAVIGATION_NAME);
    $result = get_transient($key);

    if ($result === false) {
      $menu_ids = get_nav_menu_locations();
      $menus = wp_get_nav_menu_items($menu_ids[PRIMARY_NAVIGATION_NAME]);
      $array = [];

      foreach ((array) $menus as $menu) {
        $menu_array = (array) $menu;
        $array[] = [
          'ID' => isset($menu_array['ID']) ? $menu_array['ID'] : '',
          'title' => isset($menu_array['title']) ? $menu_array['title'] : '',
          'url' => isset($menu_array['url']) ? $menu_array['url'] : '',
        ];
      }

      set_transient($key, $array, HOUR_IN_SECONDS);
      return $array;
    }

    return $result;
  }
}

$fv = new FrontVariables();
add_action('wp_footer', [$fv, 'output_variables']);
