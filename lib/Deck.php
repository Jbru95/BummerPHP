<?php
/**
 * Created by PhpStorm.
 * User: Jayson
 * Date: 2/15/2018
 * Time: 5:54 PM
 */
namespace Bummer;


class Deck //use generate_game_deck after the constructor to initialize the deck
{
    public $deck = array();
    private $deckSize = 0;
    public $deck_image_link = "images/card-back.png";
    private $DECK_LIST = array(1,1,1,1,1,2,2,2,2,3,3,3,3,4,4,4,4,5,5,5,5,7,7,7,7,8,8,8,8,10,10,10,10,11,11,11,11,12,12,12,12,13,13,13,13);
    private $card_pop;

    public function __construct($deckFromRow = null){//because no arguments need to be passed to the deck, empty constructor
        if($deckFromRow === null){
        }
        else{
            foreach( $deckFromRow as $cardNum){
                $this->deck[] = new Card($cardNum);
            }
            $this->deckSize = sizeof($this->deck);

        }
    }


    public function generate_game_deck(){//generates and shuffles a game-ready deck, accessed by Deck->getDeck() after this call

        foreach( $this->DECK_LIST as $card_num){
            $card = new Card($card_num);
            $this->addCard($card);
        }
        $this->shuffleDeck();

    }


    public function drawCard(){
        //pops and returns card at end of deck array, returns null if 0 cards in deck
        if ($this->deckSize > 0){//
            $this->deckSize -= 1;
        }
        elseif ($this->deckSize == 0){//if deck is empty
            $this->generate_game_deck(); //generate a new deck, deckSize set back at 45
            $this->deckSize -= 1;
        }
        $this->card_pop = end($this->deck);
        return array_pop($this->deck);
    }


    public function getDeck(){

        return $this->deck;
    }

    public function getDeckSize(){

        return $this->deckSize;
    }

    public function addCard(Card $card){

        $this->deck[] = $card;
        $this->deckSize += 1;
    }

    public function shuffleDeck(){

        shuffle($this->deck);
    }

    /**
     * @return mixed
     */
    public function getCardPop()
    {
        return $this->card_pop;
    }


}