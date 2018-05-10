<?php
/**
 * Created by PhpStorm.
 * User: Jayson
 * Date: 2/22/2018
 * Time: 1:52 AM
 */

namespace Bummer;


class HomeController{
    const SESSION_GAME_ID = "gameid";
    const SESSION_ERROR = "error";
    const FAILED_CREATE = "Failed to create game";
    const FAILED_JOIN = "Failed to join game";

    public function __construct(Site $site, array &$session, array $post)
    {
        $_SESSION['inTurn'] = false;
        $root = $site->getRoot();
        $this->redirect = "$root/";
        $users = new Users($site);
        $games = new Games($site);
        $userid = $session[User::SESSION_NAME]->getId();
        $gameid = 0;

        if(isset($post['newgame'])) {
            $gameid = $games->newGame($userid);
            if ($gameid === Null) {
                $this->redirect = "$root/index.php?e";
                $session[self::SESSION_ERROR] = self::FAILED_CREATE;
                $users->setRedirect($userid, "$root/index.php?e");
                new Reload('craigkey');
                return;
            }
        } elseif (isset($post['gameid'])) {
            $gameid = $post['gameid'];
            if ($games->joinGame($gameid, $userid) === False) {
                $this->redirect = "$root/index.php?e";
                $session[self::SESSION_ERROR] = self::FAILED_JOIN;
                $users->setRedirect($userid, "$root/index.php?e");
                new Reload('craigkey');
                return;
            }
        }

        $session[self::SESSION_GAME_ID] = $gameid;
        $this->redirect = "$root/lobby.php";
        $users->setRedirect($userid, "$root/lobby.php");
        new Reload('craigkey');
    }

    /**
     * @return mixed
     */
    public function getRedirect()
    {
        return $this->redirect;
    }

    private $redirect;   ///< Page we will redirect the user to.
}

