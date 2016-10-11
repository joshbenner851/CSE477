<?php
/**
 * Created by PhpStorm.
 * User: joshbenner
 * Date: 3/21/16
 * Time: 1:46 AM
 */

require '../lib/site.inc.php';

$controller = new Felis\CasesController($site, $_POST);

header("location: " . $controller->getRedirect());
