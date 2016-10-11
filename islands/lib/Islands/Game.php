<?php
/**
 * Created by PhpStorm.
 * User: joshbenner
 * Date: 4/27/16
 * Time: 1:48 AM
 */

namespace Islands;


class Game
{

    public function __construct()
    {

    }

    public function setName($name){
        $this->name = $name;
    }

    public function getName(){
        return $this->name;
    }

    public function getChecked(){
        return $this->checked;
    }

    public function flipChecked($bool){
        $this->checked = $bool;
    }

    public function getClicked(){
        return $this->clicked;
    }

    public function setClicked($value){
        $this->clicked = $value;
    }

    /**
     * @return array
     */
    public function getClickedTile()
    {
        return $this->clickedTile;
    }

    /**
     * @param array $clickedTile
     */
    public function setClickedTile($clickedTile)
    {
        $this->clickedTile = $clickedTile;
    }

    public function giveUp(){
        $this->board = $this->winBoard;
    }

    /**
     * Initializes the board to be filled with zeroes
     */
    public function initBoard(){
        //build the 8x8 board array
        for ($x = 0; $x < $this->size; $x++) {
            array_push($this->board,array(0,0,0,0,0,0,0,0));
        }
        //var_dump($this->board);
    }

    /**Builds the initial board filled with islands and -1's where there's needed things
     * @param $value
     */
    public function setBoard($value)
    {
        $this->initBoard();
        $this->winBoard = $this->board;
        $islands = $value == 1 ? $this->islands1 : $this->islands2;
        //var_dump($islands);
        foreach($islands as $island){
            $r = $island[1];
            $c = $island[2];
            $rightVal = $island[3] == 1 ? -2 : -3;
            $downVal = $island[5] == 1 ? -4 : -5;
            $right = $island[4];
            $down = $island[6];
            $this->board[$r][$c] = $island[0];
            $this->winBoard[$r][$c] = $island[0];
            //update the spots to the right
            for ($x = 1; $x <= $right; $x++) {
                $this->board[$r][$c+$x] = -1;
                $this->winBoard[$r][$c+$x] = $rightVal;
            }
            for($y = 1; $y <= $down; $y++){
                $this->board[$r+$y][$c] = -1;
                $this->winBoard[$r+$y][$c] = $downVal;
            }
        }
        $this->usedTiles = $this->board; //Copy the board into a check board
        //var_dump($this->winBoard);
    }

    /** Gets the value of the tile to place
     * @param $tile
     * @param $dir
     * @return int
     */
    public function getValue($tile,$dir){
        if($dir == 0){
            if($tile == 0 || $tile == -1){return -2;}
            else if($tile == -2){return -3;}
            else{return 0;}
        }
        else{
            if($tile == 0 || $tile == -1){return -4;}
            else if($tile == -4){return -5;}
            else{return 0;}
        }

    }

    public function checkWin(){
        $win = $this->board == $this->winBoard ? true : false;
        return $win;
    }

