<?php
/**
 * Created by PhpStorm.
 * User: Mingkai
 * Date: 2018/4/6
 * Time: 16:09
 */

namespace Bummer;


class HomeView extends View
{
    private $get;
    public function __construct($site,$session, $get){
        parent::__construct($session);
        $this->session = $session;
        $this->get = $get;
        $this->site = $site;
        $this->setTitle("Start or Join a Game");
        $this->addLink("instructions.php", "Instructions");
    }

    public function present()
    {
        $html = <<<HTML
    <form method="post" action="post/home.php">
    <fieldset>
        <table id="game-select">
            <tr>
                <th>Game ID</th>
                <th>Players</th> 
            </tr>
HTML;
        $games = new Games($this->site);
        $all = $games->getGames();
        foreach($all as $gameId) {
            $id = $gameId['id'];
            $playerIDs = $games->getPlayerIds($id);
            $playerCnt = 0;
            foreach($playerIDs as $playerID) {
                if($playerID !== null){
                    $playerCnt += 1;
                }
            }
            if($playerCnt == 4){
                continue;
            }
            $html .= <<<HTML
            <tr>
                <td>
                    <label class="container">$id<input type="radio" name="gameid" id="gameid" value="$id"><span class="checkmark" /></label>
                </td>
                <td>$playerCnt/4</td>
            </tr>
HTML;
        }
        $html .= <<<HTML
       
            </table>
            <p>
            <input type="submit" name="join" id="join" value="join">
            <input type="submit" name="newgame" id="newgame" value="newgame">
            </p>
HTML;
        $html .= $this->displayError();
        $html .= <<<HTML
        </fieldset>
    </form>
HTML;
        return $html;
    }

    public function displayError(){
        $html = '';
        if(isset($this->get['e'])){
            $html = "<p class=\"msg\">" . $this->session[HomeController::SESSION_ERROR] . "</p>";
        }

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
    protected $site;

}