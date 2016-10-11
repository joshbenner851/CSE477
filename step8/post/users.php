<?php
/**
 * Created by PhpStorm.
 * User: joshbenner
 * Date: 3/22/16
 * Time: 2:59 AM
 */

require '../lib/site.inc.php';

$controller = new Felis\UsersController($site, $user, $_POST);
header("location: " . $controller->getRedirect());