<?php
/**
 * Created by PhpStorm.
 * User: joshbenner
 * Date: 3/21/16
 * Time: 9:38 PM
 */

namespace Felis;


class NewCaseController
{
    public function __construct(Site $site, $user, $post,$session)
    {
        $root = $site->getRoot();
        $caseNum = strip_tags($post['number']);
        if(isset($post["ok"])){
            $cases = new Cases($site);
            $id = $cases->insert(strip_tags($post['client']),
                $user->getId(),
                $caseNum);

            if($id === null) {
                $this->redirect = "$root/newcase.php?e";
            } else {
                $_SESSION['client'] = $post['client'];
                $this->redirect = "$root/case.php?id=$caseNum";
            }
            //$this->redirect = "$root/case.php?id=$id";
        }
        else if(isset($post["cancel"])){
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