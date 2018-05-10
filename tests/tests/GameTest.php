<?php
require __DIR__ . "/../../vendor/autoload.php";
/** @file
 * Empty unit testing template
 * @cond
 * Unit tests for the class
 */
class GameTest extends \PHPUnit_Framework_TestCase
{
    public function test_Constructor() {
        $game_obj = new Bummer\Game();

        $this->assertInstanceOf('Bummer\Game', $game_obj);
    }

    public function test_getMinion(){
        $game = new Bummer\Game();
        $minion = new Bummer\Minion("yellow", 0, $game);

        $minion->setPosition(0);
        $Array = $minion->getArrayFromPosition();
        $this->assertEquals(null,$game->getMinion($Array));
    }

    public function test_getDeck(){
        $game_obj = new Bummer\Game();

        $this->assertInstanceOf('Bummer\Deck',$game_obj->getDeck());
    }

    public function test_getPlayers(){
        $game = new Bummer\Game();

        ///No players
        $this->assertEquals(array(),$game->getPlayers());

        ///1 player
        $game->addPlayer(0,"Dakota");
        $player1 = new Bummer\Player("Dakota","yellow",$game);
        $this->assertEquals(array($player1), $game->getPlayers());

        ///2 players
        $game->addPlayer(1,"John");
        $player2 = new Bummer\Player("John","green",$game);
        $this->assertEquals(array($player1,$player2), $game->getPlayers());

        ///3 players
        $game->addPlayer(2,"Jim");
        $player3 = new Bummer\Player("Jim","red",$game);
        $this->assertEquals(array($player1,$player2,$player3), $game->getPlayers());

        ///4 players
        $game->addPlayer(3,"Kevin");
        $player4 = new Bummer\Player("Kevin","blue",$game);
        $this->assertEquals(array($player1,$player2,$player3,$player4), $game->getPlayers());
    }


    public function test_getWinner(){
        $game = new Bummer\Game();

        $player = new Bummer\Player("Dakota","yellow",$game);

        $this->assertNotEquals($player->getName(),$game->getWinner());
    }

    public function test_removeMinion(){
        $game = new Bummer\Game();
        $minion = new Bummer\Minion("yellow", 0, $game);
        $game->addMinion(['r'=>15, 'c'=>3], $minion);
        $this->assertEquals($minion, $game->getMinion(['r'=>15, 'c'=>3]));
        $game->removeMinion(['r'=>15, 'c'=>3]);
        $this->assertEquals(null, $game->getMinion(['r'=>15, 'c'=>3]));
    }
    public function test_addMinion(){
        $game = new Bummer\Game();
        $minion = new Bummer\Minion("yellow", 0, $game);
        $game->addMinion(['r'=>15, 'c'=>3], $minion);
        $this->assertEquals($minion, $game->getMinion(['r'=>15, 'c'=>3]));
    }
    public function test_GetCurrentPlayer(){
        $game = new Bummer\Game();
        $game->addPlayer(0, "Gordon");
        $this->assertEquals($game->getPlayers()[0], $game->GetCurrentPlayer());
    }
    public function test_getCurrentCard(){
        //$row = array('deck' => array(new Bummer\Card(1)));
        //$deck = new Bummer\Deck($row);
        //$card = new Bummer\Card(1);
        //$this->assertEquals($card, $game->getCurrentCard());
    }
    public function test_nextPlayer(){
        $game = new Bummer\Game();
        $game->addPlayer(0, "Gordon");
        $game->addPlayer(1, "Gordon2");
        $game->nextPlayer();
        $this->assertEquals($game->getPlayers()[1], $game->GetCurrentPlayer());
    }

    public function test_getJsonDeck(){
        $game = new Bummer\Game();
        $jsonDeck = $game->getJsonDeck();
        $this->assertNotNull($jsonDeck);
    }

    public function test_getJsonPlayers(){
        $game = new Bummer\Game();

    }

    public function test_encodeJsonArray(){

        $array = array( "deck" => array(1,2,3,4),
            "turn" => 1,
            "players" => array(0 => array('name' => "Jayson", "color" => "yellow", "minionPosAry" => array(0,0,2)),
                1=> array('name' => "Dak", "color" => "green", "minionPosAry" => array(0,10,5))));
        $json_str = json_encode($array);
        var_dump($array);
        echo $json_str;


        $gotArray = json_decode($json_str, true);
        var_dump($gotArray);



        /*
        $game =
        $game->addPlayer(0, "Jayson");
        $game->getPlayers()[0]->getMinions()[0]->setPosition(10);
        $game->addPlayer(1, "Gordon");
        $game->addPlayer(2, "Liam");
        $game->addPlayer(3, "Dakkota");
        $ret = $game->EncodeJsonArray();
        $decode = $game->DecodeJsonArray($ret);
        var_dump($decode);
        var_dump($decode['players'][0]['minionPosAry']);

        $deck1 = $game->getDeck();
        $players1 = $game->getPlayers();

        $game->updateDeckandPlayers($decode);

        $this->assertEquals($deck1, $game->getDeck());
        $this->assertEquals($players1, $game->getPlayers());
        */
    }

}
