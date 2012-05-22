<?php

spl_autoload_register(function($class) {
    $class = str_replace('\\', DIRECTORY_SEPARATOR, $class);
    if(mb_substr($class, 0, 1) != DIRECTORY_SEPARATOR) {
        $class = DIRECTORY_SEPARATOR . $class;
    }
    if(file_exists(__DIR__ . $class . '.php')) {
        require_once __DIR__ . $class . '.php';
    } else {
        throw new \Exception("Class {$class} wasn't found", -1);
    }
});