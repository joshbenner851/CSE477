<?php
/**
 * Created by PhpStorm.
 * User: joshbenner
 * Date: 3/20/16
 * Time: 1:19 AM
 */

namespace Felis;


class Users extends Table
{
    /**
     * Users constructor.
     * @param Site $site
     */
    public function __construct(Site $site)
    {
        parent::__construct($site, "user");
    }

    /**
     * Test for a valid login.
     * @param $email User email
     * @param $password Password credential
     * @returns User object if successful, null otherwise.
     */
    public function login($email, $password) {
         $sql =<<<SQL
SELECT * from $this->tableName
where email=?
SQL;

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);

        $statement->execute(array($email));
        if($statement->rowCount() === 0) {
            return null;
        }

        $row = $statement->fetch(\PDO::FETCH_ASSOC);

        // Get the encrypted password and salt from the record
        $hash = $row['password'];
        $salt = $row['salt'];

        // Ensure it is correct
        if($hash !== hash("sha256", $password . $salt)) {
            return null;
        }

        return new User($row);
    }

    /**
     * Determine if a user exists in the system.
     * @param $email An email address.
     * @returns true if $email is an existing email address
     */
    public function exists($email) {
         $sql =<<<SQL
    SELECT * from $this->tableName
    where email=?
SQL;

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);

        $statement->execute(array($email));
        return $statement->rowCount() >= 1 ? true : false;
