<?php
require __DIR__ . "/../../vendor/autoload.php";

/** @file
 * Empty unit testing template
 * @cond 
 * Unit tests for the class
 */
class PlayerTest extends \PHPUnit_Framework_TestCase
{
	public function testConstruct() {
	    $game = new Bummer\Game();
		$player = new Bummer\Player("Liam", "green", $game);
        $this->assertInstanceOf('Bummer\Player', $player);
	}

	public function testAttributes() {
        $game = new Bummer\Game();
        $player = new Bummer\Player("Liam", "green", $game);
        $this->assertEquals($player->getName(), "Liam");
        $this->assertEquals($player->getColor(), "green");
    }

    public function test_minions() {
        $game = new Bummer\Game();
        $player = new Bummer\Player("Liam", "green", $game);
        $minions = array(new Bummer\Minion("green", 0, $game),
                         new Bummer\Minion("green", 1, $game),
                         new Bummer\Minion("green", 2, $game));
        $this->assertEquals($minions, $player->getMinions());
    }

    public function test_checkWin() {
        // Player should not win immediately.
	    $game = new Bummer\Game();
        $player = new Bummer\Player("Liam", "green", $game);
        $this->assertFalse($player->checkWin());

        // Player should not win even with two minions in home.


    }
}

/// @endcond
