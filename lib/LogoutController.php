<?php
/**
 * Created by PhpStorm.
 * User: liamb
 * Date: 3/25/2018
 * Time: 12:14 PM
 */

namespace Bummer;


class LogoutController {
    /**
     * LogoutController constructor.
     * @param Game $game The Game object
     * @param array $session $_SESSION
     */
    public function __construct(Site $site, array &$session) {
        unset($session[User::SESSION_NAME]);
        unset($session[Game::SESSION_NAME]);
        unset($session[HomeController::SESSION_GAME_ID]);
        unset($session[HomeController::SESSION_ERROR]);

        $root = $site->getRoot();
        $this->redirect = "$root/index.php";
    }

    /**
     * @return mixed
     */
    public function getRedirect() {
        return $this->redirect;
    }

    private $redirect;	///< Page we will redirect the user to.
}