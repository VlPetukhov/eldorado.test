<?php
/**
 * Class autoloader
 */

spl_autoload_register( function ( $className ) {
    $filePath = realpath(__DIR__ . DIRECTORY_SEPARATOR . '..') .
                DIRECTORY_SEPARATOR . str_replace('\\', DIRECTORY_SEPARATOR, $className) . '.php';

    include $filePath;
});