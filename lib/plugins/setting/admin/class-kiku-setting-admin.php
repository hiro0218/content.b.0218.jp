<?php

class Kiku_Setting_Admin
{
  private $plugin_name;
  private $version;
  private $message;
  private $options;
  private $exclude_post_types = ['attachment', 'revision', 'nav_menu_item', 'safecss'];

  public function __construct($plugin_name, $version)
  {
    add_action('admin_init', [$this, 'register_settings']);
  }

  public function register_settings()
  {
    register_setting('kiku-settings-group', 'kiku_amazon_api_key');
    register_setting('kiku-settings-group', 'kiku_amazon_secret_key');
    register_setting('kiku-settings-group', 'kiku_amazon_associate_tag');
  }

  private function get_setting_option($defaults)
  {
    $options = get_option('kiku-setting-options', $defaults);
    $options = wp_parse_args($options, $defaults);
    return $options;
  }

  public function add_admin_page()
  {
    add_theme_page(
      __('Setting', 'kiku'), // page_title
      __('Setting', 'kiku'), // menu_title
      'manage_options', // capability
      'setting', // menu_slug
      [$this, 'admin_options']
    );
  }

  public function admin_options()
  {
    require_once LIB_PATH . 'plugins/setting/admin/partials/kiku-setting-admin-display.php';
  }
}
