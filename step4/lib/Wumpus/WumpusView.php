<?php
/**
 * Created by PhpStorm.
 * User: joshbenner
 * Date: 2/6/16
 * Time: 11:44 AM
 */

namespace Wumpus;


class WumpusView
{
    /**
     * Constructor
     * @param Wumpus $wumpus The Wumpus object
     */
    public function __construct(Wumpus $wumpus) {
        $this->wumpus = $wumpus;
    }

    /** Generate the HTML for the number of arrows remaining */
    public function presentArrows() {
        $a = $this->wumpus->numArrows();
        return "<p>You have $a arrows remaining.</p>";
    }

    public function presentStatus() {
        $room = $this->wumpus->getCurrent()->getNum();
        $html = "<p>You are in room $room</p>";
        if($this->wumpus->smellWumpus()){
            $html .= "<p>You smell a wumpus</p>";
        }
        else {
            $html .= "<p>&nbsp;</p>";
        }
        if($this->wumpus->wasCarried()) {
            $html .= "<p>Were carried by the birds to room $room!</p>";
        }
        if($this->wumpus->feelDraft()) {
            $html .= "<p>You feel a draft</p>";
        }
        else {
            $html .= "<p>&nbsp;</p>";
        }
        if($this->wumpus->hearBirds()) {
            $html .= "<p>You hear birds</p>";
        }
        else {
            $html .= "<p>&nbsp;</p>";
        }

        return $html;
    }

    /** Present the links for a room
     * @param $ndx An index 0 to 2 for the three rooms */
    public function presentRoom($ndx) {
        $room = $this->wumpus->getCurrent()->getNeighbors()[$ndx];
        $roomnum = $room->getNum();
        $roomndx = $room->getNdx();
        $roomurl = "game-post.php?m=$roomndx";
        $shooturl = "game-post.php?s=$roomndx";

        $html = <<<HTML
<div class="room">
  <figure><img src="cave2.jpg" width="180" height="135" alt=""/></figure>
  <p><a href="$roomurl">$roomnum</a></p>
<p><a href="$shooturl">Shoot Arrow</a></p>
</div>
HTML;

        return $html;
    }

    private $wumpus;    // The Wumpus object
}