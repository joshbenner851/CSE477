<?php
/**
 * Created by PhpStorm.
 * User: joshbenner
 * Date: 4/26/16
 * Time: 11:07 PM
 */

namespace Islands;


class HomeView
{

    /**
     * Constructor
     * Sets the page title and any other settings.
     */
    public function __construct() {
        $this->setTitle("Islands");
    }

    /**
     * Set the page title
     * @param $title New page title
     */
    public function setTitle($title) {
        $this->title = $title;
    }

    public function present(){
        $html = <<<HTML
<form id="signin" action="post/islands.php" method="POST">
    <fieldset>
        <p><img src="images/banner.png" width="521" height="346" alt="Islands Banner"></p>
        <p>Welcome to Islands</p>
        <p><label for="name">Your Name: </label>
        <input type="text" name="name" id="name"></p>
        <p><input type="radio" name="game" id="game1" value="1" checked>
        	<label for="game1">Game 1</label><br>
        <input type="radio" name="game" id="game2" value="2">
        	<lable for="game2">Game 2</lable></p>
        <p><input type="submit" name="start" value="Start Game"></p>
    </fieldset>
</form>
HTML;

        return $html;
    }

    public function head(){
        $html = <<<HTML
<meta charset="UTF-8">
    <title>Islands Signin</title>
    <script type="text/javascript" src="jquery-2.2.3.min.js"></script>
    <link href="islands.css" type="text/css" rel="stylesheet" />
HTML;

        return $html;
    }
}