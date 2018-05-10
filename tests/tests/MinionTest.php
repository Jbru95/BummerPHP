<?php
require __DIR__ . "/../../vendor/autoload.php";
use Bummer\Minion as Minion;

/** @file
 * Empty unit testing template
 * @cond 
 * Unit tests for the class
 */
class MinionTest extends \PHPUnit_Framework_TestCase
{
    public function test_constructor() {
        $game = new Bummer\Game();
        $minion = new Minion("red", 1, $game);
        $this->assertInstanceOf("Bummer\Minion", $minion);
    }

	public function test_color_and_image() {
        $game = new Bummer\Game();
        $minion_red = new Minion("red", 1, $game);
        $this->assertEquals("red", $minion_red->getColor());
        $this->assertContains("images/minion-red.png", $minion_red->getImage());

        $minion_yellow = new Minion("yellow", 1, $game);
        $this->assertEquals("yellow", $minion_yellow->getColor());
        $this->assertContains("images/minion-yellow.png", $minion_yellow->getImage());

        $minion_blue = new Minion("blue", 1, $game);
        $this->assertEquals("blue", $minion_blue->getColor());
        $this->assertContains("images/minion-blue.png", $minion_blue->getImage());

        $minion_green = new Minion("green", 1, $game);
        $this->assertEquals("green", $minion_green->getColor());
        $this->assertContains("images/minion-green.png", $minion_green->getImage());
	}
        // this part will test the move function
	public function test_move() {
        $game = new Bummer\Game();
        $minion_red = new Minion("red", 1, $game);
        $minion_red->setPosition(3);
        $minion_red->move(7);
        $this->assertEquals(10, $minion_red->getPosition());
        $this->assertNotEquals(11, $minion_red->getPosition());
    }

    public function test_bummer() {
        $game = new Bummer\Game();
	    $minion_red = new Minion("red", 1, $game);
        $minion_red->setPosition(3);
        $this->assertEquals(3, $minion_red->getPosition());
        $minion_red->bummer();
        $this->assertEquals(0, $minion_red->getPosition());
    }

    public function test_game() {
        $game = new Bummer\Game();
        $minion = new Minion("red", 1, $game);

        //$this->assertEquals(null, $minion->getGame());
        $minion->setGame($game);
        $this->assertEquals($game, $minion->getGame());
    }
        //this part will check the position
    public function test_getArrayFromPosition() {
        $game = new Bummer\Game();
        $minion = new Bummer\Minion("red", 1, $game);
        $minion->setPosition(0);
        $this->assertEquals(['c'=>2, 'r'=>11], $minion->getArrayFromPosition());
        $minion->setPosition(5);
        $this->assertEquals(['c'=>0, 'r'=>7], $minion->getArrayFromPosition());
        $minion->setPosition(14);
        $this->assertEquals(['c'=>2, 'r'=>0], $minion->getArrayFromPosition());
        $minion->setPosition(28);
        $this->assertEquals(['c'=>15, 'r'=>1], $minion->getArrayFromPosition());
        $minion->setPosition(43);
        $this->assertEquals(['c'=>14, 'r'=>15], $minion->getArrayFromPosition());
        $minion->setPosition(58);
        $this->assertEquals(['c'=>0, 'r'=>14], $minion->getArrayFromPosition());
        $minion->setPosition(62);
        $this->assertEquals(['c'=>3, 'r'=>13], $minion->getArrayFromPosition());
        $minion->setPosition(65);
        $this->assertEquals(['c'=>7, 'r'=>13], $minion->getArrayFromPosition());
        $minion->setPosition(66);
        $this->assertEquals(['c'=>0, 'r'=>12], $minion->getArrayFromPosition());

        $minion = new Bummer\Minion("yellow", 2, $game);
        $minion->setPosition(0);
        $this->assertEquals(['c'=>13, 'r'=>5], $minion->getArrayFromPosition());
        $minion->setPosition(5);
        $this->assertEquals(['c'=>15, 'r'=>8], $minion->getArrayFromPosition());
        $minion->setPosition(14);
        $this->assertEquals(['c'=>13, 'r'=>15], $minion->getArrayFromPosition());
        $minion->setPosition(28);
        $this->assertEquals(['c'=>0, 'r'=>14], $minion->getArrayFromPosition());
        $minion->setPosition(43);
        $this->assertEquals(['c'=>1, 'r'=>0], $minion->getArrayFromPosition());
        $minion->setPosition(58);
        $this->assertEquals(['c'=>15, 'r'=>1], $minion->getArrayFromPosition());
        $minion->setPosition(62);
        $this->assertEquals(['c'=>12, 'r'=>2], $minion->getArrayFromPosition());
        $minion->setPosition(65);
        $this->assertEquals(['c'=>8, 'r'=>3], $minion->getArrayFromPosition());
        $minion->setPosition(66);
        $this->assertEquals(['c'=>15, 'r'=>3], $minion->getArrayFromPosition());

        $minion = new Bummer\Minion("blue", 1, $game);
        $minion->setPosition(0);
        $this->assertEquals(['c'=>4, 'r'=>2], $minion->getArrayFromPosition());
        $minion->setPosition(5);
        $this->assertEquals(['c'=>8, 'r'=>0], $minion->getArrayFromPosition());
        $minion->setPosition(14);
        $this->assertEquals(['c'=>15, 'r'=>2], $minion->getArrayFromPosition());
        $minion->setPosition(28);
        $this->assertEquals(['c'=>14, 'r'=>15], $minion->getArrayFromPosition());
        $minion->setPosition(43);
        $this->assertEquals(['c'=>0, 'r'=>14], $minion->getArrayFromPosition());
        $minion->setPosition(58);
        $this->assertEquals(['c'=>1, 'r'=>0], $minion->getArrayFromPosition());
        $minion->setPosition(62);
        $this->assertEquals(['c'=>2, 'r'=>3], $minion->getArrayFromPosition());
        $minion->setPosition(65);
        $this->assertEquals(['c'=>2, 'r'=>7], $minion->getArrayFromPosition());
        $minion->setPosition(66);
        $this->assertEquals(['c'=>3, 'r'=>0], $minion->getArrayFromPosition());

        $minion = new Bummer\Minion("green", 1,$game);
        $minion->setPosition(0);
        $this->assertEquals(['c'=>11, 'r'=>13], $minion->getArrayFromPosition());
        $minion->setPosition(5);
        $this->assertEquals(['c'=>7, 'r'=>15], $minion->getArrayFromPosition());
        $minion->setPosition(14);
        $this->assertEquals(['c'=>0, 'r'=>13], $minion->getArrayFromPosition());
        $minion->setPosition(28);
        $this->assertEquals(['c'=>1, 'r'=>0], $minion->getArrayFromPosition());
        $minion->setPosition(43);
        $this->assertEquals(['c'=>15, 'r'=>1], $minion->getArrayFromPosition());
        $minion->setPosition(58);
        $this->assertEquals(['c'=>14, 'r'=>15], $minion->getArrayFromPosition());
        $minion->setPosition(62);
        $this->assertEquals(['c'=>13, 'r'=>12], $minion->getArrayFromPosition());
        $minion->setPosition(65);
        $this->assertEquals(['c'=>13, 'r'=>8], $minion->getArrayFromPosition());
        $minion->setPosition(66);
        $this->assertEquals(['c'=>12, 'r'=>15], $minion->getArrayFromPosition());

    }

