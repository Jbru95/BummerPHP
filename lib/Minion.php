<?php
/**
 * Created by PhpStorm.
 * User: Xu Huang
 * Date: 2018/2/16
 * Time: 13:57
 */

namespace Bummer;

class Minion
{
    const POSSIBLEPOSITIONS = 0;
    const SLIDE = array(13, 14, 15, 21, 22, 23, 24, 28, 29, 30, 36, 37, 38, 39, 43, 44, 45, 51, 52, 53, 54);
    const SLIDE_START = array(13,21,28,36,43,51);

    // Gordon
    public function __construct($c, $homeBase, $game)
    {
        $this->homeBase = $homeBase;
        $this->color = $c;
        $this->setGame($game);
        switch ($c) {
            case "blue":
                $this->image = "images/minion-blue.png";
                break;
            case "green":
                $this->image = "images/minion-green.png";
                break;
            case "red":
                $this->image = "images/minion-red.png";
                break;
            case "yellow":
                $this->image = "images/minion-yellow.png";
                break;

        }
    }

    public function a($position){
        $other_minion = $this->game->getMinion($this->getArrayFromPosition($position));
        if($other_minion != null){
            $other_minion->bummer();
        }
    }

    // Gordon
    public function move($x)
    {
        $this->game->removeMinion($this->getArrayFromPosition($this->position));
        $this->position += $x;
        $this->a($this->position);
        $this->game->addMinion($this->getArrayFromPosition($this->position), $this);
        $pos = $this->position;
        if(in_array($pos, self::SLIDE_START)) {
            while (in_array($pos, self::SLIDE)) {
                $this->game->removeMinion($this->getArrayFromPosition($this->position));
                $this->position += 1;
                $this->a($this->position);
                $this->game->addMinion($this->getArrayFromPosition($this->position), $this);
                $pos = $this->position;
            }
        }
    }

    // Gordon
    public function bummer()
    {
        $this->game->removeMinion($this->getArrayFromPosition($this->position));
        $this->position = 0;
        $this->game->addMinion($this->getArrayFromPosition($this->position), $this);
    }


    public function bummer_card($pos, $r, $c){
        $oth_min_pos = ['c' => $c, 'r'=> $r];
        $other_minion = $this->game->getMinion($oth_min_pos);
        if( ($other_minion != null)) {
            $this->game->removeMinion($this->getArrayFromPosition($this->position));
            $this->position = $pos;
            $this->a($pos);
            $this->game->addMinion($this->getArrayFromPosition($this->position), $this);
            return true;
        }
        return false;
    }

    /**
     * @return mixed
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @param mixed $position
     */
    public function setPosition($position)
    {
        $this->position = $position;
    }

    /**
     * @return mixed
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param mixed $state
     */
    public function setState($state)
    {
        $this->state = $state;
    }

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @return mixed
     */
    public function getGame()
    {
        return $this->game;
    }

    /**
     * @param mixed $game
     */
    public function setGame($game)
    {
        $this->game = $game;
    }

    public function getColor()
    {
        return $this->color;
    }

    /**
     * Convert the location of the Minion into a row and column.
     * Yellow
     * @return array Array containing the row and column for the Minion
     */// Gordon
    private function getYellowArray() {
        if($this->position == 0) {
            // We are at home!
            return ['c'=>13, 'r'=>3 + $this->homeBase];
        } else if($this->position <= 12) {
            return ['c'=>15, 'r'=>3 + $this->position];
        } else if($this->position <= 27) {
            return ['c'=>15 - ($this->position - 12), 'r'=>15];
        } else if($this->position <= 42) {
            return ['c'=>0, 'r'=>15 - ($this->position - 27)];
        } else if($this->position <= 57) {
            return ['c'=>($this->position - 42), 'r'=>0];
        } else if($this->position <= 59) {
            return ['c' => 15, 'r' => ($this->position - 57)];
        } else if($this->position <= 64) {
            return ['c' =>15 - ($this->position - 59), 'r' => 2];
        } else if($this->position == 65){    // Home is at 65
            return ['c'=>8, 'r'=>1 + $this->homeBase];
        } else if($this->position == 66){
            return ['c'=>15, 'r'=>3];
        }
        return [];
    }

    /**
     * Get the cell on the board for this Minion
     * @returns array Array containing the absolute row and column
     */// Gordon
    public function getArrayFromPosition() {
        $cell = $this->getYellowArray();
        $r = $cell['r'];
        $c = $cell['c'];
        switch($this->color) {
            case "yellow":
                return $cell;
            case "red":     // Red
                return ['c' => Game::SIZE - $c - 1, 'r' => Game::SIZE - $r - 1];
            case "green":     // Green
                return ['c' => Game::SIZE - $r - 1, 'r' => $c];
            case "blue":     // Blue
                return ['c' => $r, 'r' => Game::SIZE - $c - 1];
        }
        return [];
    }

    // Gordon
    private function getYellowPosition($c, $r) {
        if($c == 13 and $r >= 3 and $r <= 5) {
            return 0;  // We are at home!
        } else if($c == 15 and $r >= 4 and $r <=15) {
            return $r - 3;
        } else if($r == 15 and $c >= 1 and $c <= 15) {
            return 27 - $c;
        } else if($c == 0 and $r >= 1 and $r <= 15) {
            return 42 - $r;
        } else if($r == 0 and $c >= 0 and $c <= 15) {
            return 42 + $c;
        } else if($c ==15 and $r >= 0 and $r <= 1) {
            return 57 + $r;
        } else if($r == 2 and $c >= 10 and $c <=15) {
            return 74 - $c;
        } else if($r >= 1 and $r <= 3 and $c == 8) {
            return 65;  // Home is at 65
        } else if($r == 3 and $c == 15){
            return 66;    // between 59 and 1
        }
        return [];
    }

    // Gordon
    public function getPositionFromArray($c, $r)
    {
        switch($this->color){
            case "yellow":
                return $this->getYellowPosition($c, $r);
            case "red":     // Red
                return $this->getYellowPosition(Game::SIZE - $c - 1, Game::SIZE - $r - 1);
            case "green":     // Green
                return $this->getYellowPosition($r, Game::SIZE - $c - 1);
            case "blue":     // Blue
                return $this->getYellowPosition(Game::SIZE - $r - 1, $c);
        }
        return [];
    }


    private $position = 0; //int
    private $state;
    private $image;
    private $game;
    private $color; //string
    private $homeBase;
}