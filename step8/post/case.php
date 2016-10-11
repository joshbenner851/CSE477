<?php
/**
 * Created by PhpStorm.
 * User: joshbenner
 * Date: 3/23/16
 * Time: 1:40 AM
 */

require '../lib/site.inc.php';

$controller = new Felis\CaseController($site,$_GET, $_POST,$_SESSION);
header("location: " . $controller->getRedirect());
