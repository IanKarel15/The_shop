<?php 

$config = require __DIR__.'/../config/config.php';

define('BASE_PATH', $config['base_url']);
define('ASSETS_PATH', $config['assets_url']);
define('SRC_PATH', $config['src_url']);

?>