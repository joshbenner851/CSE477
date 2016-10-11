<?php

namespace Noir;

/**
 * Controller class for the Login page
 */
class LoginController extends Controller {

	/**
	 * HomeController constructor.
	 * @param Site $site Site object
	 * @param array $post $_POST
	 * @param array $session $_SESSION
	 */
	public function __construct(Site $site, $post, &$session) {
		parent::__construct($site, $session);

		$root = $site->getRoot();

		$user = strip_tags($post['user']);
		$password = strip_tags($post['password']);

		$login_session = "filmnoir_login";

		$prefix = $site->getTablePrefix();

		$host = 'mysql:host=mysql-user.cse.msu.edu;dbname=' . $user;
		$site->dbConfigure($host,
			$user,       // Database user
			$password,     // Database password
			$prefix);            // Table prefix

		try {
			new \PDO($host, $user, $password);
		} catch(\PDOException $e) {
			// If we can't connect...
			$this->redirect = "$root/login.php?e";
			return;
		}

		$session[$login_session] = array("user" => $user, "password" => $password);
		$site->startup();

		$this->redirect = "$root/";
	}

}