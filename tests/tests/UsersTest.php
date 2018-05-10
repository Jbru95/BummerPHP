<?php
require __DIR__ . "/../../vendor/autoload.php";
require_once("BaseDB.php");

/** @file
 * Unit tests for the class Users
 * @cond
 */


class EmailMock extends Bummer\Email {
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

class UsersTest extends BaseDB {
    /**
     * @return PHPUnit_Extensions_Database_DataSet_IDataSet
     */
    public function getDataSet() {
        return $this->createFlatXMLDataSet(dirname(__FILE__) . '/db/user.xml');
    }

    public function test_construct() {
        $users = new Bummer\Users(self::$site);
        $this->assertInstanceOf('Bummer\Users', $users);
    }

    public function test_login() {
        $users = new Bummer\Users(self::$site);

        // Test a valid login based on email address
        $user = $users->login("cbowen@cse.msu.edu", "super477");
        $this->assertInstanceOf('Bummer\User', $user);

        // Test attributes of resulting User object
        $this->assertEquals(1, $user->getId());
        $this->assertEquals("Charles Owen", $user->getName());
        $this->assertEquals("cbowen@cse.msu.edu", $user->getEmail());

        // Test a valid login based on email address
        $user = $users->login("bohllia1@msu.edu", "bummer!!");
        $this->assertInstanceOf('Bummer\User', $user);

        // Test a failed login
        $user = $users->login("cbowen@cse.msu.edu", "wrongpw");
        $this->assertNull($user);
        $user = $users->login("nonexistent@user.name", "wrongpw");
        $this->assertNull($user);
    }

    public function test_get() {
        $users = new Bummer\Users(self::$site);

        // Test a valid get
        $user = $users->get(27);
        $this->assertInstanceOf("Bummer\User", $user);

        // Test attributes of resulting User object
        $this->assertEquals(27, $user->getId());
        $this->assertEquals("Harold", $user->getName());
        $this->assertEquals("harold@yahoo.com", $user->getEmail());

        // Test a valid get
        $user = $users->get(3);
        $this->assertInstanceOf("Bummer\User", $user);

        // Test attributes of resulting User object
        $this->assertEquals(3, $user->getId());
        $this->assertEquals("Sarah", $user->getName());
        $this->assertEquals("Sarah@hotmail.com", $user->getEmail());

        // Test an invalid get
        $user = $users->get(-1000);
        $this->assertNull($user);
    }

    public function test_exists() {
        $users = new Bummer\Users(self::$site);

        $this->assertTrue($users->exists("bohllia1@msu.edu"));
        $this->assertFalse($users->exists("dudess@dude.com"));
        $this->assertFalse($users->exists("cbowen"));
        $this->assertTrue($users->exists("cbowen@cse.msu.edu"));
        $this->assertFalse($users->exists("nobody"));
        $this->assertFalse($users->exists("1"));
    }

    public function test_add() {
        $users = new Bummer\Users(self::$site);
        $mailer = new EmailMock();

        // Add existing user - should collide with email address
        $user27 = $users->get(27);
        $this->assertContains("Email address already exists",
            $users->add($user27, $mailer));

        // Add valid new user - should succeed
        $row = array('id' => 0,
            'email' => 'dude@ranch.com',
            'name' => 'Dude, The',
            'password' => '12345678',
        );
        $user = new Bummer\User($row);
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

    public function test_setPassword() {
        $users = new Bummer\Users(self::$site);

        // Test a valid login based on user ID
        $user = $users->login("cbowen@cse.msu.edu", "super477");
        $this->assertNotNull($user);
        $this->assertEquals("Charles Owen", $user->getName());

        // Change the password
        $users->setPassword(1, "dFcCkJ6t");

        // Old password should not work
        $user = $users->login("cbowen@cse.msu.edu", "super477");
        $this->assertNull($user);

        // New password does work!
        $user = $users->login("cbowen@cse.msu.edu", "dFcCkJ6t");
        $this->assertNotNull($user);
        $this->assertEquals("Charles Owen", $user->getName());
    }
    public function test_getUsers(){
        $users = new Bummer\Users(self::$site);

        $userList = $users->getUsers();
        $this->assertEquals(4, sizeof($userList));

        $u1 = $userList[0];
        $this->assertInstanceOf('Bummer\User', $u1);
        $this->assertEquals('Dudess, The', $u1->getName());
        $this->assertEquals(7, $u1->getId());
        $this->assertEquals('dudess@dude.com', $u1->getEmail());
        $this->assertEquals('S', $u1->getRole());

        $u2 = $userList[1];
        $this->assertInstanceOf('Bummer\User', $u2);
    }

}

/// @endcond
