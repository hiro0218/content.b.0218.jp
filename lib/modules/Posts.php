<?php

class Posts
{
  public function __construct()
  {
    add_action('pre_get_posts', [$this, 'set_pre_get_posts']);
    add_filter('the_content', [$this, 'repair_destroyed_datauri'], 11);
    add_filter('the_content', [$this, 'add_img_to_lazyload_attr'], 12);
    add_filter('the_excerpt', ["Util", 'get_excerpt_content']);
    add_filter('excerpt_length', [$this, 'change_excerpt_length']);
    add_filter('excerpt_mblength', [$this, 'change_excerpt_length']);
    add_filter('excerpt_more', [$this, 'change_excerpt_more']);
    remove_filter('sanitize_title', 'sanitize_title_with_dashes');
    add_filter('sanitize_title', [$this, 'sanitize_title_with_dots_and_dashes']);
    add_filter('name_save_pre', [$this, 'name_save_pre']);
    add_filter('rest_post_collection_params', [$this, 'change_post_per_page'], 10, 1);
  }

  // 省略文字数
  public function change_excerpt_length($length)
  {
    return EXCERPT_LENGTH;
  }

  // 省略記号
  public function change_excerpt_more()
  {
    return EXCERPT_HELLIP;
  }

  public function set_pre_get_posts($query)
  {
    $query = $this->sort_query($query);
    $query = $this->remove_page_from_search_result($query);

    return $query;
  }

  // Sort Post query
  private function sort_query($query)
  {
    // influence: admin page's post list
    if ($query->is_main_query()) {
      $query->set('orderby', 'modified');
      $query->set('order', 'desc');
    }

    return $query;
  }

  // remove page from search result
  private function remove_page_from_search_result($query)
  {
    if ($query->is_search()) {
      $query->set('post_type', 'post');
    }

    return $query;
  }

  // Bug? (Wordpress 4.3)
  // DataURI form CustomField is destroyed.
  public function repair_destroyed_datauri($content)
  {
    $content = $this->replace_relative_to_absolute_img_src($content);

    return str_replace(' src="image/', ' src="data:image/', $content);
  }

  public function add_img_to_lazyload_attr($content)
  {
    if (is_feed()) {
      return $content;
    }
    return str_replace('<img ', '<img decoding="async" lazyload="lazy" ', $content);
  }

  private function replace_relative_to_absolute_img_src($content)
  {
    preg_match_all('/<img.*?src=(["\'])(.+?)\1.*?>/i', $content, $matches);

    foreach ($matches[2] as $src_url) {
      // to Absolute URL
      if (Util::is_image($src_url)) {
        $src_absolute_url = Util::relative_to_absolute_url($src_url);
        $content = str_replace('src="' . $src_url, 'src="' . $src_absolute_url, $content);
      }
    }

    return $content;
  }

  public function sanitize_title_with_dots_and_dashes($title)
  {
    $title = strip_tags($title);
    // Preserve escaped octets.
    $title = preg_replace('|%([a-fA-F0-9][a-fA-F0-9])|', '---$1---', $title);
    // Remove percent signs that are not part of an octet.
    $title = str_replace('%', '', $title);
    // Restore octets.
    $title = preg_replace('|---([a-fA-F0-9][a-fA-F0-9])---|', '%$1', $title);
    $title = remove_accents($title);

    if (seems_utf8($title)) {
      if (function_exists('mb_strtolower')) {
        $title = mb_strtolower($title, 'UTF-8');
      }
      $title = utf8_uri_encode($title);
    }

    $title = strtolower($title);
    $title = preg_replace('/&.+?;/', '', $title); // kill entities
    $title = preg_replace('/[^%a-z0-9 ._-]/', '', $title);
    $title = preg_replace('/\s+/', '-', $title);
    $title = preg_replace('|-+|', '-', $title);
    $title = trim($title, '-');
    $title = str_replace('-.-', '.', $title);
    $title = str_replace('-.', '.', $title);
    $title = str_replace('.-', '.', $title);
    $title = preg_replace('|([^.])\.$|', '$1', $title);
    $title = trim($title, '-'); // yes, again

    return $title;
  }

  public function name_save_pre($post_name)
  {
    global $post, $wp_rewrite;

    // 投稿タイプが post でない場合は処理しない
    if ($post->post_type !== 'post') {
      return $post_name;
    }

    // 公開時のみ処理する
    if (in_array($_POST['post_status'], array('draft', 'pending', 'auto-draft'))) {
      return $post_name;
    }

    // generate permalink
    $post_date = $post->post_date;
    $post_date = date_parse($post_date);

    $slug = $wp_rewrite->permalink_structure;
    $slug = str_replace('%year%', $post_date['year'], $slug);
    $slug = str_replace('%monthnum%', str_pad($post_date['month'], 2, 0, STR_PAD_LEFT), $slug);
    $slug = str_replace('%day%', str_pad($post_date['day'], 2, 0, STR_PAD_LEFT), $slug);
    $slug = str_replace('%hour%', str_pad($post_date['hour'], 2, 0, STR_PAD_LEFT), $slug);
    $slug = str_replace('%minute%', str_pad($post_date['minute'], 2, 0, STR_PAD_LEFT), $slug);
    $slug = str_replace('%second%', str_pad($post_date['second'], 2, 0, STR_PAD_LEFT), $slug);

    $post_name = $slug;

    return $post_name;
  }

  function change_post_per_page($params)
  {
    if (isset($params['per_page'])) {
      $params['per_page']['maximum'] = 1000;
    }

    return $params;
  }
}

$Posts = new Posts();
