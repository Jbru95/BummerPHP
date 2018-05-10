<?php
require __DIR__ . "/../../vendor/autoload.php";
/** @file
 * Empty unit testing template
 * @cond
 * Unit tests for the class
 */

class CardTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Ensure that constructor is valid.
     */
    public function test_Constructor() {
        $card1 = new Bummer\Card(1);
        $this->assertInstanceOf('Bummer\Card', $card1);
        $this->assertEquals(1, $card1->getCardNum());
        $this->assertContains("images/card-1.png", $card1->getImage());

    }


    /**
     * Ensure that flag is false by default and getter and setter work.
     * @author liamb
     */
    /*public function test_flag() {
        $card = new Bummer\Card(1);
        $this->assertEquals(false, $card->getFlag());
        $card->setFlag(true);
        $this->assertEquals(true, $card->getFlag());
    }
    */

    /**
     * Ensure that playCard has the desired effects when only one minion is in play.
     */
    public function test_playCard_single_minion() {
        $game = new Bummer\Game();
        $card1 = new Bummer\Card(1);
        $card2 = new Bummer\Card(2);
        $card3 = new Bummer\Card(3);
        $card4 = new Bummer\Card(4);
        $card5 = new Bummer\Card(5);
        $card7 = new Bummer\Card(7);
        $card8 = new Bummer\Card(8);
        $card10 = new Bummer\Card(10);
        $card11 = new Bummer\Card(11);
        $card12 = new Bummer\Card(12);
        $cardBummer = new Bummer\Card(13);

        $minion = new Bummer\Minion("blue", 1, $game);
        $this->assertEquals(0, $minion->getPosition());

        // Play a 3 card from Start - minion should not be able to leave start.
        $card3->playCard($minion, array(6, 0));
        $this->assertEquals(0, $minion->getPosition());
        //$this->assertTrue($card3->playCard($minion, array(6, 0)));

        // Play a 2 card from Start - minion should only move to the first space.
        $card2->playCard($minion, array(4, 0));
        $this->assertEquals(0, $minion->getPosition());
        //$this->assertTrue($card2->playCard($minion, array(4, 0)));

        // Play a 5 card from the first space - minion should land on a slide.
        $card5->playCard($minion, array(9, 0));
        $this->assertEquals(0, $minion->getPosition());
        //$this->assertTrue($card5->playCard($minion, array(9, 0)));

        // 7 and 1 should simply move forward.
        $card7->playCard($minion, array(15, 5));
        //$this->assertTrue($card7->playCard($minion, array(15, 5)));
        $card1->playCard($minion, array(15, 6));
        //$this->assertTrue($card1->playCard($minion, array(15, 6)));
        $this->assertEquals(0, $minion->getPosition());

        // Try to use a bummer card - should fail.
        $cardBummer->playCard($minion, array(15, 10));
        //$this->assertFalse($cardBummer->playCard($minion, array(15, 10)));

        // Play a 4 card - minion should move backwards.
        $card4->playCard($minion, array(15, 2));
        $this->assertEquals(0,$minion->getPosition());
        //$this->assertTrue($card4->playCard($minion, array(15, 2)));

        // Play a 10 card to move 10 spaces forward.
        $card10->playCard($minion, array(15, 12));
        $this->assertEquals(0,$minion->getPosition());
        //$this->assertTrue($card10->playCard($minion, array(15, 12)));
        // Play a 10 card to move 1 space backward.
        $card10->playCard($minion, array(15, 11));
        $this->assertEquals(0,$minion->getPosition());
        //$this->assertTrue($card10->playCard($minion, array(15, 11)));
        // Play an 11 card to move 11 spaces forward.
        $card11->playCard($minion, array(8, 15));
        $this->assertEquals(0,$minion->getPosition());
        //$this->assertTrue($card11->playCard($minion, array(8, 15)));
        // Play an 11 card to move 2 spaces backward.
        $card11->playCard($minion, array(10, 15));
        $this->assertEquals(0,$minion->getPosition());
        //$this->assertTrue($card11->playCard($minion, array(10, 15)));
        // Enter the safety zone.
        $card8->playCard($minion, array(2, 15));
        //$this->assertTrue($card8->playCard($minion, array(2, 15)));
        $card12->playCard($minion, array(0, 5));
        //$this->assertTrue($card12->playCard($minion, array(0, 5)));
        $card10->playCard($minion, array(2, 3));
        //$this->assertTrue($card10->playCard($minion, array(2, 3)));
        $this->assertEquals(0,$minion->getPosition());

        // Make sure the minion can only reach home with the exact count.
        $card5->playCard($minion, array(2, 6)); // TODO: make sure this is the right array
        //$this->assertTrue($card5->playCard($minion, array(2, 6)));
        $this->assertEquals(0,$minion->getPosition());
        $card3->playCard($minion, array(2, 6)); // TODO: make sure this is the right array
        $this->assertEquals(0,$minion->getPosition());

    }

    /**
     * Ensure that playCard has the desired effects when more than one minion is in play.
     */
    public function test_playCard_multiple_minions()
    {
        $game = new Bummer\Game();
        $card1 = new Bummer\Card(1);
        $card2 = new Bummer\Card(2);
        $card3 = new Bummer\Card(3);
        $card4 = new Bummer\Card(4);
        $card5 = new Bummer\Card(5);
        $card7 = new Bummer\Card(7);
        $card8 = new Bummer\Card(8);
        $card10 = new Bummer\Card(10);
        $card11 = new Bummer\Card(11);
        $card12 = new Bummer\Card(12);
        $cardBummer = new Bummer\Card(13);

        $minionBlue1 = new Bummer\Minion("blue", 1, $game);
        $minionBlue2 = new Bummer\Minion("blue", 1, $game);
        $minionGreen = new Bummer\Minion("green", 1, $game);

        $this->assertEquals(0, $minionBlue1->getPosition());
        $this->assertEquals(0, $minionBlue2->getPosition());
        $this->assertEquals(0, $minionGreen->getPosition());

        // Move minionGreen into play.
        $card2->playCard($minionGreen, array(11, 15));
        $this->assertEquals(0, $minionGreen->getPosition());

        // Ensure that bummer can't be used on a minion in start.
        $cardBummer->playCard($minionGreen, array(4, 2));
        $this->assertEquals(0, $minionBlue1->getPosition());
        $this->assertEquals(0, $minionGreen->getPosition());

        // minionBlue1 uses bummer on minionGreen. This should move minionBlue1 into minionGreen's spot.
        // and bump minionGreen back to start.
        $cardBummer->playCard($minionBlue1, array(11, 15));
        $this->assertEquals(0, $minionBlue1->getPosition());
        $this->assertEquals(0, $minionGreen->getPosition());

        // minionGreen comes back into play, landing on minionBlue1. This should bump minionBlue1 back to start.
        $card1->playCard($minionGreen, array(4, 0));
        $this->assertEquals(0, $minionBlue1->getPosition());
        $this->assertEquals(0, $minionGreen->getPosition());

        // Set up both blue minions on the right blue slide to be bumped by minionGreen.
        $card1->playCard($minionBlue1, array(4, 0));
        $card5->playCard($minionBlue1, array(9, 0));
        $this->assertEquals(6, $minionBlue1->getPosition());
        $card1->playCard($minionBlue2, array(4, 0));
        $card7->playCard($minionBlue2, array(11, 0));
        $this->assertEquals(8, $minionBlue2->getPosition());

        // Move minionGreen to the slide to bump both blue minions.
        $card12->playCard($minionGreen, array(0, 14));
        $card12->playCard($minionGreen, array(1, 0));
        $card5->playCard($minionGreen, array(9, 0));
        $this->assertEquals(6, $minionBlue1->getPosition());
        $this->assertEquals(8, $minionBlue2->getPosition());
        $this->assertEquals(8, $minionBlue2->getPosition());

        // Move minionGreen to the safe zone.
        $card11->playCard($minionGreen, array(9, 15));
        $card5->playCard($minionGreen, array(13, 14));
        $this->assertEquals(0, $minionGreen->getPosition());

        // Ensure that bummer can't be used on a minion in either the safe zone or in home
        $cardBummer->playCard($minionBlue1, array(13, 14));
        $this->assertEquals(0, $minionGreen->getPosition());
        $this->assertEquals(6, $minionBlue1->getPosition());
        $card5->playCard($minionGreen, array(13, 8));       // TODO: make sure this is the right array
        $cardBummer->playCard($minionBlue1, array(13, 8));  // TODO: make sure this is the right array
        $this->assertEquals(0, $minionGreen->getPosition());
        $this->assertEquals(6, $minionBlue1->getPosition());
    }
}

/// @endcond