<?php
/**
 * Created by PhpStorm.
 * User: joshbenner
 * Date: 3/20/16
 * Time: 3:53 AM
 */

namespace Felis;


class LoginController
{

    /**
     * LoginController constructor.
     * @param Site $site The Site object
     * @param array $session $_SESSION
     * @param assay $post $_POST
     */
    public function __construct(Site $site, array &$session, array $post)
    {
        // Create a Users object to access the table
        $users = new Users($site);

        $email = strip_tags($post['email']);
        $password = strip_tags($post['password']);
        $user = $users->login($email, $password);
        $session[User::SESSION_NAME] = $user;
        $root = $site->getRoot();
        if($user === null){
            // Login failed
            $this->redirect = "$root/login.php?e";
            $session["error"] = "The login credentials were incorrect";
        } else{
            if($user->isStaff()){
                $this->redirect = "$root/staff.php";
            }
            else{
                $this->redirect = "$root/client.php";
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



    private $redirect;


}