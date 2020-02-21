<?php
class Util
{
  /**
   * 記事関連
   */

  // 記事内容の抜粋
  public static function get_excerpt_content()
  {
    $content = '';
    $post_id = get_queried_object_id();

    if (has_excerpt($post_id)) {
      // This post has excerpt
      $content = get_the_excerpt();
    } else {
      // This post has no excerpt
      $post = get_post($post_id);
      $post_content = $post->post_content;

      // h2 要素のみ取り出し
      $headings = [];
      $dom = new DOMDocument();
      @$dom->loadHTML(mb_convert_encoding($post_content, 'HTML-ENTITIES', 'UTF-8'));
      $nodes = $dom->getElementsByTagName('h2');
      foreach ($nodes as $node) {
        $headings[] = $node->textContent;
      }

      // h2要素が取得できない場合は文章全体をセット
      $content = !empty($headings) ? join('/', $headings) : $post_content;

      return $content;
    }

    // 何も取得できない
    if (empty($content)) {
      return NOTHING_CONTENT;
    }

    // タグを省いて取得
    $content = self::remove_tags($content);

    // 整形
    return mb_substr($content, 0, EXCERPT_LENGTH) . EXCERPT_HELLIP;
  }

  private static function remove_tags(string $str)
  {
    if (empty($str)) {
      return '';
    }

    $str = wp_strip_all_tags($str);
    $str = strip_shortcodes($str);
    $str = self::remove_white_space($str, '');

    return $str;
  }

  // スペースを除く
  public static function remove_white_space(string $tag, $last_line_break = PHP_EOL)
  {
    $tag = preg_replace('/(?:\n|\r|\r\n)/', '', $tag);
    return preg_replace('/>(\s|\n|\r)+</', '><', $tag) . $last_line_break;
  }

  // "//example.com" -> "http://example.com"
  public static function add_scheme_relative_url($url, $scheme = 'http')
  {
    if (preg_match('/^\/\//', $url) === 1) {
      return $scheme . ':' . $url;
    }
    return $url;
  }

  /**
   * URL
   */

  public static function is_url($str)
  {
    return preg_match('/^(https?|ftp)(:\/\/[-_.!~*\'()a-zA-Z0-9;\/?:\@&=+\$,%#]+)$/', $str);
  }

  // 相対URIを絶対URIへ変換する
  public static function relative_to_absolute_url($url)
  {
    if (self::is_relative_url($url)) {
      return self::base_url($url);
    }

    return $url;
  }

  public static function is_absolute_url($url)
  {
    return preg_match('/^((https?:)?\/\/|data:)/', $url) === 1;
  }

  public static function is_root_relative_url($url)
  {
    return !self::is_absolute_url($url) && preg_match('/^\//', $url) === 1;
  }

  public static function is_relative_url($url)
  {
    return !(self::is_absolute_url($url) || self::is_root_relative_url($url));
  }

  // ベースURLを設定(絶対URL)
  public static function base_url($path = null)
  {
    $parts = parse_url(BLOG_URL);
    $base_url = trailingslashit($parts['scheme'] . '://' . $parts['host'] . $parts['path']);

    if (!is_null($path)) {
      $base_url .= ltrim($path, '/');
    }

    return $base_url;
  }

  public static function base_path($path)
  {
    return '/' . str_replace(BLOG_URL, '', $path);
  }

  /**
   * Checker
   */

  public static function is_image($path)
  {
    $result = false;
    $path_info = pathinfo($path);

    if (isset($path_info['extension'])) {
      switch ($path_info['extension']) {
        case 'gif':
        case 'jpg':
        case 'jpeg':
        case 'png':
        case 'bmp':
        case 'tif':
        case 'tiff':
          $result = true;
          break;
        default:
          $result = false;
          break;
      }
    }

    return $result;
  }

  public static function is_shortcode($str)
  {
    return (bool) substr($str, 0, 1) === '[' && substr($str, strlen($str) - 1, 1) === ']';
  }

  public static function is_dataURI($str)
  {
    return (bool) (substr($str, 0, 5) === 'data:');
  }
}
