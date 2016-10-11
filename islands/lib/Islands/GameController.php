<?php
/**
 * Created by PhpStorm.
 * User: joshbenner
 * Date: 4/26/16
 * Time: 11:48 PM
 */

namespace Islands;


class GameController
{

    /**
     * GameController constructor.
     * @param $post
     */
    public function __construct(Game $game,$post)
    {
        if(isset($post['check'])){
            //flip the

            if($game->checkWin()){
                $game->setErrorMsg("<p>You Win!</p>");
            }
            else{
                $game->flipChecked(true);
                $game->setErrorMsg("<p>Solution is not correct</p>");
            }
            $this->redirect = "$this->root/islands.php";
        }
        else if(isset($post['giveup'])){
            //show board
            $game->giveUp();
            $this->redirect = "$this->root/islands.php";
        }
        else if(isset($post['newgame'])){
            //Redirect to home?
            $this->reset = true;
            $this->redirect = "$this->root/";
        }
        else if(isset($post['island'])){
            $game->flipChecked(false);
            $coords = explode(",",strip_tags($post['island']));
            $r = $coords[0];
            $c = $coords[1];
            if(!$game->getClicked()){

                //set the island to be highlighted
                $game->setClickedTile(array($r,$c));
                //set clicked to true;
                $game->setClicked(true);
                $game->setErrorMsg("");
            }
            else{
                //delete the highlight and see if you can connect bridges
                $validTile = $game->layTile($r,$c);
                //echo $validTile;
                //var_dump($game->getBoard());
                if(!$validTile){
                    //Check if the clicked tile is valid, if not set error message
                    $game->setErrorMsg("<p>Islands cannot be connected</p>");
                }
                //reset clicked and clicked tile
                $game->setClicked(false);
                $game->setClickedTile(array(-9,-9));
            }
            $this->redirect = "$this->root/islands.php";
        }
    }

    /**
     * @return mixed
     */
    public function getRedirect()
    {
        return $this->redirect;
    }	///< Page we will redirect the user to.

    public function isReset(){
        return $this->reset;
    }

    private $redirect;
    private $root = "/~bennerjo/exam";
    private $reset = false;

}