<?php
require __DIR__ . "/../../vendor/autoload.php";
/** @file
 * Empty unit testing template
 * @cond
 * Unit tests for the class
 */
class GameViewTest extends \PHPUnit_Framework_TestCase
{
    public function test_Constructor(){
        $game = new Bummer\Game();
        $view = new Bummer\GameView($game, $_SESSION);

        $this->assertInstanceOf('Bummer\GameView', $view);
    }

    public function test_generateBoard(){
        $game = new Bummer\Game();
        $game->addPlayer(0,"Dakota");
        $game->addPlayer(1,"John");
        $game->addPlayer(2,"Steve");
        $game->addPlayer(3,"Drew");

        $view = new Bummer\GameView($game, $_SESSION);
        $board = $view->generateBoard();

        ///Check row/columns for arrray
        $this->assertContains("0,0",$board);
        $this->assertContains("1,1",$board);
        $this->assertContains("2,2",$board);
        $this->assertContains("3,3",$board);
        $this->assertContains("4,4",$board);
        $this->assertContains("5,5",$board);
        $this->assertContains("6,6",$board);
        $this->assertContains("7,7",$board);
        $this->assertContains("8,8",$board);
        $this->assertContains("9,9",$board);
        $this->assertContains("10,10",$board);
        $this->assertContains("11,11",$board);
        $this->assertContains("12,12",$board);
        $this->assertContains("13,13",$board);
        $this->assertContains("14,14",$board);
        $this->assertContains("15,15",$board);

        ///Check that images are being added
        $this->assertContains("class=\"draw_card",$board);
        $this->assertContains("class=\"yellow",$board);
        $this->assertContains("class=\"red",$board);
        $this->assertContains("class=\"green",$board);
        $this->assertContains("class=\"blue",$board);

        ///Check current player
        $this->assertContains("Player: Dakota",$board);
    }

    public function test_presentInstruction(){
        ///Test with 4 players
        $game = new Bummer\Game();
        $game->addPlayer(0,"Dakota");
        $game->addPlayer(1,"John");
        $game->addPlayer(2,"Steve");
        $game->addPlayer(3,"Drew");

        $view = new Bummer\GameView($game, $_SESSION);
        $present = $view->presentInstruction();

//        $this->assertContains("Team name: Craig",$present);
        $this->assertContains("Member 1: Dakota",$present);
        $this->assertContains("Member 2: John",$present);
        $this->assertContains("Member 3: Steve",$present);
        $this->assertContains("Member 4: Drew",$present);

    }

    public function test_present(){
        $game = new Bummer\Game();
        $game->addPlayer(0,"Dakota");
        $game->addPlayer(1,"John");
        $game->addPlayer(2,"Steve");
        $game->addPlayer(3,"Drew");
        $game->Click('0,0');

        ///Since there is not a winner yet should return generated board
        $view = new Bummer\GameView($game, $_SESSION);
        $present = $view->present();

        ///Check row/columns for arrray
        $this->assertContains("0,0",$present);
        $this->assertContains("1,1",$present);
        $this->assertContains("2,2",$present);
        $this->assertContains("3,3",$present);
        $this->assertContains("4,4",$present);
        $this->assertContains("5,5",$present);
        $this->assertContains("6,6",$present);
        $this->assertContains("7,7",$present);
        $this->assertContains("8,8",$present);
        $this->assertContains("9,9",$present);
        $this->assertContains("10,10",$present);
        $this->assertContains("11,11",$present);
        $this->assertContains("12,12",$present);
        $this->assertContains("13,13",$present);
        $this->assertContains("14,14",$present);
        $this->assertContains("15,15",$present);

        ///Check that images are being added
        $this->assertContains("class=\"draw_card",$present);
        $this->assertContains("class=\"yellow",$present);
        $this->assertContains("class=\"red",$present);
        $this->assertContains("class=\"green",$present);
        $this->assertContains("class=\"blue",$present);
    }
}
