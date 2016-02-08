<?php
/**
 * Class autoloader
 */

spl_autoload_register( function ( $className ) {
   include $className . '.php';
});