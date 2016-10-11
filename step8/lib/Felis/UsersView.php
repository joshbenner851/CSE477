<?php
/**
 * Created by PhpStorm.
 * User: joshbenner
 * Date: 3/22/16
 * Time: 2:54 AM
 */

namespace Felis;


class UsersView extends View
{

    /**
     * Constructor
     * Sets the page title and any other settings.
     */
    public function __construct(Site $site, $get, $session) {
        parent::__construct($site, $get, $session);
        $this->setTitle("Felis Users");
        $this->addLink("staff.php","Staff");
        $this->addLink("./","Logout");

    }

    public function present() {
		$html = <<<HTML
<form method="post" action="post/users.php" class="table">
	<p>
	<input type="submit" name="add" id="add" value="Add">
	<input type="submit" name="edit" id="edit" value="Edit">
	<input type="submit" name="delete" id="delete" value="Delete">
	</p>

	<table>
		<tr>
			<th>&nbsp;</th>
			<th>Name</th>
			<th>Email</th>
			<th>Role</th>
		</tr>
HTML;

        $users = new Users($this->site);
        $usersArray = $users->getUsers();
        foreach($usersArray as $user){
            $id = $user->getId();
            $name = $user->getName();
            $email = $user->getEmail();
            $role = $user->getRole();
            $html .= <<<HTML
    <tr>
        <td><input type="radio" value="$id" name="userName"></td>
        <td>$name</td>
        <td>$email</td>
        <td>$role</td>
    </tr>
HTML;
        }

    $html .= <<<HTML
	</table>
</form>
HTML;

		return $html;
	}
}