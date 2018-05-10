<?php
/**
 * Created by PhpStorm.
 * User: Dakota
 * Date: 2/16/2018
 * Time: 2:11 PM
 */

namespace Bummer;


class Card
{
    /**
     * Card constructor.
     * @param $cardNum number of card that was pulled
     * @author Dakota
     */
    const SAFE_SPACES = array(0,60,61, 62, 63, 64, 65);

    public function __construct($cardNum){
        $this->cardNum = $cardNum;
        switch ($cardNum){
            case 1:
                $this->image = "images/card-1.png";
                break;
            case 2:
                $this->image = "images/card-2.png";
                break;
            case 3:
                $this->image = "images/card-3.png";
                break;
            case 4:
                $this->image = "images/card-4.png";
                break;
            case 5:
                $this->image = "images/card-5.png";
                break;
            case 7:
                $this->image = "images/card-7.png";
                break;
            case 8:
                $this->image = "images/card-8.png";
                break;
            case 10:
                $this->image = "images/card-10.png";
                break;
            case 11:
                $this->image = "images/card-11.png";
                break;
            case 12:
                $this->image = "images/card-12.png";
                break;
            case 13:
                $this->image = "images/card-bummer.png";
                break;
        }

    }

    /**
     * getCard.
     * @author Dakota
     */
    public function getCard(){
        return $this->cardNum;
    }


