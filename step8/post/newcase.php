<?php
/**
 * Created by PhpStorm.
 * User: joshbenner
 * Date: 3/21/16
 * Time: 7:22 PM
 */

require '../lib/site.inc.php';

$controller = new Felis\NewCaseController($site, $user, $_POST);
header("location: " . $controller->getRedirect());