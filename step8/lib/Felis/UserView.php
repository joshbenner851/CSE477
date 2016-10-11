<?php
/**
 * Created by PhpStorm.
 * User: joshbenner
 * Date: 3/22/16
 * Time: 2:54 AM
 */

namespace Felis;


class UserView extends View
{

    /**
     * Constructor
     * Sets the page title and any other settings.
     */
    public function __construct(Site $site, $get, $session) {
        parent::__construct($site, $get, $session);
        $this->setTitle("Felis User");
        $this->addLink("staff.php","Staff");
        $this->addLink("users.php","Users");
        $this->addLink("./","Logout");
        $this->userid = $session['userId'];
    }

    public function present() {
        $users = new Users($this->site);
        $user = $users->get($this->userid);
        $email = '';
        $name = '';
        $phone = '';
        $address = '';
        $notes = '';
        if($user !== null){
            $email = $user->getEmail();
            $name = $user->getName();
            $phone = $user->getPhone();
            $address = $user->getAddress();
            $notes = $user->getNotes();
        }

        $hidden = '<input type="hidden" name="id" value="' . $this->userid . '">';
		$html = <<<HTML
<form method="post" action="post/user.php">
$hidden
	<fieldset>
		<legend>User</legend>
		<p>
			<label for="email">Email</label><br>
			<input type="email" id="email" name="email" value="$email" placeholder="email">
		</p>
		<p>
			<label for="name">Name</label><br>
			<input type="text" id="name" name="name" value="$name" placeholder="name">
		</p>
		<p>
			<label for="phone">Phone</label><br>
			<input type="text" id="phone" name="phone" value="$phone" placeholder="phone">
		</p>
		<p>
			<label for="address">Address</label><br>
			<textarea id="address" name="address" placeholder="$address"></textarea>
		</p>
		<p>
			<label for="notes">Notes</label><br>
			<textarea id="notes" name="notes" placeholder="$notes"></textarea>
		</p>
		<p>
			<label for="role">Role: </label>
			<select id="role" name="role">
				<option value="admin">Admin</option>
				<option value="staff">Staff</option>
				<option value="client">Client</option>
			</select>
		</p>
		<p>
			<input type="submit" name="ok" value="OK"> <input type="submit" name="cancel" value="Cancel">
		</p>

	</fieldset>
</form>
HTML;

		return $html;
	}

    private $userid;
}