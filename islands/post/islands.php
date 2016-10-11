<?php
/**
 * Created by PhpStorm.
 * User: joshbenner
 * Date: 4/26/16
 * Time: 11:05 PM
 */


require '../lib/site.inc.php';

$controller = new \Islands\IslandsController($_POST,$_SESSION,$islands);

if(isset($_POST['name'])){
    //Set the name
    $_SESSION['name'] = strip_tags($_POST['name']);
}
//var_dump($_SESSION);
header("location: " . $controller->getRedirect()); //$controller->getRedirect());
exit;
//echo $controller->getRedirect();
//var_dump($controller->getRedirect());