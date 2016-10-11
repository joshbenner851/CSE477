<?php
/**
 * Created by PhpStorm.
 * User: joshbenner
 * Date: 4/1/16
 * Time: 2:05 AM
 */

namespace Felis;


class PasswordValidateController
{
    public function __construct(Site $site, array $post) {
        $root = $site->getRoot();
        $this->redirect = "$root/";

        if(isset($post['ok'])){

            //
            // 1. Ensure the validator is correct! Use it to get the user ID.
            // 2. Destroy the validator record so it can't be used again!
            //
            $validators = new Validators($site);
            $userid = $validators->getOnce($post['validator']);
            if($userid === null) {
                echo "got here";
                $this->redirect = "$root/";
                return;
            }

            $users = new Users($site);
            $editUser = $users->get($userid);
            if($editUser === null) {
                // User does not exist!
                $this->redirect = "$root/";
                return;
            }
            $email = trim(strip_tags($post['email']));
            if($email !== $editUser->getEmail()) {
                // Email entered is invalid
                $_SESSION['errorMsg'] = "Email is invalid";
                $this->redirect = "password-validate.php?e";
                return;
            }

            $password1 = trim(strip_tags($post['password']));
            $password2 = trim(strip_tags($post['password2']));
            if($password1 !== $password2) {
                // Passwords do not match
                $_SESSION['errorMsg'] = "Passwords do not match";
                $this->redirect = "password-validate.php?e";
                return;
            }

            if(strlen($password1) < 8) {
                // Password too short
                $_SESSION['errorMsg'] = "Password too short";
                $this->redirect = "password-validate.php?e";
                return;
            }

            $users->setPassword($userid, $password1);

        }
        else{
            $this->redirect = "$root/";
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