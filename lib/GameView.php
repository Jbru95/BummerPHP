<?php

namespace Bummer;

class GameView extends View
{
    const BUMMER_CARD = 13;     // Card number for bummer cards

    public function __construct(Game $game, $session) {
        parent::__construct($session);
        $this->game = $game;
        $this->setTitle("Minion Bummer");
        $this->addLink("instructions.php", "Instructions");
    }

    public function present(){
        $players = $this->game->getPlayers();
        $html = "<form method='post' action='post/game.php'><div class='game-board'>";
        for($i = 0; $i < 16; $i++){
            $html.="<div class='row'>";

            for($j = 0; $j < 16; $j++){
                $html.='<div class="cell"><input type = "submit" name="square" value = "'.$j.','.$i.'"';
                if( $j ==6 and $i == 4 ){
                    $html.= ' class="draw_card"';
                }
                if ( $j == 9 and $i == 4){
                    $html.= ' class="end_turn"';
                }
                foreach($players as $player){
                    foreach($player->getMinions() as $minion){
                        $minion_pos = $minion->getArrayFromPosition($minion->getPosition());
                        if ($minion_pos['c'] == $j and $minion_pos['r'] == $i and $minion->getColor() == "yellow"){
                            $html.= ' class="yellow"';
                        }
                        else if ($minion_pos['c'] == $j and $minion_pos['r'] == $i and $minion->getColor() == "red"){
                            $html.= ' class="red"';
                        }
                        else if ($minion_pos['c'] == $j and $minion_pos['r'] == $i and $minion->getColor() == "green"){
                            $html.= ' class="green"';
                        }
                        else if ($minion_pos['c'] == $j and $minion_pos['r'] == $i and $minion->getColor() == "blue"){
                            $html.= ' class="blue"';
                        }
                    }
                }
                $html.="</div></div>";
            }
            $html.="</div>";
        }
        $html.= "</div></form>";

        $current_player = $this->game->GetCurrentPlayer();
        $current_card = $this->game->getCurrentCard();

        if($current_card === null) {
            $html .= '<image src="images/card-back.png" alt="an image of decks card back" height="308px" width="200px" class="card">';
        }
        elseif($current_card->getCard() == self::BUMMER_CARD){
            $html .= '<image src="images/card-bummer.png" alt="an image of the bummer card" height="308px" width="200px" class="card">';
        }
        else{
            $html .= '<image src="images/card-'.(string)$current_card->getCard().'.png" alt="an image of decks card back" height="308px" width="200px" class="card">';
        }

        $html.= '<p class = "player_display">Player: '.$current_player->getName().' <image src="images/minion-'.$current_player->getColor().'.png" height="28px" width="28px" alt="a minion"></p>';

        return $html;
    }

    private $game;
}