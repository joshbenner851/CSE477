<?php
/**
 * Created by PhpStorm.
 * User: joshbenner
 * Date: 4/26/16
 * Time: 11:59 PM
 */

namespace Islands;


class GameView
{

    public function __construct(Game $game)
    {
        $this->island = $game;
        //var_dump($this->island);
        $this->board = $this->island->getBoard();
        $this->usedTiles = $this->island->getUsedTiles();
        $this->winBoard = $this->island->getWinBoard();
    }

    public function present(){
        $name = $this->island->getName();
        $html = <<<HTML
<form id="gameform" action="post/game.php" method="POST">
    <fieldset>
        <p>$name's Islands</p>
HTML;
        return $html;
    }

    public function toolbar(){
        $error = $this->island->getErrorMsg();
        $html = <<<HTML
                $error
                <p><input type="submit" name="check" value="Check"></p>
        <p><input type="submit" name="giveup" value="Give Up"></p>
        <p><input type="submit" name="newgame" value="New Game"></p>

    </fieldset>
</form>
HTML;
        return $html;
    }


    public function returnImage($val){
        $html = "";
        if($val == -2){
            $html = "<img src='images/h1.png' alt='one horizontal bridge'>";
        }
        else if($val == -3){
            $html = "<img src='images/h2.png' alt='two horizontal bridges'>";
        }
        else if($val == -4){
            $html = "<img src='images/v1.png' alt='one vertical bridge'>";
        }
        else if($val == -5){
            $html = "<img src='images/v2.png' alt='two vertical bridges'>";
        }
        return $html;
    }

    public function game()
    {
        $html = '<table><caption></caption>';
        $size = 8;        // 8 x 8 grid...



        $islands = $this->islands1;

        for ($r = 0; $r < $size; $r++) {
            $html .= "<tr>";
            for ($c = 0; $c < $size; $c++) {
                /*
                 * This determines if this is an island so I
                 * can illustrate how to create an island. I
                 * do not recommend that you solve the problem
                 * this way, though. You should have some sort
                 * of array to store this stuff in, instead.
                 */
                $isIsland = false;
                foreach ($islands as $island) {
                    if ($r == $island[1] && $c == $island[2]) {
                        $isIsland = true;
                        break;
                    }
                }

                if ($isIsland) {
                    // Add class="clicked" for an island that has been
                    // clicked on...
                    $num = $island[0];
                    $html .= <<<HTML
<td class="island"><button name="island" value="$r,$c">$num</button></td>
HTML;
                } else {
                    $html .= "<td>&nbsp;</td>";
                }

            }

            $html .= "</tr>";
        }

        $html .= "</table>";
        return $html;
    }

    public function presentBoard(){
        $html = '<table><caption></caption>';
        //echo $this->island->getBoard();
        for($x=0;$x<$this->island->getSize();$x++){
            $html .= "<tr>";
            for($y=0;$y<$this->island->getSize();$y++)
            {
                if($this->island->getChecked() &&$this->board[$x][$y] != $this->winBoard[$x][$y]){ // $this->usedTiles[$x][$y] == -1){ // $this->board[$x][$y] != $this->winBoard[$x][$y]
                    //Make all the open spots bad
                    $html .= '<td class="bad">';
                    if($this->board[$x][$y] != -1){
                        $html .= $this->returnImage($this->board[$x][$y]);
                    }
                    $html .= '</td>';
                }
                else if($this->board[$x][$y] == -2){
                    $html .= "<td><img src='images/h1.png' alt='one horizontal bridge'></td>";
                }
                else if($this->board[$x][$y] == -3){
                    $html .= "<td><img src='images/h2.png' alt='two horizontal bridges'></td>";
                }
                else if($this->board[$x][$y] == -4){
                    $html .= "<td><img src='images/v1.png' alt='one vertical bridge'></td>";
                }
                else if($this->board[$x][$y] == -5){
                    $html .= "<td><img src='images/v2.png' alt='two vertical bridges'></td>";
                }
                else if($this->board[$x][$y] == 0 || $this->board[$x][$y] == -1  ){
                    //empty board spot
                    $html .= "<td>&nbsp;</td>";
                }
                else
                {
                    $btnClass = "";
                    if($this->island->getClickedTile() == array($x,$y)){
                        //echo $this->island->getClickedTile();
                        $btnClass = "clicked";
                    }
                    $num = $this->board[$x][$y];
                    //board spot
                    $html .= <<<HTML
<td class="island"><button class="$btnClass" name="island" value="$x,$y">$num</button></td>
HTML;
                }
            }
            $html .= "</tr>";
        }
        $html .= "</table>";
        return $html;
    }


    private $island;
    private $board;
    private $usedTiles;
    private $winBoard;
}