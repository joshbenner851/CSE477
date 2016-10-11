<?php
/**
 * Created by PhpStorm.
 * User: joshbenner
 * Date: 4/1/16
 * Time: 5:34 AM
 */

namespace Felis;


class DeleteUserController
{

    public function __construct(Site $site,array $get, $post)
    {
        $root = $site->getRoot();
        $userId = $post['id'];
        if(isset($post["yes"])){
            $users = new Users($site);
            $id = $users->deleteUser($userId);
        }
        $this->redirect = "$root/users.php";
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