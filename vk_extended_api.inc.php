<?php

require __DIR__ . '/lib/interfaces/request.php';
require __DIR__ . '/lib/net/request.php';
require __DIR__ . '/lib/interfaces/connection.php';
require __DIR__ . '/lib/wrapper/vkConnection.php';
require __DIR__ . '/lib/wrapper/vk.php';

$vea_config = parse_ini_file(__DIR__ . DIRECTORY_SEPARATOR . 'vea_config.ini');

\VEA\lib\wrapper\vkConnection::$api_url = $vea_config['api_url'];
\VEA\lib\wrapper\vkConnection::$sapi_url = $vea_config['sapi_url'];
\VEA\lib\wrapper\vkConnection::$callback_url = $vea_config['callback_url'];
