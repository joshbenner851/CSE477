<?php
require __DIR__ . "/../../vendor/autoload.php";
/** @file
 * @brief Empty unit testing template/database version
 * @cond 
 * @brief Unit tests for the class 
 */

class EmailMock extends Felis\Email {
    public function mail($to, $subject, $message, $headers)
    {
        $this->to = $to;
        $this->subject = $subject;
        $this->message = $message;
        $this->headers = $headers;
    }

    public $to;
    public $subject;
    public $message;
    public $headers;
}

class UsersTest extends \PHPUnit_Extensions_Database_TestCase
{
    public static function setUpBeforeClass(){
        self::$site = new Felis\Site();
        $localize = require 'localize.inc.php';
        if(is_callable($localize)){
            $localize(self::$site);
        }
    }

    public function test_construct() {
        $users = new Felis\Users(self::$site);
        $this->assertInstanceOf('Felis\Users', $users);
    }

	/**
     * @return PHPUnit_Extensions_Database_DB_IDatabaseConnection
     */
    public function getConnection()
    {
        return $this->createDefaultDBConnection(self::$site->pdo(), 'bennerjo');
    }

    /**
     * @return PHPUnit_Extensions_Database_DataSet_IDataSet
     */
    public function getDataSet()
    {
        return $this->createFlatXMLDataSet(dirname(__FILE__) . '/db/user.xml');
    }

    public function test_login() {
        $users = new Felis\Users(self::$site);

        // Test a valid login based on user ID
        $user = $users->login("dudess@dude.com", "87654321");
        $this->assertInstanceOf('Felis\User', $user);
        $this->assertContains("Dudess, The",$user->getName());
        $this->assertContains("111-222-3333",$user->getPhone());
        $this->assertContains("Dudess Address",$user->getAddress());
        $this->assertContains("Dudess Notes",$user->getNotes());
        //var_dump(time(),$user->getJoined());
        $this->assertEquals(1421988626,$user->getJoined());
        $this->assertContains("S",$user->getRole());

        // Test a valid login based on email address
        $user = $users->login("cbowen@cse.msu.edu", "super477");
        $this->assertInstanceOf('Felis\User', $user);

        // Test a failed login
        $user = $users->login("dudess@dude.com", "wrongpw");
        $this->assertNull($user);
    }

    public function test_exists() {
        $users = new Felis\Users(self::$site);

        $this->assertTrue($users->exists("dudess@dude.com"));
        $this->assertFalse($users->exists("dudess"));
        $this->assertFalse($users->exists("cbowen"));
        $this->assertTrue($users->exists("cbowen@cse.msu.edu"));
        $this->assertFalse($users->exists("nobody"));
        $this->assertFalse($users->exists("7"));
    }

    public function test_get(){
        $users = new Felis\Users(self::$site);
        $user = $users->get(7);
        $this->assertInstanceOf('Felis\User', $user);
        $this->assertContains("Dudess, The",$user->getName());
        $this->assertContains("111-222-3333",$user->getPhone());
        $this->assertContains("Dudess Address",$user->getAddress());
        $this->assertContains("Dudess Notes",$user->getNotes());
        //var_dump(time(),$user->getJoined());
        $this->assertEquals(1421988626,$user->getJoined());
        $this->assertContains("S",$user->getRole());

    }

    public function test_add() {
		$users = new Felis\Users(self::$site);

		$mailer = new EmailMock();

		$user7 = $users->get(7);
		$this->assertContains("Email address already exists",
			$users->add($user7, $mailer));

        $row = array('id' => 0,
            'email' => 'dude@ranch.com',
            'name' => 'Dude, The',
            'phone' => '123-456-7890',
            'address' => 'Some Address',
            'notes' => 'Some Notes',
            'password' => '12345678',
            'joined' => '2015-01-15 23:50:26',
            'role' => 'S'
        );
        $user = new Felis\User($row);
        $users->add($user, $mailer);

        $table = $users->getTableName();
        $sql = <<<SQL
select * from $table where email='dude@ranch.com'
SQL;

        $stmt = $users->pdo()->prepare($sql);
        $stmt->execute();
        $this->assertEquals(1, $stmt->rowCount());

        $this->assertEquals("dude@ranch.com", $mailer->to);
        $this->assertEquals("Confirm your email", $mailer->subject);
	}

    public function test_update(){
        $users = new Felis\Users(self::$site);

        $user = $users->get(7);
        $user->setEmail("josh@msu.edu");
        $user->setAddress("HKUST");
        $user->setName("josh");
        $user->setNotes("I love traveling");
        $user->setPhone("123456789");
        $user->setRole("A");

        // legitimate update of user
        $this->assertTrue($users->update($user));

        $row = array('id' => 12,
            'email' => 'jake@ranch.com',
            'name' => 'Dude, The',
            'phone' => '123-456-7890',
            'address' => 'Some Address',
            'notes' => 'Some Notes',
            'password' => '12345678',
            'joined' => '2015-01-15 23:50:26',
            'role' => 'A'
            );
        $fakeuser = new Felis\User($row);

        // This user doesn't exist
        $this->assertFalse($users->update($fakeuser));

        $fakeuser->setEmail("marge@bartman.com");

        // Violates the integrity constraint that emails must be unique
        $this->assertFalse($users->update($fakeuser));
    }

    public function test_setPassword() {
		$users = new Felis\Users(self::$site);

		// Test a valid login based on user ID
		$user = $users->login("dudess@dude.com", "87654321");
		$this->assertNotNull($user);
		$this->assertEquals("Dudess, The", $user->getName());

		// Change the password
		$users->setPassword(7, "dFcCkJ6t");

		// Old password should not work
		$user = $users->login("dudess@dude.com", "87654321");
		$this->assertNull($user);

		// New password does work!
		$user = $users->login("dudess@dude.com", "dFcCkJ6t");
		$this->assertNotNull($user);
		$this->assertEquals("Dudess, The", $user->getName());
	}



    private static $site;
}

/// @endcond
?>
