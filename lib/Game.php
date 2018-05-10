<?php

/**
 * Created by PhpStorm.
 * User: liamb
 * Date: 2/18/2018
 * Time: 3:44 PM
 */

namespace Bummer;
require __DIR__ . "/../vendor/autoload.php";

class Game
{
    const SESSION_NAME = "game";
    const SIZE = 16;       // Side length of game board
    const END = 99;
    const GAME = 98;
    const DRAW = 0;         // Used during the draw phase of a turn
    const MOVE = 1;         // Used during the move phase of a turn
    const DRAW_BUTTON = array(6, 4);        // coordinates of the draw button
    const SKIP_BUTTON = array(9, 4);        // coordinates of the end turn button

    /**
     * Game constructor.
     * @param site $site site object
     * @param array $session reference to $_SESSION
     */
    public function __construct($site, &$session){
        $this->site = $site;
        $games = new Games($site);
        $this->id = $session[HomeController::SESSION_GAME_ID];

        $playerNames = $games->getPlayersInGame($this->id);
        $playerIDs = $games->getPlayerIds($this->id);

        if ($playerIDs['player1'] !== null) {
            $this->addPlayer(0, $playerNames[0]);
        }
        if ($playerIDs['player2'] !== null) {
            $this->addPlayer(1, $playerNames[1]);
        }
        if ($playerIDs['player3'] !== null) {
            $this->addPlayer(2, $playerNames[2]);
        }
        if ($playerIDs['player4'] !== null) {
            $this->addPlayer(3, $playerNames[3]);
        }

        $this->initializeGrid();
        if($games->getJsonState($this->id) === null) {
            $this->deck = new Deck();
            $this->deck->generate_game_deck();
            //$_SESSION['game'] = $this;
        }

        else{
            $jsonStr = $games->getJsonState($this->id);
            if($jsonStr !== null){
                $this->DecodeAndUpdateGameState($jsonStr);
            }
            //$_SESSION['game'] = $this;
        }
    }

    public function updateDeckandPlayers($row){
        $this->deck = new Deck($row['deck']);
        $this->currentPlayer = $row['turn'];
        foreach($row['players'] as $playerRow){
            foreach($this->getPlayers() as $player) {
                if ($playerRow['name'] == $player->getName()){
                    $player->updateMinionPositions($playerRow['minionPosAry']);
                }
            }
        }
    }

    /**
     * Deck that holds all the cards in the game
     * @return Deck this game's deck
     * @author liamb
     */
    public function getDeck() {
        return $this->deck;
    }

    /**
     * Get the minion at the given cell
     * @param $position array The grid cell to look in - like ['c'=>15, 'r'=>3]
     * @return mixed minion at given location, or null if no minion
     * @author liamb
     */
    public function getMinion($position) {
        return $this->game_grid[$position['r']][$position['c']];
    }

    public function removeMinion($position) {
        $this->game_grid[$position['r']][$position['c']] = null;
    }

    public function addMinion($position, $minion) {
        $this->game_grid[$position['r']][$position['c']] = $minion;
    }

    /**
     * Handle button clicks.
     * This function is called when a player
     * @param mixed $buttonClicked
     */
    public function Click($buttonClicked)
    {
        $_SESSION['inTurn'] = true;
        $buttonCoords = explode(",", $buttonClicked);

        switch ($this->turnPhase) {
            case self::DRAW:
                // Draw a card and go to move phase
                if ($buttonCoords == self::DRAW_BUTTON) {
                    $this->currentCard = $this->deck->drawCard();
                    $this->turnPhase = self::MOVE;
                    $_SESSION['game'] = $this;
                }
                break;
            case self::MOVE:
                // Try to make the selected move. If successful, go to next player's draw phase
                $player = $this->players[$this->currentPlayer];
                $valid_play = $player->play($this->currentCard, $buttonCoords);
                if ($buttonCoords == self::SKIP_BUTTON or $valid_play) {
                    //2 Card makes player draw again
                    if($this->currentCard == new Card(2)){
                        $this->turnPhase = self::DRAW;
                        $this->Click(self::DRAW_BUTTON);
                        $_SESSION['game'] = $this;
                    }
                    else{
                        $this->nextPlayer();
                        $this->currentCard = null;
                        $this->turnPhase = self::DRAW;
                        $_SESSION["inTurn"] = false;
                        $this->EncodeJsonArray();
                        new Reload("craigkeygame");
                    }
                }
                break;
        }
    }

