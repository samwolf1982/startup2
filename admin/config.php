<?php

$host = getenv('HTTP_HOST');
//C:\OSPanel\domains\huiontab2\xp-pen.com.ua\config.php
if ($host=='localhost26') {      // local

// HTTP
    define('HTTP_SERVER', 'http://localhost26/admin/');
    define('HTTP_CATALOG', 'http://localhost26/');

// HTTPS
    define('HTTPS_SERVER', 'http://localhost26/admin/');
    define('HTTPS_CATALOG', 'http://localhost26/');
// DIR
    define('DIR_APPLICATION', 'C:/OSPanel/domains/startup2/admin/');
    define('DIR_SYSTEM', 'C:/OSPanel/domains/startup2/system/');
    define('DIR_IMAGE', 'C:/OSPanel/domains/startup2/image/');
    define('DIR_LANGUAGE', 'C:/OSPanel/domains/startup2/admin/language/');
    define('DIR_TEMPLATE', 'C:/OSPanel/domains/startup2/admin/view/template/');
    define('DIR_CONFIG', 'C:/OSPanel/domains/startup2/system/config/');
    define('DIR_CACHE', 'C:/OSPanel/domains/startup2/system/storage/cache/');
    define('DIR_DOWNLOAD', 'C:/OSPanel/domains/startup2/system/storage/download/');
    define('DIR_LOGS', 'C:/OSPanel/domains/startup2/system/storage/logs/');
    define('DIR_MODIFICATION', 'C:/OSPanel/domains/startup2/system/storage/modification/');
    define('DIR_UPLOAD', 'C:/OSPanel/domains/startup2/system/storage/upload/');
    define('DIR_CATALOG', 'C:/OSPanel/domains/startup2/catalog/');
// DB
    define('DB_DRIVER', 'mysqli');
    define('DB_HOSTNAME', 'localhost');
    define('DB_USERNAME', 'root');
    define('DB_PASSWORD', '');
    define('DB_DATABASE', 'localhost26');
    define('DB_PORT', '3306');
    define('DB_PREFIX', 'oc_');
}else{
    die('error conf');
    // HTTP
    define('HTTP_SERVER', 'http://eklektikstore.com.ua/admin/');
    define('HTTP_CATALOG', 'http://eklektikstore.com.ua/');

// HTTPS
    define('HTTPS_SERVER', 'http://eklektikstore.com.ua/admin/');
    define('HTTPS_CATALOG', 'http://eklektikstore.com.ua/');

// DIR
    define('DIR_APPLICATION', '/var/www/eklektikstore/eklektikstore.com.ua/admin/');
    define('DIR_SYSTEM', '/var/www/eklektikstore/eklektikstore.com.ua/system/');
    define('DIR_IMAGE', '/var/www/eklektikstore/eklektikstore.com.ua/image/');
    define('DIR_LANGUAGE', '/var/www/eklektikstore/eklektikstore.com.ua/admin/language/');
    define('DIR_TEMPLATE', '/var/www/eklektikstore/eklektikstore.com.ua/admin/view/template/');
    define('DIR_CONFIG', '/var/www/eklektikstore/eklektikstore.com.ua/system/config/');
    define('DIR_CACHE', '/var/www/eklektikstore/eklektikstore.com.ua/system/storage/cache/');
    define('DIR_DOWNLOAD', '/var/www/eklektikstore/eklektikstore.com.ua/system/storage/download/');
    define('DIR_LOGS', '/var/www/eklektikstore/eklektikstore.com.ua/system/storage/logs/');
    define('DIR_MODIFICATION', '/var/www/eklektikstore/eklektikstore.com.ua/system/storage/modification/');
    define('DIR_UPLOAD', '/var/www/eklektikstore/eklektikstore.com.ua/system/storage/upload/');
    define('DIR_CATALOG', '/var/www/eklektikstore/eklektikstore.com.ua/catalog/');

// DB
    define('DB_DRIVER', 'mysqli');
    define('DB_HOSTNAME', 'localhost');
    define('DB_USERNAME', 'u_db_eklek');
    define('DB_PASSWORD', 'SWpDh45e');
    define('DB_DATABASE', 'db_eklektikstore');
    define('DB_PORT', '3306');
    define('DB_PREFIX', 'oc_');
}
