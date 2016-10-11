<?php
/**
 * Created by PhpStorm.
 * User: joshbenner
 * Date: 3/23/16
 * Time: 4:20 AM
 */

require '../lib/site.inc.php';

$controller = new Felis\DeleteController($site, $_GET, $_POST);

header("location: " . $controller->getRedirect());