    /**
     * playCard.
     * @param $minion minion object to be moved
     * @param $buttonClicked array column and row of the space selected
     * @author Dakota
     */
    public function playCard(Minion $minion, $buttonClicked) {
        $c = $buttonClicked[0];
        $r = $buttonClicked[1];
        $button = $minion->getPositionFromArray($c, $r);

        switch($this->getCardNum()) {
            case 1:
                if ($minion->getPosition() == 66) {
                    if($button == 1) {
                        $minion->setPosition(1);
                        return true;
                    }
                } elseif ($minion->getPosition() != 65) {
                    if($button == $minion->getPosition() + 1) {
                        $minion->move(1);
                        return true;
                    }
                }
                break;
            case 2:
                if ($minion->getPosition() == 66) {
                    if($button == 2) {
                        $minion->setPosition(2);
                        return true;
                    }
                } elseif ($minion->getPosition() == 64) {
                    if($button == 64) {
                        $minion->setPosition(64);
                        return true;
                    }
                } elseif ($minion->getPosition() != 65) {
                    if($button == $minion->getPosition() + 2) {
                        $minion->move(2);
                        return true;
                    }
                }
                break;
            case 3:
                if ($minion->getPosition() == 66) {
                    if($button == 3) {
                        $minion->setPosition(3);
                        return true;
                    }
                } elseif ($minion->getPosition() > 62 and $minion->getPosition() < 65) {
                    $p = $minion->getPosition();
                    if($button == 65 + 65 - $p - 3){
                        $minion->setPosition(65);
                        $minion->move(65 - $p - 3);
                        return true;
                    }
                } elseif ($minion->getPosition() != 65 and $minion->getPosition() != 0) {
                    if($button == $minion->getPosition() + 3) {
                        $minion->move(3);
                        return true;
                    }
                }
                break;

            case 4:
                if ($minion->getPosition() == 66) {
                    if($button == 56){
                        $minion->setPosition(56);
                        return true;
                    }
                } elseif ($minion->getPosition() == 4) {
                    if($button == 66){
                        $minion->setPosition(66);
                        return true;
                    }
                } elseif ($minion->getPosition() < 4 and $minion->getPosition() > 0) {
                    if($button == $minion->getPosition() + 56){
                        $minion->move(56);
                        return true;
                    }
                } elseif ($minion->getPosition() != 0 and $minion->getPosition() != 65) {
                    if($button == $minion->getPosition() - 4){
                        $minion->move(-4);
                        return true;
                    }
                }
                break;

            case 5:
                if ($minion->getPosition() == 66) {
                    if($button == 5){
                        $minion->setPosition(5);
                        return true;
                    }
                } elseif ($minion->getPosition() > 60 and $minion->getPosition() < 65) {
                    $p = $minion->getPosition();
                    if($button == 65 + 65 - $p - 5) {
                        $minion->setPosition(65);
                        $minion->move(65 - $p - 5);
                        return true;
                    }
                } elseif ($minion->getPosition() != 65 and $minion->getPosition() != 0) {
                    if($button ==$minion->getPosition() + 5){
                        $minion->move(5);
                        return true;
                    }
                }
                break;

            case 7:
                if ($minion->getPosition() == 66) {
                    if($button == 7){
                        $minion->setPosition(7);
                        return true;
                    }
                } elseif ($minion->getPosition() > 58 and $minion->getPosition() < 65) {
                    $p = $minion->getPosition();
                    if($button == 65 + 65 - $p - 7){
                        $minion->setPosition(65);
                        $minion->move(65 - $p - 7);
                        return true;
                    }
                } elseif ($minion->getPosition() != 65 and $minion->getPosition() != 0) {
                    if($button == $minion->getPosition() + 7){
                        $minion->move(7);
                        return true;
                    }
                }
                break;

            case 8:
                if ($minion->getPosition() == 66) {
                    if($button == 8){
                        $minion->setPosition(8);
                        return true;
                    }
                } elseif ($minion->getPosition() > 57 and $minion->getPosition() < 65) {
                    $p = $minion->getPosition();
                    if($button == 65 + 65 - $p - 8) {
                        $minion->setPosition(65);
                        $minion->move(65 - $p - 8);
                        return true;
                    }
                } elseif ($minion->getPosition() != 65 and $minion->getPosition() != 0) {
                    if($button == $minion->getPosition() + 8){
                        $minion->move(8);
                        return true;
                    }
                }
                break;

            case 10:
                if ($minion->getPosition() == 66) {
                    if($button == 10){
                        $minion->setPosition(10);
                        return true;
                    }elseif($button == 59){
                        $minion->setPosition(59);
                        return true;
                    }
                } elseif ($minion->getPosition() > 55 and $minion->getPosition() < 65) {
                    $p = $minion->getPosition();
                    if($button == 65 + 65 - $p - 10) {
                        $minion->setPosition(65);
                        $minion->move(65 - $p - 10);
                        return true;
                    }
                } elseif ($minion->getPosition() != 65 and $minion->getPosition() != 0) {
                        if($button == $minion->getPosition() - 1){
                            $minion->move(-1);
                            return true;
                        } elseif($button == $minion->getPosition() + 10){
                            $minion->move(10);
                            return true;
                        }

                } elseif ($minion->getPosition() == 1) {
                    if($button == 66){
                        $minion->setPosition(66);
                        return true;
                    }
                }
                break;
            case 11:
                if ($minion->getPosition() == 66) {
                    if($button == 11){
                        $minion->setPosition(11);
                        return true;
                    } elseif($button == 58){
                        $minion->setPosition(58);
                        return true;
                    }
                } elseif ($minion->getPosition() > 54 and $minion->getPosition() < 65) {
                    $p = $minion->getPosition();
                    if($button == 65 + 65 - $p - 11) {
                        $minion->setPosition(65);
                        $minion->move(65 - $p - 11);
                        return true;
                    }
                } elseif ($minion->getPosition() != 65 and $minion->getPosition() != 0) {
                        if($button == $minion->getPosition() - 2) {
                            $minion->move(-2);
                            return true;
                        } elseif($button == $minion->getPosition() + 11){
                            $minion->move(11);
                            return true;
                        }
                } elseif ($minion->getPosition() == 2) {
                    if ($button == 66) {
                        $minion->setPosition(66);
                        return true;
                    }
                } elseif ($minion->getPosition() == 1) {
                    if($button == 59){
                        $minion->setPosition(59);
                        return true;
                    }
                }
                break;
            case 12:
                if ($minion->getPosition() == 66) {
                    if($button == 12){
                        $minion->setPosition(12);
                        return true;
                    }
                } elseif ($minion->getPosition() > 53 and $minion->getPosition() < 65) {
                    $p = $minion->getPosition();
                    if($button == 65 + 65 - $p - 12) {
                        $minion->setPosition(65);
                        $minion->move(65 - $p - 12);
                        return true;
                    }
                } elseif ($minion->getPosition() != 65 and $minion->getPosition() != 0) {
                    if($button == $minion->getPosition() + 12){
                        $minion->move(12);
                        return true;
                    }
                }
                break;
            case 13:
                if(in_array($button, self::SAFE_SPACES) == false) {
                    if ($minion->getPosition() == 0 &&  in_array($button, Card::SAFE_SPACES) == false) {
                        $other_min_r = $r;
                        $other_min_c =  $c;
                        return $minion->bummer_card($button, $other_min_r, $other_min_c);

                    }
                    return false;
                }
                break;

            default:
                return false;
        }
    }
    /**
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }
    /**
     * @return number
     */
    public function getCardNum()
    {
        return $this->cardNum;
    }


    private $image;
    private $cardNum;
}