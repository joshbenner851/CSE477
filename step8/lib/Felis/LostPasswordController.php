<?php
/**
 * Created by PhpStorm.
 * User: joshbenner
 * Date: 4/1/16
 * Time: 7:04 AM
 */

namespace Felis;


class LostPasswordController
{

    public function __construct(Site $site, array $post) {
        $root = $site->getRoot();
        $this->redirect = "$root/";

        if(isset($post['ok'])){

            //
            // 1. Ensure the validator is correct! Use it to get the user ID.
            // 2. Destroy the validator record so it can't be used again!
            //
            $users = new Users($site);
            $email = strip_tags($post['email']);
            if($users->exists($email)){
                //send the user a validation email
                $mailer = new Email();
                $userId = $users->getByEmail($email);
                $user = $users->get($userId);
                $success = $users->sendEmail($user,$mailer);
                if($success === null){
                    echo "idk";
                }
                else{
                    echo $success;
                }
            }
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
}