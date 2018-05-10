<?php
require __DIR__ . "/../../vendor/autoload.php";
/** @file
 * Empty unit testing template/database version
 * @cond 
 * Unit tests for the class
 */

class ValidatorsTest extends \PHPUnit_Extensions_Database_TestCase
{
    /**
     * @return PHPUnit_Extensions_Database_DB_IDatabaseConnection
     */
    public function getConnection()
    {
        return $this->createDefaultDBConnection(self::$site->pdo(), 'bohllia1');
    }

    /**
     * @return PHPUnit_Extensions_Database_DataSet_IDataSet
     */
    public function getDataSet()
    {
        return $this->createFlatXMLDataSet(dirname(__FILE__) . '/db/validator.xml');
    }
    private static $site;

    public static function setUpBeforeClass() {
        self::$game = new Bummer\Game();
        $localize  = require 'localize.inc.php';
        if(is_callable($localize)) {
            $localize(self::$game);
        }
    }
    public function test_construct() {
        $validators = new Bummer\Validators(self::$site);
        $this->assertInstanceOf('Bummer\Validators', $validators);
    }

    public function test_newValidator() {
        $validators = new Bummer\Validators(self::$site);

        $validator = $validators->newValidator(27);
        $this->assertEquals(32, strlen($validator)); //Failed asserting that 0 matches expected 32.

        $table = $validators->getTableName();
        $sql = <<<SQL
select * from $table
where userid=? and validator=?
SQL;

        $stmt = $validators->pdo()->prepare($sql);
        $stmt->execute(array(27, $validator));
        $this->assertEquals(1, $stmt->rowCount());
    }

    public function test_get() {
        $validators = new Bummer\Validators(self::$site);

        // Test a not-found condition
        $this->assertNull($validators->get(""));

        // Create a validator
        $validator = $validators->newValidator(27);

        $this->assertEquals(27, $validators->get($validator));//Failed asserting that null matches expected 27.

        // Remove the validator for this user
        $validators->remove(27);
        $this->assertNull($validators->get($validator));

        // Create two validators
        // Either can work.
        $validator1 = $validators->newValidator(33);
        $validator2 = $validators->newValidator(33);

        $this->assertEquals(33, $validators->get($validator1));
        $this->assertEquals(33, $validators->get($validator2));

        // Remove the validator for this user
        $validators->remove(33);

        $this->assertNull($validators->get($validator1));
        $this->assertNull($validators->get($validator2));
    }
}

/// @endcond
