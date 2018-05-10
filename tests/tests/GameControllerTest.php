<?php
require __DIR__ . "/../../vendor/autoload.php";

/** @file
 * Empty unit testing template
 * @cond 
 * Unit tests for the class
 */
class GameControllerTest extends \PHPUnit_Framework_TestCase
{
	public function test_construct() {
        $controller = new Bummer\GameController(new Bummer\Game, array());
        $this->assertInstanceOf("Bummer\GameController", $controller);
	}

	public function test_reset() {
        $controller1 = new Bummer\GameController(new Bummer\Game, array());
        $this->assertFalse($controller1->isReset());

        $controller2 = new Bummer\GameController(new Bummer\Game, array('newGame' => ''));
        $this->assertTrue($controller2->isReset());
    }

}