    /** Checks if there's another Bridge or Island in the way
     * @param $r
     * @param $c
     * @return bool, false if no obstacle
     */
    public function isObstacles($r,$c){
        //Are we moving vertically?
        if($r != $this->clickedTile[0]) {
//            echo "vertical";
//            echo "dist x:" . $r . " clicked: " . $this->clickedTile[0] . "\n";
            $dist = abs($r - $this->clickedTile[0]);
            //echo "dist: " . $dist;
            //if r > then the previous clicked direction, default is moving down
            $direction = $r > $this->clickedTile[0] ? true : false;
            for ($i = 1; $i < $dist; $i++) {
                //moving down
                if ($direction) {
                    $val = $this->board[$this->clickedTile[0]+$i][$c];
                    if($val != 0 && $val != -1 && $val != -4 && $val != -5){
                        echo "val: " . $val;
                        return true;
                        break;
                    }
                }
                else{
                    $val = $this->board[$this->clickedTile[0]-$i][$c];
                    if($val != 0 && $val != -1 && $val != -4 && $val != -5){
                        return true;
                        break;
                    }
                }
            }
        }
        else{
                //echo "horz \n";
                //echo "dist x:" . $c . " clicked: " . $this->clickedTile[1] . "\n";
                $dist = abs($c - $this->clickedTile[1]);
                //echo "dist: " . $dist;
                //if c < then the clicked direction, default is moving right
                $direction = $c > $this->clickedTile[1] ? true : false;

                //Loop for number of tiles to lay between
                for($i=1;$i < $dist;$i++){
                    if($direction) {
                        $val = $this->board[$r][$this->clickedTile[1]+$i];
                        if($val != 0 && $val != -1 && $val != -2 && $val != -3){
                            return true;
                            break;
                        }
                    }
                    else{
                        $val = $this->board[$r][$this->clickedTile[1]-$i];
                        if($val != 0 && $val != -1 && $val != -2 && $val != -3){
                            return true;
                            break;
                        }
                    }
                }
        }
        return false;
    }


    /** Lays the tile down
     * @param $r
     * @param $c
     * @return bool
     */
    public function layTile($r,$c){
        //Checking that it's either a horizontal or vertical tile lay
        if($r == $this->clickedTile[0] || $c == $this->clickedTile[1])
        {
            //See if any bridges or islands in the way
            //checkObstacles
            if($this->isObstacles($r,$c)){
                //Can't lay the tile
                return false;
            }
            //If not we are moving vertically
            if($r != $this->clickedTile[0]){
                //echo "vertical";
                //echo "dist x:" . $r . " clicked: " . $this->clickedTile[0] . "\n";
                $dist = abs($r - $this->clickedTile[0]);
                //echo "dist: " . $dist;
                //if r > then the previous clicked direction, default is moving down
                $direction = $r > $this->clickedTile[0] ? true : false;

                //Loop for number of tiles to lay between
                for($i=1;$i < $dist;$i++){
                    if($direction){
                        echo "moving down";
                        //value = -2 if one bridge, -3 if change to 2bridge, or -1 if back to no bridge
                        $value = $this->getValue($this->board[$this->clickedTile[0] + $i][$c],1);
                        echo "\n val: " . $value;
                        $this->board[$this->clickedTile[0] + $i][$c] = $value;
                    }
                    else{
                        echo "moving up";
                        $value = $this->getValue($this->board[$this->clickedTile[0]-$i][$c],1);
                        //subtract from x because moving left
                        $this->board[$this->clickedTile[0]-$i][$c] = $value;
                    }
                }
            }
            //Moving horizontally
            else{
                //echo "horz \n";
                //echo "dist x:" . $c . " clicked: " . $this->clickedTile[1] . "\n";
                $dist = abs($c - $this->clickedTile[1]);
                //echo "dist: " . $dist;
                //if c < then the clicked direction, default is moving right
                $direction = $c > $this->clickedTile[1] ? true : false;

                //Loop for number of tiles to lay between
                for($i=1;$i < $dist;$i++){
                    if($direction){
                        //echo "moving right";
                        //value = -2 if one bridge, -3 if change to 2bridge, or -1 if back to no bridge
                        $value = $this->getValue($this->board[$r][$this->clickedTile[1]+$i],0);
                        echo "\n val: " . $value;
                        $this->board[$r][$this->clickedTile[1]+$i] = $value;
                    }
                    else{
                        // echo "moving left";
                        $value = $this->getValue($this->board[$r][$this->clickedTile[1]-$i],0);
                        //subtract from x because moving left
                        $this->board[$r][$this->clickedTile[1]-$i] = $value;
                    }
                }
                //var_dump($this->board);
            }
            return true;
        }
        else{
            return false;
        }
    }


    public function getBoard(){
        return $this->board;
    }

    public function getSize(){
        return $this->size;
    }

