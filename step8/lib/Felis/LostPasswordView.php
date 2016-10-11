<?php
/**
 * Created by PhpStorm.
 * User: joshbenner
 * Date: 4/1/16
 * Time: 7:12 AM
 */

namespace Felis;


class LostPasswordView extends View
{
    public function __construct(Site $site, array $get, array $session)
    {
        parent::__construct($site, $get, $session);
        $this->setTitle("Lost Password");
    }

    public function present(){
    $html = <<<HTML
    <form action="post/lostpassword.php" method="post">
       <fieldset>
            <legend>Change Password</legend>
            <p>
                <label for="email">Email</label><br>
                <input type="email" name="email" id="email" placeholder="Email">
            </p>
            <p>
                <label for="password">Password</label><br>
                <input type="password" id="password" name="password" placeholder="Password">
            </p>
            <p>
                <label for="passwordCheck">Confirm password</label><br>
                <input type="password" id="passwordCheck" name="passwordCheck" placeholder="Password">
            </p>
            <p>
                <input type="submit" name="ok" id="ok" value="OK">
                <input type="submit" name="cancel" id="cancel" value="Cancel">
            </p>
        </fieldset>
    </form>
HTML;
    return $html;
    }
}