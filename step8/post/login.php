<?php
/**
 * Created by PhpStorm.
 * User: joshbenner
 * Date: 3/20/16
 * Time: 4:04 AM
 */

$open = true;		// Can be accessed when not logged in
require '../lib/site.inc.php';

$controller = new Felis\LoginController($site, $_SESSION, $_POST);
header("location: " . $controller->getRedirect());