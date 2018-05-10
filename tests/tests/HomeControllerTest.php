<?php
require __DIR__ . "/../../vendor/autoload.php";

/** @file
 * Empty unit testing template
 * @cond 
 * Unit tests for the class
 */
class HomeControllerTest extends \PHPUnit_Framework_TestCase
{
    public function test_construct() {
        $controller = new Bummer\HomeController(new Bummer\Site, array());
        $this->assertInstanceOf("Bummer\HomeController", $controller);
    }

    public function test_page() {
        $controller = new Bummer\HomeController(new Bummer\Site, array());
        $this->assertEquals('login.php', $controller->getPage());
    }

    public function test_reset() {
        $controller1 = new Bummer\HomeController(new Bummer\Site, array());
        $this->assertFalse($controller1->isReset());

        $controller2 = new Bummer\HomeController(new Bummer\Site, array('clear' => ''));
        $this->assertTrue($controller2->isReset());
    }

    public function test_players() {
        $site = new \Bummer\Site();
        $game = new Bummer\Game;
        new Bummer\HomeController($site, array());
        $this->assertEquals(array(), $game->getPlayers());

        //new Bummer\HomeController($game, array('p3' => 'Liam'));
        //$players = array(2 => new Bummer\Player('Liam', 'red', $game));
        //$this->assertEquals($players, $game->getPlayers());

        new Bummer\HomeController($site, array('p1' => 'Jayson', 'p2' => 'Gordon', 'p3' => 'Dakota', 'p4' => 'Mingkai'));
        $players = array(new Bummer\Player('Jayson', 'yellow', $game),
                         new Bummer\Player('Gordon', 'green', $game),
                         new Bummer\Player('Dakota', 'red', $game),
                         new Bummer\Player('Mingkai', 'blue', $game));
        $this->assertEquals($players, $game->getPlayers());
    }



}
