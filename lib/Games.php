<?php
/**
 * Created by PhpStorm.
 * User: HP
 * Date: 2018/3/22
 * Time: 21:20
 */

namespace Bummer;


class Games extends Table
{
    /**
     * Constructor
     * @param $site The Site object
     */
    public function __construct(Site $site)
    {
        parent::__construct($site, "game");
    }

    /**
     * Create a new game
     * @param int $player_id id of the player starting the game
     * @return int id of new game or null if error
     */
    public function newGame($player_id)
    {
        $sql = <<<SQL
insert into $this->tableName (player1)
values(?);
SQL;

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);

        try {
            if ($statement->execute(array($player_id)) === false) {
                return null;
            }
        } catch (\PDOException $e) {
            return null;
        }

        return $pdo->lastInsertId();
    }

    /**
     * Join an existing game
     * @param int $game_id ID of game to join
     * @param int $player_id ID of player joining the game
     * @return bool true if player has successfully joined the game
     */
    public function joinGame($game_id, $player_id)
    {
        $pdo = $this->pdo();

        $sql = <<<SQL
SELECT player1, player2, player3, player4, game
FROM $this->tableName
WHERE id=?;
SQL;
        $statement = $pdo->prepare($sql);
        try {
            if ($statement->execute(array($game_id)) === false) {
                return false;
            }
        } catch (\PDOException $e) {
            return false;
        }
        if ($statement->rowCount() === 0) {
            return false;        // No such game
        }

        $row = $statement->fetch(\PDO::FETCH_ASSOC);

        if ($row["game"] != "") {
            return false;       // Game is already started
        }
        if (in_array($player_id, $row)) {
            return false;       // Player is already in game
        }

        if ($row["player1"] === null) {
            $sql = <<<SQL
UPDATE $this->tableName
SET player1=?
WHERE id=?;
SQL;
        } elseif ($row["player2"] === null) {
            $sql = <<<SQL
UPDATE $this->tableName
SET player2=?
WHERE id=?;
SQL;
        } elseif ($row["player3"] === null) {
            $sql = <<<SQL
UPDATE $this->tableName
SET player3=?
WHERE id=?;
SQL;
        } elseif ($row["player4"] === null) {
            $sql = <<<SQL
UPDATE $this->tableName
SET player4=?
WHERE id=?;
SQL;
        } else {
            return false;       // Game is already full
        }

        $statement = $pdo->prepare($sql);
        try {
            if ($statement->execute(array($player_id, $game_id)) === false) {
                return false;
            }
        } catch (\PDOException $e) {
            return false;
        }
        return true;
    }

    /**
     * Get an array of the names of players in a given game
     * @param int $game_id ID of the game
     * @return array of names, null if game not found
     */
    public function getPlayersInGame($game_id)
    {
        $users = new Users($this->site);
        $usersTable = $users->getTableName();

        $sql = <<<SQL
SELECT p1.name AS p1, p2.name AS p2, p3.name AS p3, p4.name AS p4
FROM $this->tableName AS game
LEFT JOIN $usersTable AS p1 ON p1.id = game.player1 
LEFT JOIN $usersTable AS p2 ON p2.id = game.player2
LEFT JOIN $usersTable AS p3 ON p3.id = game.player3
LEFT JOIN $usersTable AS p4 ON p4.id = game.player4
WHERE game.id = ?;
SQL;

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);

        try {
            if ($statement->execute(array($game_id)) === false) {
                return null;
            }
        } catch (\PDOException $e) {
            return null;
        }
        if ($statement->rowCount() === 0) {
            return null;
        }

        return $statement->fetch(\PDO::FETCH_NUM);
    }

    public function getPlayerIds($gameid){
        $sql = <<<SQL
SELECT player1, player2, player3, player4
FROM $this->tableName
WHERE id = ?
SQL;
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array($gameid));
        if ($statement->rowCount() === 0) {
            return null;
        }
        $playerArray = $statement->fetch(\PDO::FETCH_ASSOC);
        return $playerArray;
    }

    /**
     * Remove a player from a game and delete the game if necessary
     * @param int $gameid ID of game to leave
     * @param int $playerid ID of player
     * @return bool true if successfully left game
     */
    public function removePlayer($gameid, $playerid){
        $playerArray = $this->getPlayerIds($gameid);
        if($playerArray === null) {
            return false;
        }

        if ($playerid == $playerArray["player1"]) {
            $sql = <<<SQL
UPDATE $this->tableName
SET player1 = null
WHERE id = ?
SQL;
        } else if ($playerid == $playerArray["player2"]) {
            $sql = <<<SQL
UPDATE $this->tableName
SET player2 = null
WHERE id = ?
SQL;
        } else if($playerid == $playerArray["player3"]) {
            $sql = <<<SQL
UPDATE $this->tableName
SET player3 = null
WHERE id = ?
SQL;
        } else if($playerid == $playerArray["player4"]) {
            $sql = <<<SQL
UPDATE $this->tableName
SET player4 = null
WHERE id = ?
SQL;
        } else {
            return false; // Player was never in game to begin with
        }

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array($gameid));

        // Delete game if empty
        $empty = true;
        foreach($playerArray as $player){
            // If valid player besides the one we just deleted
            if($player !== null and $player != $playerid){
                $empty = false;
                break;
            }
        }
        if($empty){
            $this->delete($gameid);
        }

        return true;
    }

    public function getNumberOfPlayers($gameid){
        $playerIds = $this->getPlayerIds($gameid);

        $playerCnt = 0;

        foreach($playerIds as $id){
            if($id !== null){
                $playerCnt += 1;
            }
        }

        return $playerCnt;
    }


    public function updateGame($gameState, $id)
    {
        $sql = <<<SQL
UPDATE $this->tableName
SET game=?
where id=?
SQL;
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        try {
            if ($statement->execute(array($gameState, $id)) === false) {
                return false;
            }
        } catch (\PDOException $e) {  // error 1
            return false;
        }
        return true;
    }

    public function getJsonState($id)
    {
        $sql = <<<SQL
SELECT game
FROM $this->tableName
WHERE id = ?
SQL;
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array($id));
        if ($statement->rowCount() === 0) {
            return null;
        }
        $retAry = $statement->fetch(\PDO::FETCH_ASSOC);
        $ret = $retAry['game'];
        return $ret;
    }


    public function delete($id)
    {
        $sql = <<<SQL
DELETE FROM $this->tableName
WHERE id=?
SQL;
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array($id));
    }

    public function setInitialized($gameid, $initBool){
        $sql =<<<SQL
update $this->tableName
set initialized = ?
where id = ?
SQL;
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array($initBool, $gameid));
    }

    public function getInitialized($gameid){
        $sql =<<<SQL
select initialized
from $this->tableName
where id = ?
SQL;
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array($gameid));

        $initState = $statement->fetch(\PDO::FETCH_ASSOC);
        if ($initState->rowCount() === 0) {
            return null;
        }
        $retInit = $initState['initialized'];

        return $retInit;

    }

    public function getGames(){
        $sql =<<<SQL
select id
from $this->tableName
SQL;
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);

        $statement->execute();

        $games = array();
        foreach($statement->fetchALL(\PDO::FETCH_ASSOC) as $game){
            $games[] = $game;
        }

        return $games;

    }
}