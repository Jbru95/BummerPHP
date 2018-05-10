<?php
require __DIR__ . "/../../vendor/autoload.php";

/** @file
 * Empty unit testing template/database version
 * @cond 
 * Unit tests for the class
 */

abstract class BaseDB extends \PHPUnit_Extensions_Database_TestCase {
    public static function setUpBeforeClass() {
        self::$site = new Bummer\Site();
        $localize  = require 'localize.inc.php';
        if(is_callable($localize)) {
            $localize(self::$site);
        }
    }

    public function getConnection() {
        return $this->createDefaultDBConnection(self::$site->pdo(), 'bohllia1');
    }

    protected static $site;
}

/// @endcond
