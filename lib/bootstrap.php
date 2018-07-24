<?php

$timezone_string = get_option('timezone_string');
if ($timezone_string) {
    date_default_timezone_set($timezone_string);
}

define('LIB_PATH', realpath(__DIR__) .DIRECTORY_SEPARATOR);

// constant
require LIB_PATH. 'config/constant.php';
require LIB_PATH. 'config/FrontVariables.php';

// class
require LIB_PATH. 'Util.php';
require LIB_PATH. 'DB.php';
require LIB_PATH. 'Entry.php';
require LIB_PATH. 'Image.php';
require LIB_PATH. 'RestApi.php';
require LIB_PATH. 'SEO.php';
require LIB_PATH. 'structured-data/Schema.php';
$Entry = new Entry();
$Image = new Image();

// module
require LIB_PATH. 'modules/admin.php';
require LIB_PATH. 'modules/Clean.php';
require LIB_PATH. 'modules/OpenGraph.php';
require LIB_PATH. 'modules/Posts.php';

// plugin
require LIB_PATH. 'plugins/amazon/Amazon.php';
require LIB_PATH. 'plugins/mokuji/Mokuji.php';
require LIB_PATH. 'plugins/setting/kiku-setting.php';
