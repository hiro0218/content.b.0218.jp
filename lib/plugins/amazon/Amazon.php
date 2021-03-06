<?php
require LIB_PATH . 'plugins/amazon/Aapapi.php';

class Amazon
{
  public static function get_amazon_product($post_id)
  {
    $product_data = null;
    $Aapapi = new \Aapapi\Aapapi();

    $asin = get_post_meta($post_id, CF_ASIN, true);

    if (empty($asin) || empty($Aapapi)) {
      return null;
    }

    try {
      $product_data = $Aapapi->lookupASIN(strtoupper($asin));
    } catch (Exception $e) {
      return null;
    }

    return $product_data;
  }

  // make Amazon Product Tag when save post
  public function save_amazon_product_tag($post_id)
  {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
      return;
    }

    $current_data = get_post_meta($post_id, CF_AMAZON_PRODUCT_TAG, true);
    $product_data = self::get_amazon_product($post_id);

    if ($current_data !== $product_data && !empty($product_data)) {
      $product_data = self::format_product_data($product_data);
      self::update_asin_meta($post_id, $product_data);
    }
  }

  public static function format_product_data($product_data)
  {
    $data = [];
    $product_data = json_encode($product_data, JSON_UNESCAPED_UNICODE);
    $product_data = json_decode($product_data, true);

    if (empty($product_data)) {
      return null;
    }

    $data['ASIN'] = $product_data['ASIN'];
    $data['DetailPageURL'] = self::normalize_amazon_url($product_data['ASIN'], get_option('kiku_amazon_associate_tag'));
    $data['Title'] = $product_data['ItemAttributes']['Title'];
    $data['Author'] = $product_data['ItemAttributes']['Author'];
    $data['LargeImage'] = $product_data['LargeImage']['URL'];

    return json_encode($data, JSON_UNESCAPED_UNICODE);
  }

  public static function normalize_amazon_url($asin, $associate = null)
  {
    $url = 'https://amazon.co.jp/exec/obidos/ASIN/' . $asin . '/';

    if (!empty($associate)) {
      $url .= $associate;
    }

    return $url;
  }

  public static function update_asin_meta($post_id, $value)
  {
    update_post_meta($post_id, CF_AMAZON_PRODUCT_TAG, $value);
  }

  // delete CF_AMAZON_PRODUCT_TAG when delete CF_ASIN
  public static function deleted_asin_meta($meta_id, $post_id, $meta_key, $meta_value)
  {
    if (CF_ASIN == $meta_key) {
      delete_post_meta($post_id, CF_AMAZON_PRODUCT_TAG);
    }
  }
}

$Amazon = new Amazon();

add_action('save_post', [$Amazon, 'save_amazon_product_tag'], 11, 2);
add_action('deleted_post_meta', [$Amazon, 'deleted_asin_meta'], 10, 4);
