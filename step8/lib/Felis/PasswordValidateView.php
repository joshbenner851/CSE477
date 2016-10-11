<?php
/**
 * Created by PhpStorm.
 * User: joshbenner
 * Date: 4/1/16
 * Time: 12:48 AM
 */

namespace Felis;


class PasswordValidateView extends View
{
    public function __construct(Site $site, array $get, array $session)
    {
        parent::__construct($site, $get, $session);
        $this->setTitle("Felis Password Entry");
        $this->validator = strip_tags($get['v']);
        if(isset($session['errorMsg'])){
            $this->error = $session['errorMsg'];
        }
    }

    public function present(){
        $html = "<p>$this->error</p>";
        $html .= <<<HTML
<div class="password">
    <form action="post/password-validate.php" method="post">
        <input type="hidden" name="validator" value="$this->validator">
        <fieldset>
            <legend>Change Password</legend>
            <p>
                <label for="email">Email</label><br>
                <input type="email" id="email" placeholder="Email">
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
</div>
HTML;
        return $html;
    }

    private $error = "";
    private $validator;
}