    /**
     * Initialize the game grid.
     * game_grid[0][0] and [15][15] are the corners of the grid.
     * game_grid[5][2] is the cell in the 5th column, 2nd row.
     * @author liamb
     */
    private function initializeGrid() {
        for ($col = 0; $col < $this::SIZE; $col++) {
            $this->game_grid[] = array();
            for ($row = 0; $row < $this::SIZE; $row++) {
                $this->game_grid[$col][] = null;
            }
        }
    }

    /**
     * @return array
     */
    public function getPlayers()
    {
        return $this->players;
    }

    public function addPlayer($index, $name){
        // should use this instead of in constructor
        $color_ary = ["yellow", "green", "red", "blue"];
        $this->players[] = new Player($name, $color_ary[$index], $this);
    }

    public function addInitializedPlayer($index, $name, $minionPositionArray){
        $color_ary = ["yellow", "green", "red", "blue"];
        $this->players[$index] = new Player($name, $color_ary[$index], $this, $minionPositionArray);
    }

    /**
     * @return mixed
     */
    public function getWinner()
    {
        return $this->winner;
    }

    /**
     * @return mixed
     */
    public function GetCurrentPlayer()
    {
        return $this->players[$this->currentPlayer];
    }

    public function getCurrentCard()
    {
        return $this->currentCard;
    }

    public function nextPlayer(){
        $this->currentPlayer = ($this->currentPlayer + 1) % sizeof($this->players);
    }

    function getJsonDeck(){
        $jsonDeck = array();
        foreach($this->deck->deck as $card){
            $jsonDeck[] = $card->getCardNum();
        }
        return $jsonDeck;
    }

    function getJsonPlayers(){
        $jsonPlayers = array();
        $jsonPlayerRow = array();
        foreach($this->getPlayers() as $player){
            $jsonPlayerRow = array();
            $jsonPlayerRow["name"] = $player->getName();
            $jsonPlayerRow["color"] = $player->getColor();

            $jsonMinionsPos = array();
                foreach($player->getMinions() as $minion) {
                    $jsonMinionsPos[] = $minion->getPosition();
                }
            $jsonPlayerRow["minionPosAry"] = $jsonMinionsPos;

            $jsonPlayers[] = $jsonPlayerRow;
        }
        return $jsonPlayers;
    }

    function EncodeJsonArray(){
        $jsonArray = array(
            "deck" => $this->getJsonDeck(),
            "turn" => $this->currentPlayer,
            "players" => $this->getJsonPlayers()
        );
        $jsonstr = json_encode($jsonArray);
        $id = $this->id;
        $gameTable = new Games($this->site);
        $gameTable->updateGame($jsonstr, $id);
    }

    function DecodeAndUpdateGameState($jsonstr){

        $decodedArray = json_decode($jsonstr, true);

        if( $decodedArray != null ){
            $this->updateDeckandPlayers($decodedArray);
        }
    }

    /**
    /*
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $winner
     */
    public function setWinner($winner)
    {
        $this->winner = $winner;
    }

    private $site;
    private $players = array();         // Array of players in this game; can have 2-4 players
    private $deck;                      // Deck to hold all the cards in the game
    private $game_grid = array();       // Grid to keep track of where all the minions are
    private $winner;
    private $currentPlayer = 0;      // Index of player who is currently taking his or her turn
    private $currentCard = null;        // Card that is currently face-up; null if no card
    private $turnPhase = self::DRAW;    // Tells whether the current player should be drawing a card or choosing a move.
    private $id = 0;  /// < need to get match the id from table to game id to lookup in table
    private $jsonArray = array();    ///< private JSON array to pass game state

}