<?php
/**
 * Created by PhpStorm.
 * User: joshbenner
 * Date: 3/20/16
 * Time: 4:15 AM
 */

require '../lib/site.inc.php';
unset($_SESSION['user']);
header("location: " . "../$root");