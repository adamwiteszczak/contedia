<?php

DEFINE('DOC_ROOT', $_SERVER['DOCUMENT_ROOT'] . '/contedia/') ;

spl_autoload_register(function($class_name) {
    $path = DOC_ROOT . $class_name . '.php';
    $path = strtolower($path);
    if (file_exists($path)) {
        require_once($path);
    }
});