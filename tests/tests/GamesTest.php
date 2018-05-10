<?php
require __DIR__ . "/../../vendor/autoload.php";
require_once("BaseDB.php");

/** @file
 * Unit tests for the class Games
 * @cond
 */

class GamesTest extends BaseDB {
    /**
     * @return PHPUnit_Extensions_Database_DataSet_IDataSet
     */
    public function getDataSet() {
        return $this->createXMLDataSet(dirname(__FILE__) . '/db/game.xml');
    }

    public function test_construct() {
        $games = new Bummer\Games(self::$site);
        $this->assertInstanceOf('Bummer\Games', $games);
    }

    public function test_getPlayersInGame() {
        $games = new Bummer\Games(self::$site);

        // Get players in a full game
        $players_found = $games->getPlayersInGame(2);
        $players_expected = array("Liam Bohl", "Harold", "Sarah", "Charles Owen");
        $this->assertEquals($players_expected, $players_found);

        // Get players in a partially full game
        $players_found = $games->getPlayersInGame(3);
        $players_expected = array("Charles Owen", "Sarah", "Liam Bohl", null);
        $this->assertEquals($players_expected, $players_found);

        // Try to get players from a nonexistent game
        $players_found = $games->getPlayersInGame(1000);
        $this->assertNull($players_found);
    }

    public function test_newGame() {
        $games = new Bummer\Games(self::$site);

        // Create a game as a valid user
        $game_id = $games->newGame(27);
        $this->assertNotNull($game_id);
        $this->assertEquals(array("Harold", null, null, null), $games->getPlayersInGame($game_id));

        // Try to create a game with an invalid user id
        $game_id = $games->newGame(1000);
        $this->assertNull($game_id);
    }

    public function test_joinGame() {
        $games = new Bummer\Games(self::$site);

        // Add a different player to an existing game
        $this->assertEquals(array("Charles Owen", null, null, null), $games->getPlayersInGame(1));
        $this->assertTrue($games->joinGame(1, 27));
        $this->assertEquals(array("Charles Owen", "Harold", null, null), $games->getPlayersInGame(1));

        // Try to add a nonexistent player
        $this->assertFalse($games->joinGame(1, 1000));
        $this->assertEquals(array("Charles Owen", "Harold", null, null), $games->getPlayersInGame(1));

        // Try to add the same player twice
        $this->assertFalse($games->joinGame(1, 27));
        $this->assertEquals(array("Charles Owen", "Harold", null, null), $games->getPlayersInGame(1));

        // Try to add a player to a nonexistent game
        $this->assertFalse($games->joinGame(1000, 2));
        $this->assertNull($games->getPlayersInGame(1000));
    }

    public function test_getPlayerIds() {
        $games = new Bummer\Games(self::$site);

        // Get player IDs in a valid game
        $this->assertEquals(array("player1" => "2", "player2" => "27", "player3" => "3", "player4" => "1"), $games->getPlayerIds(2));

        // Get player IDs in a mostly empty game
        $this->assertEquals(array("player1" => "1", "player2" => null, "player3" => null, "player4" => null), $games->getPlayerIds(1));

        // Get player IDs in a completely empty game
        $this->assertEquals(array("player1" => null, "player2" => null, "player3" => null, "player4" => null), $games->getPlayerIds(4));

        // Player IDs for a nonexistent game should be null
        $this->assertNull($games->getPlayerIds(1000));
    }

    public function test_removePlayer() {
        $games = new Bummer\Games(self::$site);

        // Remove a player from a game they are in
        $this->assertEquals(array('player1' => "2", 'player2' => "27", 'player3' => "3", 'player4' => "1"), $games->getPlayerIds(2));
        $this->assertTrue($games->removePlayer(2, 2));
        $this->assertEquals(array('player1' => null, 'player2' => "27", 'player3' => "3", 'player4' => "1"), $games->getPlayerIds(2));

        // Try to remove the player again
        $this->assertFalse($games->removePlayer(2, 2));
        $this->assertEquals(array('player1' => null, 'player2' => "27", 'player3' => "3", 'player4' => "1"), $games->getPlayerIds(2));

        // Remove remaining players from game 2 - game should be removed
        $this->assertTrue($games->removePlayer(2, 27));
        $this->assertTrue($games->removePlayer(2, 3));
        $this->assertTrue($games->removePlayer(2, 1));
        $this->assertNull($games->getPlayerIds(2));
    }
}

/// @endcond
