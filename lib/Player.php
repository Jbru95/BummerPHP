<?php
/**
 * Created by PhpStorm.
 * User: liamb
 * Date: 2/16/2018
 * Time: 4:49 PM
 */

namespace Bummer;


class Player
{
    const NUM_MINIONS = 3;

    /**
     * Player constructor.
     * @param $name string Nickname for the player
     * @param $color string color of the player's minions (blue, yellow, red, or green)
     * @param $game Game the game this player is part of
     * @author liamb
     */
    public function __construct($name, $color, $game, $minionsPositions = null) {
        if($minionsPositions === null) {
            $this->name = $name;
            $this->color = $color;
            for ($i = 0; $i < self::NUM_MINIONS; $i++) {
                $this->minions[] = new Minion($color, $i, $game);
            }
            $this->game = $game;
        }
        else{
            $this->name = $name;
            $this->color = $color;
            for ($i = 0; $i < self::NUM_MINIONS; $i++) {
                $this->minions[] = new Minion($color, $i, $game);
            }
            $i = 0;
            foreach($minionsPositions as $minionPos){
                $this->minions[$i]->setPosition($minionPos);
                $i += 1;
            }
            $this->game = $game;
        }
    }

    public function updateMinionPositions($positionAry){
        $i = 0;
        foreach($this->minions as $minion){
            $minion->setPosition($positionAry[$i]);
            $i++;
        }
    }

    /**
     * Attempt to play the given card at the given square for this player.
     * @author Dakota
     * @author liamb
     * @param $card Card card to play
     * @param $buttonCoords array coordinates of selected square
     * @return bool true if this move was valid.
     */
    public function play($card, $buttonCoords) {
        //if($card->getCardNum() == 13){
           // $this->bummer = true;
        //}
        foreach ($this->minions as $minion) {
            if($card->playCard($minion, $buttonCoords)){
                return true; // Play was successful
            }
        }
        return false; // Invalid play
    }

    /**
     * The name of this player
     * @return string the player's name
     */
    public function getName() {
        return $this->name;
    }

    /**
     * The oolor of this player
     * @return string this player's color
     */
    public function getColor() {
        return $this->color;
    }

    /**
     * Check if this player has won
     * @return bool true if the player has won the game
     */
    public function checkWin() {
        for($i = 0; $i < self::NUM_MINIONS; $i++){
            if($this->minions[$i]->getPosition() != 65){
                return false;
            }
        }
        $this->game->setWinner($this->getName());
        return true;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    public function getMinions(){
        return $this->minions;
    }

    /**
     * @return bool
     */
    public function isBummer()
    {
        return $this->bummer;
    }



    private $game;          // Game the player is part of
    private $name;          // Name of the player
    private $color;         // Color of the player's minions (blue, yellow, red, or green)
    private $minions = [];  // Array of this player's minions
    private $bummer = false;
}