    public function test_getPositionFromArray() {
        $game = new Bummer\Game();
        $minion = new Bummer\Minion("yellow", 2, $game);
        $this->assertEquals(0, $minion->getPositionFromArray(13,5));
        $this->assertEquals(5, $minion->getPositionFromArray(15,8));
        $this->assertEquals(14, $minion->getPositionFromArray(13,15));
        $this->assertEquals(28, $minion->getPositionFromArray(0,14));
        $this->assertEquals(43, $minion->getPositionFromArray(1,0));
        $this->assertEquals(58, $minion->getPositionFromArray(15,1));
        $this->assertEquals(62, $minion->getPositionFromArray(12,2));
        $this->assertEquals(65, $minion->getPositionFromArray(8,3));
        $this->assertEquals(66, $minion->getPositionFromArray(15,3));

        $minion = new Bummer\Minion("red", 1, $game);

        $this->assertEquals(0, $minion->getPositionFromArray(2,11));
        $this->assertEquals(5, $minion->getPositionFromArray(0,7));
        $this->assertEquals(14, $minion->getPositionFromArray(2,0));
        $this->assertEquals(28, $minion->getPositionFromArray(15,1));
        $this->assertEquals(43, $minion->getPositionFromArray(14,15));
        $this->assertEquals(58, $minion->getPositionFromArray(0,14));
        $this->assertEquals(62, $minion->getPositionFromArray(3,13));
        $this->assertEquals(65, $minion->getPositionFromArray(7,13));
        $this->assertEquals(66, $minion->getPositionFromArray(0,12));

        $minion = new Bummer\Minion("blue", 1, $game);
        $this->assertEquals(0, $minion->getPositionFromArray(4,2));
        $this->assertEquals(5, $minion->getPositionFromArray(8,0));
        $this->assertEquals(14, $minion->getPositionFromArray(15,2));
        $this->assertEquals(28, $minion->getPositionFromArray(14,15));
        $this->assertEquals(43, $minion->getPositionFromArray(0,14));
        $this->assertEquals(58, $minion->getPositionFromArray(1,0));
        $this->assertEquals(62, $minion->getPositionFromArray(2,3));
        $this->assertEquals(65, $minion->getPositionFromArray(2,7));
        $this->assertEquals(66, $minion->getPositionFromArray(3,0));

        $minion = new Bummer\Minion("green", 1, $game);
        $this->assertEquals(0, $minion->getPositionFromArray(11,13));
        $this->assertEquals(5, $minion->getPositionFromArray(7,15));
        $this->assertEquals(14, $minion->getPositionFromArray(0,13));
        $this->assertEquals(28, $minion->getPositionFromArray(1,0));
        $this->assertEquals(43, $minion->getPositionFromArray(15,1));
        $this->assertEquals(58, $minion->getPositionFromArray(14,15));
        $this->assertEquals(62, $minion->getPositionFromArray(13,12));
        $this->assertEquals(65, $minion->getPositionFromArray(13,8));
        $this->assertEquals(66, $minion->getPositionFromArray(12,15));
    }


}
