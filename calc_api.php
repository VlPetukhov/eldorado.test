<?php
/**
 * Main file
 */

//AJAX requests only
//if ($_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') {
//    header("HTTP/1.0 404 Not Found");
//    die();
//}

include 'includes/autoload.php';

$callback = null;
$response = '';

if ( isset($_REQUEST['callback']) ) {
    $callback = trim($_REQUEST['callback']);
}

if ( !isset($_REQUEST['expr'])) {
    $response = 'Request error. No expression was given.';
} else {
    $calc = new \Calculator\Calculator();

    $response = $calc->solve(trim($_REQUEST['expr']));
}

$response = "{msg: $response}";

if ($callback) {
    echo "$callback($response)";
} else {
    echo $response;
}