<?php
require __DIR__ . "/../../vendor/autoload.php";
/** @file
 * Empty unit testing template/database version
 * @cond
 * Unit tests for the class
 */

class LoginControllerTest extends \PHPUnit_Extensions_Database_TestCase
{
    /**
     * @return PHPUnit_Extensions_Database_DB_IDatabaseConnection
     */

    public function getConnection()
    {

        return $this->createDefaultDBConnection(self::$site->pdo(), 'lockle12');
    }

    /**
     * @return PHPUnit_Extensions_Database_DataSet_IDataSet
     */
    public function getDataSet()
    {
        return $this->createFlatXMLDataSet(dirname(__FILE__) . '/db/user.xml');
    }
    public static function setUpBeforeClass() {
        self::$site = new Bummer\Site();
        $localize  = require 'localize.inc.php';
        if(is_callable($localize)) {
            $localize(self::$site);
        }
    }
    private static $site;

    public function test_construct() {
        $session = array();	// Fake session
        $root = self::$site->getRoot();

        $controller = new Bummer\LoginController(self::$site, $session,
            array("email" => "cbowen@cse.msu.edu", "password" => "super477"));

        $this->assertEquals("Owen, Charles", $session[Bummer\User::SESSION_NAME]->getName());
        $this->assertEquals("$root/staff.php", $controller->getRedirect());

        // Valid client login
        $controller = new Bummer\LoginController(self::$site, $session,
            array("email" => "bart@bartman.com", "password" => "bart477"));

        $this->assertEquals("Simpson, Bart", $session[Bummer\User::SESSION_NAME]->getName());
        $this->assertEquals("$root/client.php", $controller->getRedirect());

        // Invalid login
        $controller = new Bummer\LoginController(self::$site, $session,
            array("email" => "bart@bartman.com", "password" => "wrongpassword"));

        $this->assertNull($session[Bummer\User::SESSION_NAME]);
        $this->assertEquals("$root/login.php?e", $controller->getRedirect());
        $this->assertEquals('Invalid Login Credentials', $session['ERROR']);
    }

}
