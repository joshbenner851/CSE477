<?php
/**
 * Created by PhpStorm.
 * User: joshbenner
 * Date: 4/26/16
 * Time: 11:05 PM
 */


require '../lib/site.inc.php';

$controller = new \Islands\GameController($islands,$_POST);


if($controller->isReset()) {
    unset($_SESSION[ISLANDS_SESSION]);
}

header("location: " . $controller->getRedirect()); //$controller->getRedirect());
exit;
//echo $controller->getRedirect();
//var_dump($controller->getRedirect());
//var_dump($_SESSION);