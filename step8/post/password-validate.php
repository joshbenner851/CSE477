<?php
/**
 * Created by PhpStorm.
 * User: joshbenner
 * Date: 4/1/16
 * Time: 1:12 AM
 */


require '../lib/site.inc.php';

$controller = new \Felis\PasswordValidateController($site,$_POST);

header("location: " . $controller->getRedirect());