<?php

namespace Bummer;

class InstructionsView extends View
{
    public function __construct($session) {
        $this->setTitle("Instructions");
        $this->addLink('game.php', "Game");
    }

    public function present(){
        $html = <<<HTML
<div id="team_info">
    <h2>Team Craig</h2>
    <ul>
        <li>Jayson Armbruster</li>
        <li>Liam Bohl</li>
        <li>Xu Huang</li>
        <li>Dakota Locklear</li>
        <li>Mingkai Yang</li>
    </ul>
</div>
HTML;

        $html .=<<< HTML
<div id="rules">
    <h2>Rules</h2>
    <p>The object of the game is to move all three minions into
        the Home area by moving clockwise around the game board.
        Each player in turn draws one card from the deck and follows
        its instructions. In my prototype, I click on the card in the
        middle of the board to draw. To begin the game, all of a
        player's three Minions are restricted to Start; a player can
        only move them out onto the rest of the board if he or she
        draws a 1 or 2 card. A 1 or a 2 places a Minion on the space
        directly outside of start (a 2 does not entitle the pawn to
        move a second space).</p>
    <p>A Minion can jump over any other Minion during its move.
        However, two Minions cannot occupy the same square; a Minion
        that lands on a square occupied by another player's Minion
        "bumps" that Minion back to its own Start.</p>
    <p>There are slides at various places on the board:</p>
    <p><img src="images/slide.png" alt="slide"></p>
    <p>If a Minion lands at the start of a slide, it immediately "slides"
        to the last square of the slide. All Minions on all spaces of the
        slide (including those belonging to the sliding player) are sent
        back to their respective Starts.</p>
    <p>The last five squares before each player's Home are "Safety
        Zones", and are specially colored corresponding to the colors
        of the Homes they lead to. Access is limited to Minions of the
        same color. Minions inside the Safety Zones are immune to being
        bumped by opponent's Minions or being switched with opponents'
        Minions via Bummer! cards. However, if a Minion is forced via a
        card to move backwards out of the Safety Zone, it is no longer
        considered "safe" and may be bumped by or switched with opponents'
        Minions as usual until it re-enters the Safety Zone.</p>
    <p>You must enter the Home by an exact count. For example, a player
        who is three spaces from Home cannot use a 5 card to move into Home.</p>
    <p>At any time a player can choose to Pass, meaning they do not play
        the card. A player may have to pass if there are no possible moves.</p>
    <p>The first player to get all three Minions into Home wins. A win should be
        clearly indicated on the screen and no further game play should be allowed.</p>
    <h2>Cards</h2>
    <p>There are 11 types of cards in a deck. When the game begins the deck consists of
        five 1 cards and four each of the other ten cards. The deck is shuffled. When
        the deck is exhausted, it is reshuffled and begins anew.</p>
    <p>There are no cards for 6 or 9.</p>
    <table id="card-definitions">
        <tr>
            <th>Card</th>
            <th>Effect</th>
        </tr>
        <tr>
            <th><img src="images/card-1.png" alt="card-1"></th>
            <td>The player can move a Minion from Start to the first open square or move
                a Minion one space forward.</td>
        </tr>
        <tr>
            <th><img src="images/card-2.png" alt="card-2"></th>
            <td>The player can move a Minion from Start to the first open square or move a
                Minion two spaces forward.</td>
        </tr>
        <tr>
            <th><img src="images/card-3.png" alt="card-3"></th>
            <td>The player can move a Minion three spaces forward.</td>
        </tr>
        <tr>
            <th><img src="images/card-4.png" alt="card-4"></th>
            <td>The player can move a Minion four spaces backwards.</td>
        </tr>
        <tr>
            <th><img src="images/card-5.png" alt="card-5"></th>
            <td>The player can move a Minion five spaces forward.</td>
        </tr>
        <tr>
            <th><img src="images/card-7.png" alt="card-7"></th>
            <td>The player can move a Minion seven spaces forward.</td>
        </tr>
        <tr>
            <th><img src="images/card-8.png" alt="card-8"></th>
            <td>The player can move a Minion eight spaces forward.</td>
        </tr>
        <tr>
            <th><img src="images/card-10.png" alt="card-10"></th>
            <td>The player can move a Minion ten spaces forward or one space backwards.</td>
        </tr>
        <tr>
            <th><img src="images/card-11.png" alt="card-11"></th>
            <td>The player can move a Minion eleven spaces forward or two spaces backwards.</td>
        </tr>
        <tr>
            <th><img src="images/card-12.png" alt="card-12"></th>
            <td>The player can move a Minion twelve spaces forward.</td>
        </tr>
        <tr>
            <th><img src="images/card-bummer.png" alt="card-bummer"></th>
            <td>The player can select any opponent Minion not in Start, Home, or a safety zone,
                placing their Minion over that one, bumping it back to the opponent's start.</td>
        </tr>
        <tr>
            <th><img src="images/card-back.png" alt="card-back"></th>
            <td>This is the back of a card.</td>
        </tr>
    </table>

</div>
HTML;
        return $html;
    }

}