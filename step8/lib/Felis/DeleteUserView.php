<?php
/**
 * Created by PhpStorm.
 * User: joshbenner
 * Date: 4/1/16
 * Time: 5:28 AM
 */

namespace Felis;


class DeleteUserView extends View
{
    /**
     * Constructor
     * Sets the page title and any other settings.
     */
    public function __construct(Site $site,array $get, array $session) {
        parent::__construct($site, $get, $session);
        $this->setTitle("Felis Investigations Users");
        $this->addLink("staff.php","Staff");
        $this->addLink("users.php","Users");
        $this->addLink("./","Log out");
        $this->site = $site;
    }

    public function present(){
        $user = new Users($this->site);
        $userNameID = strip_tags($this->get['userName']);
        $userName = $user->get($userNameID)->getName();
        $hidden = '<input type="hidden" name="id" value="' . $userNameID . '">';

        $html = <<<HTML
<form method="post" action="post/delete-user.php">
$hidden
	<fieldset>
		<legend>Delete?</legend>
		<p>Are you sure absolutely certain beyond a shadow of
			a doubt that you want to delete user $userName?</p>

		<p>Speak now or forever hold your peace.</p>

		<p><input type="submit" name="yes" id="yes" value="Yes"> <input type="submit" name="no" id="no" value="No"></p>

	</fieldset>
</form>
HTML;
        return $html;

    }

}