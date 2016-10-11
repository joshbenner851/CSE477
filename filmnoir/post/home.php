<?php
require '../lib/site.inc.php';

$controller = new Noir\HomeController($site, $_POST, $_SESSION);
header("location: " . $controller->getRedirect());
