<?php
/**
 * Created by PhpStorm.
 * User: joshbenner
 * Date: 3/21/16
 * Time: 1:46 AM
 */

namespace Felis;


class CasesController
{

    public function __construct(Site $site, $post)
    {
        $root = $site->getRoot();
        $id = strip_tags($post['id']);
        if(isset($post["add"])){
            $this->redirect = "$root/newcase.php";
        }
        else if(isset($post["delete"])){
            $this->redirect = "$root/deletecase.php?id=$id";
        }
        else{
            $this->redirect = "$root/cases.php";
        }
    }

    /**
     * @return mixed
     */
    public function getRedirect()
    {
        return $this->redirect;
    }	///< Page we will redirect the user to.

    public function setRedirect($redirect){
        $this->redirect = $redirect;
    }



    private $redirect;
}