<?php

//  /var/www/eklektikstore/eklektikstore.com.ua/
$host = getenv('HTTP_HOST');
//C:\OSPanel\domains\huiontab2\xp-pen.com.ua\config.php
if ($host=='localhost26') {      // local
// HTTP
    define('HTTP_SERVER', 'http://localhost26/');

// HTTPS
    define('HTTPS_SERVER', 'https://localhost26/');

// DIR  C:\OSPanel\domains\startup2\config.php

    define('DIR_APPLICATION', 'C:/OSPanel/domains/startup2/catalog/');
    define('DIR_SYSTEM', 'C:/OSPanel/domains/startup2/system/');
    define('DIR_IMAGE', 'C:/OSPanel/domains/startup2/image/');
    define('DIR_LANGUAGE', 'C:/OSPanel/domains/startup2/catalog/language/');
    define('DIR_TEMPLATE', 'C:/OSPanel/domains/startup2/catalog/view/theme/');
    define('DIR_CONFIG', 'C:/OSPanel/domains/startup2/system/config/');
    define('DIR_CACHE', 'C:/OSPanel/domains/startup2/system/storage/cache/');
    define('DIR_DOWNLOAD', 'C:/OSPanel/domains/startup2/system/storage/download/');
    define('DIR_LOGS', 'C:/OSPanel/domains/startup2/system/storage/logs/');
    define('DIR_MODIFICATION', 'C:/OSPanel/domains/startup2/system/storage/modification/');
    define('DIR_UPLOAD', 'C:/OSPanel/domains/startup2/system/storage/upload/');


// DB
    define('DB_DRIVER', 'mysqli');
    define('DB_HOSTNAME', 'localhost');
    define('DB_USERNAME', 'root');
    define('DB_PASSWORD', '');
    define('DB_DATABASE', 'localhost26');
    define('DB_PORT', '3306');
    define('DB_PREFIX', 'oc_');
}else{    // prod
    die('error config');

// HTTP
    define('HTTP_SERVER', 'http://eklektikstore.com.ua/');
// HTTPS
    define('HTTPS_SERVER', 'http://eklektikstore.com.ua/');

// DIR
    define('DIR_APPLICATION', '/var/www/eklektikstore/eklektikstore.com.ua/catalog/');
    define('DIR_SYSTEM', '/var/www/eklektikstore/eklektikstore.com.ua/system/');
    define('DIR_IMAGE', '/var/www/eklektikstore/eklektikstore.com.ua/image/');
    define('DIR_LANGUAGE', '/var/www/eklektikstore/eklektikstore.com.ua/catalog/language/');
    define('DIR_TEMPLATE', '/var/www/eklektikstore/eklektikstore.com.ua/catalog/view/theme/');
    define('DIR_CONFIG', '/var/www/eklektikstore/eklektikstore.com.ua/system/config/');
    define('DIR_CACHE', '/var/www/eklektikstore/eklektikstore.com.ua/system/storage/cache/');
    define('DIR_DOWNLOAD', '/var/www/eklektikstore/eklektikstore.com.ua/system/storage/download/');
    define('DIR_LOGS', '/var/www/eklektikstore/eklektikstore.com.ua/system/storage/logs/');
    define('DIR_MODIFICATION', '/var/www/eklektikstore/eklektikstore.com.ua/system/storage/modification/');
    define('DIR_UPLOAD', '/var/www/eklektikstore/eklektikstore.com.ua/system/storage/upload/');

// DB
    define('DB_DRIVER', 'mysqli');
    define('DB_HOSTNAME', 'localhost');
    define('DB_USERNAME', 'u_db_eklek');
    define('DB_PASSWORD', 'SWpDh45e');
    define('DB_DATABASE', 'db_eklektikstore');
    define('DB_PORT', '3306');
    define('DB_PREFIX', 'oc_');
}