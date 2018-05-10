<?php
require __DIR__ . "/../../vendor/autoload.php";
/** @file
 * Empty unit testing template
 * @cond 
 * Unit tests for the class
 */
//require '../../lib/Deck.php';

class DeckTest extends \PHPUnit_Framework_TestCase
{
	public function test_Constructor() {
        $deck_obj = new Bummer\Deck();
	    $this->assertInstanceOf('Bummer\Deck', $deck_obj);
	}

	public function test_add_draw_size(){
	    $card1 = new Bummer\Card(1);
	    $card2 = new Bummer\Card(2);

	    $deck = new Bummer\Deck();

	    // Add cards 1 and 2.
	    $deck->addCard($card1);
	    $deck->addCard($card2);
	    $this->assertEquals(2, $deck->getDeckSize());

	    // Draw one card. Should return and remove the top card.
	    $ret_card_2 = $deck->drawCard();
	    $this->assertEquals(1, $deck->getDeckSize());
	    $this->assertEquals($card2, $ret_card_2);

	    // Draw again.
        $ret_card_1 = $deck->drawCard();
        $this->assertEquals(0, $deck->getDeckSize());
        $this->assertEquals($card1, $ret_card_1);
    }

    public function test_shuffle(){
	    srand(12);

	    // Create and a deck and add cards 1-6
        $deck = new Bummer\Deck();
        for ($i = 1; $i < 7; $i++) {
            $deck->addCard(new Bummer\Card($i));
        }

        // Check order of cards
        $deck_str = "";
        foreach ($deck->getDeck() as $card) {
            $deck_str = $deck_str . $card->getCard();
        }
        $this->assertEquals("123456", $deck_str);

        $deck->shuffleDeck();

        // Check new order (should be the same each time since a constant seed was used.)
        $deck_str = "";
        foreach ($deck->getDeck() as $card) {
            $deck_str = $deck_str . $card->getCard();
        }
        $this->assertEquals("426135", $deck_str);

    }

    public function test_generate_game_deck(){
        // Create a shuffled game deck.
	    $deck = new Bummer\Deck();
	    $deck->generate_game_deck();

        // Verify there are 45 cards.
	    $this->assertEquals(45,  $deck->getDeckSize());

        // Draw all 45 cards, leaving and empty Deck->deck array.
	    foreach( $deck->getDeck() as $card){
	        $deck->drawCard();
        }
        $this->assertEquals(0, $deck->getDeckSize());

        // Draw another card from the empty deck and make sure the deck is regenerated.
        $deck->drawCard();
        $this->assertEquals(44, $deck->getDeckSize());
    }
}

/// @endcond
