<?php
/**
 * Created by PhpStorm.
 * User: Mingkai
 * Date: 2018/4/8
 * Time: 18:56
 */

namespace Bummer;


class LobbyController{

    private $redirect;

    public function getRedirect(){
        return $this->redirect;
    }

    public function __construct( Site $site, $session, $post){

        $root = $site->getRoot();
        $this->redirect = "$root/lobby.php";
        if(isset($session[HomeController::SESSION_GAME_ID])){
            $gameid = $session[HomeController::SESSION_GAME_ID];
        }
        else{
            $this->redirect = "$root/instructions.php";
            return;
        }

        $users = new Users($site);
        $userid = $session[User::SESSION_NAME]->getId();
        $game = new Games($site);

        if(isset($post['leave'])){
            $this->redirect = "$root/index.php";
            $game->removePlayer($gameid, $userid);
            $users->setRedirect($userid, "$root/index.php");
            new Reload('craigkey');
        }
        if(isset($post['start'])){
            $playerCnt = $game->getNumberOfPlayers($gameid);
            $usersInGame = $game->getPlayerIds($gameid);
            if($playerCnt > 1) {
                //$this->redirect = "$root/game.php";
                foreach($usersInGame as $playerId){
                    if ($playerId !== null) {
                        $users->setRedirect($playerId, "$root/game.php");
                    }
                }
                new Reload('craigkey');
            }
            
        }

    }
}