<?php


namespace Bummer;


class GameController
{
    const SESSION_GAME = "game";

    /**
     * Constructor
     * @param Site $site site object
     * @param array $session $_SESSION
     * @param $post  $_POST array
     */
    public function __construct($site, $session, $post) {
        $root = $site->getRoot();
        $this->game = $session[self::SESSION_GAME];

        if($session[User::SESSION_NAME]->getName() != $this->game->GetCurrentPlayer()->getName()){
            $this->redirect = "$root/game.php";
            return;
        }

        if($this->game->GetCurrentPlayer()->checkWin() === true){
            $this->redirect = "$root/win.php";
            return;
        }

        if(isset($post['square'])){
            $this->game->Click($post['square']);
        }

        $this->redirect = "$root/game.php";
    }

    public function getRedirect()
    {
        return $this->redirect;
    }


    private $game;          // The Game object we are controlling
    private $redirect;      // Site to redirect to
}