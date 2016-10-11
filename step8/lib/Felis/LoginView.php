<?php
/**
 * Created by PhpStorm.
 * User: joshbenner
 * Date: 3/20/16
 * Time: 4:29 AM
 */

namespace Felis;


class LoginView extends View
{

    public function __construct(array &$session, array $get)
    {
        if(isset($get['e'])){
            $this->error = $session["error"];
        }
    }

    public function displayError(){
        if($this->error !== null){
            return "<p class='errorMessage'>$this->error</p>";
        }
        else{
            return "";
        }
    }

    private $error= "";

}