<?php
require 'lib/guessing.inc.php';

/**
 * Created by PhpStorm.
 * User: joshbenner
 * Date: 2/10/16
 * Time: 4:54 PM
 */

$controller = new Guessing\GuessingController($guessing, $_POST);
if($controller->isReset()) {
    unset($_SESSION[GUESSING_SESSION]);
}
header("location: guessing.php");
exit;