//        if($statement->rowCount() >= 1){
//            return true;
//        }
//        else{
//            return false;
//        }
    }

    /**
     * Gets the users id by their email
     * @param $email
     * @return mixed
     */
    public function getByEmail($email){
            $sql =<<<SQL
    SELECT id from $this->tableName
    where email=?
SQL;

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);

        $statement->execute(array($email));
        $stuff = $statement->fetch(\PDO::FETCH_ASSOC);
        return $stuff['id'];
    }

    /**
     * Create a new user.
     * @param User $user The new user data
     * @param Email $mailer An Email object to use
	   * @return null on success or error message if failure
     */
    public function add(User $user, Email $mailer) {
         // Ensure we have no duplicate email address
        if($this->exists($user->getEmail())) {
            return "Email address already exists.";
        }

        // Add a record to the user table
        $sql = <<<SQL
INSERT INTO $this->tableName(email, name, phone, address, notes, joined, role)
values(?, ?, ?, ?, ?, ?, ?)
SQL;

        $statement = $this->pdo()->prepare($sql);
        $statement->execute(array(
            $user->getEmail(), $user->getName(), $user->getPhone(), $user->getAddress(),
            $user->getNotes(), date("Y-m-d H:i:s"), $user->getRole()));
        $id = $this->pdo()->lastInsertId();

        // Create a validator and add to the validator table
		$validators = new Validators($this->site);
		$validator = $validators->newValidator($id);

        // Send email with the validator in it
        $link = "http://webdev.cse.msu.edu"  . $this->site->getRoot() .
            '/password-validate.php?v=' . $validator;
        $from = $this->site->getEmail();
        $name = $user->getName();

        $subject = "Confirm your email";
        $message = <<<MSG
<html>
<p>Greetings, $name,</p>

<p>Welcome to Felis. In order to complete your registration,
please verify your email address by visiting the following link:</p>

<p><a href="$link">$link</a></p>
</html>
MSG;
         $headers = "MIME-Version: 1.0\r\nContent-type: text/html; charset=iso=8859-1\r\nFrom: $from\r\n";
        $mailer->mail($user->getEmail(), $subject, $message, $headers);


        return null;
    }

    public function sendEmail(User $user, Email $mailer){
        $id = $user->getId();

        // Create a validator and add to the validator table
		$validators = new Validators($this->site);
		$validator = $validators->newValidator($id);

        // Send email with the validator in it
        $link = "http://webdev.cse.msu.edu"  . $this->site->getRoot() .
            '/password-validate.php?v=' . $validator;
        $from = $this->site->getEmail();
        $name = $user->getName();

        $subject = "Confirm your email";
        $message = <<<MSG
<html>
<p>Greetings, $name,</p>

<p>Welcome to Felis. In order to complete your registration,
please verify your email address by visiting the following link:</p>

<p><a href="$link">$link</a></p>
</html>
MSG;
         $headers = "MIME-Version: 1.0\r\nContent-type: text/html; charset=iso=8859-1\r\nFrom: $from\r\n";
        $mailer->mail($user->getEmail(), $subject, $message, $headers);
        return null;
    }


    public function deleteUser($id){
        $sql = <<<SQL
delete from $this->tableName
where id=?
SQL;
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array($id));
    }
    /**
     * Get a user based on the id
     * @param $id ID of the user
     * @returns User object if successful, null otherwise.
     */
    public function get($id) {
        $sql =<<<SQL
    SELECT * from $this->tableName
    where id=?
SQL;
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array($id));
        if($statement->rowCount() === 0) {
            return null;
        }

        return new User($statement->fetch(\PDO::FETCH_ASSOC));
    }


    public function getAgents(){
        $sql = <<<SQL
select * from $this->tableName
where role='A'
SQL;
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute();
        if($statement->rowCount() === 0) {
            return null;
        }
        $agents = $statement->fetchAll(\PDO::FETCH_ASSOC);
        $agentsArray = array();
        foreach($agents as $agent){
            $detective = new User($agent);
            array_push($agentsArray,$detective);
        }
        return $agentsArray;
    }

    public function getUsers(){
                $sql = <<<SQL
select * from $this->tableName
SQL;
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute();
        if($statement->rowCount() === 0) {
            return null;
        }
        $users = $statement->fetchAll(\PDO::FETCH_ASSOC);
        $usersArray = array();
        foreach($users as $user){
            $usr = new User($user);
            array_push($usersArray,$usr);
        }
        return $usersArray;
    }

    /**
	 * Set the password for a user
	 * @param $userid The ID for the user
	 * @param $password New password to set
	 */
	public function setPassword($userid, $password) {
        $salt = $this->randomSalt();
        $hashedPass= $this->hash_pw($password,$salt);
        $sql = <<<SQL
update $this->tableName
set password=?, salt=?
where id=?
SQL;
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array($hashedPass,$salt,$userid));
	}

    /**
	 * @brief Encrypt a password using salt
	 */
	private function hash_pw($password,$salt) {
		return hash("sha256", $password . $salt);
	}

    /**
     * Generate a random salt string of characters for password salting
     * @param $len Length to generate, default is 16
     * @returns Salt string
     */
    public static function randomSalt($len = 16) {
        $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789`~!@#$%^&*()-=_+';
        $l = strlen($chars) - 1;
        $str = '';
        for ($i = 0; $i < $len; ++$i) {
            $str .= $chars[rand(0, $l)];
        }
        return $str;
    }

    /**
	 * Modify a user record based on the contents of a User object
	 * @param User $user User object for object with modified data
	 * @return true if successful, false if failed or user does not exist
	 */
	public function update(User $user) {
        if($this->get($user->getId()) == null){
            return false;
        }

        try {
            $data = array($user->getEmail(),$user->getName(),$user->getPhone(),$user->getAddress(),
                $user->getNotes(),$user->getRole(),$user->getId());

            $sql =<<<SQL
    UPDATE $this->tableName
    SET email=?, name=?, phone=?, address=?, notes=?, role=?
    where id=?
SQL;
            //echo $this->sub_sql($sql,array($data));
            $pdo = $this->pdo();
            $statement = $pdo->prepare($sql);
            $statement->execute($data);
        } catch(\PDOException $e) {
            // do something when the exception occurs...
            return false;
        }

        return true;
	}


    /**
     * @return array|null
     */
    public function getClients(){
        $sql = <<<SQL
select name, id from $this->tableName
where role='C'
SQL;
         $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute();
        if($statement->rowCount() === 0) {
            return null;
        }
        $users = $statement->fetchAll(\PDO::FETCH_ASSOC);
        $usersArray = array();
        foreach($users as $user){
            //$person = new User($user);
            array_push($usersArray,$user);
        }
        return $usersArray;




    }

}