    public function setErrorMsg($msg){
        $this->errorMsg = $msg;
    }

    public function getErrorMsg(){
        return $this->errorMsg;
    }

    public function getUsedTiles(){
        return $this->usedTiles;
    }

    public function getWinBoard(){
        return $this->winBoard;
    }


    private $size = 8;        // 8 x 8 grid...
    private $name = "";
    private $checked = false;

    //[0] = island number of bridges
    //[1] and [2] = x & y
    //[3] and [5] = number of bridges to right and down
    //[4] and [6] = number of spots the bridges span right and down
    private $islands1 = array(
            array(3, 0, 1, 2, 2, 1, 2),
            array(4, 0, 4, 1, 2, 1, 1),
            array(2, 0, 7, 0, 0, 1, 1),
            array(1, 1, 0, 0, 0, 1, 2),
            array(2, 1, 6, 0, 0, 2, 2),
            array(1, 2, 2, 1, 1, 0, 0),
            array(3, 2, 4, 0, 0, 1, 1),
            array(3, 2, 7, 0, 0, 2, 2),
            array(5, 3, 1, 2, 1, 2, 1),
            array(2, 3, 3, 0, 0, 0, 0),
            array(2, 4, 0, 0, 0, 1, 1),
            array(3, 4, 2, 2, 1, 1, 1),
            array(7, 4, 4, 2, 1, 2, 2),
            array(6, 4, 6, 0, 0, 2, 1),
            array(2, 5, 1, 0, 0, 0, 0),
            array(3, 5, 7, 0, 0, 1, 1),
            array(3, 6, 0, 2, 1, 0, 0),
            array(3, 6, 2, 0, 0, 0, 0),
            array(2, 6, 6, 0, 0, 0, 0),
            array(1, 7, 1, 1, 2, 0, 0),
            array(4, 7, 4, 1, 2, 0, 0),
            array(2, 7, 7, 0, 0, 0, 0)
        ); //Array of Islands and their respective values
    private $islands2 = array(
            array(3, 0, 0, 2, 2, 1, 1),
            array(5, 0, 3, 2, 1, 1, 2),
            array(6, 0, 5, 2, 1, 2, 1),
            array(3, 0, 7, 0, 0, 1, 1),
            array(2, 1, 1, 0, 0, 2, 1),
            array(1, 1, 6, 0, 0, 1, 1),
            array(2, 2, 0, 0, 0, 1, 1),
            array(2, 2, 5, 0, 0, 0, 0),
            array(1, 2, 7, 0, 0, 0, 0),
            array(3, 3, 1, 1, 1, 0, 0),
            array(6, 3, 3, 2, 2, 2, 1),
            array(3, 3, 6, 0, 0, 0, 0),
            array(5, 4, 0, 2, 1, 2, 1),
            array(3, 4, 2, 0, 0, 1, 1),
            array(2, 5, 1, 0, 0, 2, 1),
            array(3, 5, 3, 1, 1, 0, 0),
            array(2, 5, 5, 1, 1, 0, 0),
            array(3, 5, 7, 0, 0, 2, 1),
            array(2, 6, 0, 0, 0, 0, 0),
            array(2, 6, 2, 1, 1, 0, 0),
            array(2, 6, 4, 1, 1, 0, 0),
            array(1, 6, 6, 0, 0, 0, 0),
            array(4, 7, 1, 2, 1, 0, 0),
            array(3, 7, 3, 1, 1, 0, 0),
            array(2, 7, 5, 1, 1, 0, 0),
            array(3, 7, 7, 0, 0, 0, 0)
        ); //Array of Islands and their respective values
    private $clicked = false;
    private $board = array();
    private $clickedTile = array(); //[0] = row, [1] = col
    private $errorMsg = "";
    private $usedTiles = array(); //Holds the array for the board with tiles total
    private $winBoard = array(); //Holds the winning board
}