<?php
define('APP_VERSION',time());
define('OL_THEME_URL',get_template_directory_uri());
define('OL_THEME_ASSET',OL_THEME_URL . '/asset');
define('OL_THEME_DIR',get_template_directory());
require(OL_THEME_DIR.'/helpers/loading.php');
require(OL_THEME_DIR.'/inc/bootstrap.php');
require(OL_THEME_DIR.'/theme-front/loading.php');
require(OL_THEME_DIR.'/theme-admin/loading.php');

