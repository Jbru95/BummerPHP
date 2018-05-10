<?php
/**
 * Created by PhpStorm.
 * User: Mingkai
 * Date: 2018/4/6
 * Time: 16:09
 */

namespace Bummer;


class LobbyView extends View
{
    public function __construct($site, $session, $get) {
        parent::__construct($session);
        $this->session = $session;
        $this->setTitle("Lobby");
        $this->site = $site;
        $this->gameid = $session[HomeController::SESSION_GAME_ID];
    }

    public function present() {
        $html = <<<HTML
<div class="lobby-players">
    <table>
        <tr><th>Villain</th><th>Minions</th></tr>
HTML;

        $games = new Games($this->site);
        $players = $games->getPlayersInGame($this->gameid);
        $colors = array("green", "red", "blue", "yellow");

        for ($i = 0; $i < 4; $i++){
            if (!isset($players[$i])) {
                continue;
            }
            $name = $players[$i];
            $color = $colors[$i];

            $html .= <<<HTML
<tr>
    <td>$name</td>
    <td><img src="images/minion-$color.png" alt="$color minion"></td>
</tr>
HTML;
        }
        $html .= <<<HTML
</table>
</div>
<form action="post/lobby.php" method="post">
	<fieldset>
        <p>
        <input type="submit" name="leave" value="Leave"><input type="submit" name="start" value="Start">
        </p>
	</fieldset>
</form>
HTML;
        return $html;
    }

    public function lobbyHeader(){

        $html = "</nav><header><div><h1>Lobby " . $this->gameid . "</h1></div></header>";
        return $html;
    }

    public function isRedirect(){
        $userid = $this->session[User::SESSION_NAME]->getId();
        $users = new Users($this->site);
        $redirectStr = $users->getRedirectStr($userid);
        if($redirectStr !== null){
            return true;
        }
        else{
            return false;
        }
    }

    public function getRedirect(){

        $userid = $this->session[User::SESSION_NAME]->getId();
        $users = new Users($this->site);
        $redirectStr = $users->getRedirectStr($userid);
        return $redirectStr;
    }

    public function resetRedirect(){
        $userid = $this->session[User::SESSION_NAME]->getId();
        $users = new Users($this->site);
        $users->resetRedirect($userid);
    }

    protected $session;
    private $site;
    private $gameid;
}