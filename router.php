<?php

$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

$public = __DIR__ . '/public';

if ($uri !== '/' && file_exists($public . $uri) && ! is_dir($public . $uri)) {
    return false;
}

$_SERVER['SCRIPT_NAME'] = '/index.php';
require $public . '/index.php';
