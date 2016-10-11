<?php
/**
 * Created by PhpStorm.
 * User: joshbenner
 * Date: 3/23/16
 * Time: 3:42 AM
 */

namespace Felis;


class DeleteController
{
    public function __construct(Site $site,array $get, $post)
    {
        $root = $site->getRoot();
        $caseNum = $post['id'];
        if(isset($post["yes"])){
            $cases = new Cases($site);
            $id = $cases->fetchID($caseNum);
            $cases->delete($id);
        }
        $this->redirect = "$root/cases.php";
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