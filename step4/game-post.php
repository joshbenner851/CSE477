<?php
/**
 * Created by PhpStorm.
 * User: joshbenner
 * Date: 2/6/16
 * Time: 11:36 PM
 */

require 'lib/game.inc.php';

$controller = new Wumpus\WumpusController($wumpus, $_REQUEST);

if($controller->isReset()) {
    unset($_SESSION[WUMPUS_SESSION]);
    $_SESSION[WUMPUS_SESSION] = new Wumpus\Wumpus();
}

if($controller->cheatMode()) {
    unset($_SESSION[WUMPUS_SESSION]);
    $_SESSION[WUMPUS_SESSION] = new Wumpus\Wumpus(1422668587);
}

//echo "<p>" . $controller->getPage() . "</p>";
header('Location: ' . $controller->getPage());
