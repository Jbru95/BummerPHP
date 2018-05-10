<?php
/**
 * Created by PhpStorm.
 * User: Jayson
 * Date: 4/3/2018
 * Time: 7:38 PM
 */

namespace Bummer;


class NewUserView extends View{

    public function __construct($session){
        parent::__construct($session);
        $this->setTitle('New User');
    }

    public function present() {
        $html = <<<HTML
<form action="post/new-user.php" method="post">
	<fieldset>
		<p>
			<label for="name">Username: </label><br>
			<input type="text" id="name" name="name">
		</p>
		<p>
		    <label for="email">Email: </label><br>
			<input type="text" id="email" name="email">
        </p>
        
		<p><input type="submit" value="OK" name="ok"> <input type="submit" value="Cancel" name="cancel"></p>

	</fieldset>
</form>
HTML;

        return $html;
    }

}