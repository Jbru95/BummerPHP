<?php

namespace Bummer;


class LoginView extends View {
    public function __construct($session, $get){
        parent::__construct($session);
        $this->get = $get;
        $this->addLink("new-user.php", "New User?");
    }

    public function presentForm(){
        $html = <<<HTML
<form action="post/login.php" method="post">
	<fieldset>
		<p>
			<label for="email">Email</label><br>
			<input type="email" id="email" name="email">
		</p>
		<p>
			<label for="password">Password</label><br>
			<input type="password" id="password" name="password">
		</p>
		<p>
			<input type="submit" value="Log in"> 
		</p>
HTML;
        $html .= $this->displayLoginError();
        $html .= <<<HTML
	</fieldset>
</form>
HTML;
        return $html;
    }

    public function displayLoginError(){
        $html = '';
        if(isset($this->get['e'])){
            $html = "<p class=\"msg\"> " . $this->session['ERROR'] . "</p>";
        }

        return $html;
    }

    private $get;
}