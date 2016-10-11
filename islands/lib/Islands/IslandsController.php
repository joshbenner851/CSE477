<?php
/**
 * Created by PhpStorm.
 * User: joshbenner
 * Date: 4/26/16
 * Time: 11:06 PM
 */

namespace Islands;


class IslandsController
{

    public function __construct($post,$session, Game $game)
    {

        $name = strip_tags($post['name']);
        if(isset($post['start']) && isset($post['name']) && $name != ""){
            $game->setName($name);
            $gameNum = strip_tags($post['game']);
            //var_dump($gameNum);
            $game->setBoard($gameNum);

            $this->redirect = "$this->root/islands.php";
        }
        else{
            $this->redirect = "$this->root";
        }
    }

    /**
     * @return mixed
     */
    public function getRedirect()
    {
        return $this->redirect;
    }	///< Page we will redirect the user to.

    private $redirect;
    private $root = "/~bennerjo/exam";
}