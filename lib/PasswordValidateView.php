<?php
/**
 * Created by PhpStorm.
 * User: HP
 * Date: 2018/3/25
 * Time: 15:08
 */

namespace Bummer;

//extends View
class PasswordValidateView extends View
{
    const INVALID_VALIDATOR = 1;
    const EMAIL_IS_NOT_FOR_A_VALID_USER = 2;
    const EMAIL_DOES_NOT_MATCH = 3;
    const PASSWORD_DID_NOT_MATCH = 4;
    const PASSWORD_TOO_SHORT = 5;

    public function __construct(Site $site, array $get, array $session) {
        parent::__construct($session);
        $this->site = $site;
        $this->setTitle("Change Your Password");
        $this->validator = strip_tags($get['v']);
        if(isset($get['e'])){
            switch($get['e']){
                case 1:
                    $error = "Invalid or unavailable validator.";
                    break;
                case 2:
                    $error = "Email address is not for a valid user.";
                    break;
                case 3:
                    $error = "Email address does not match validator.";
                    break;
                case 4:
                    $error = "Passwords did not match.";
                    break;
                case 5:
                    $error = "Password too short.";
                    break;
                default:
                    $error = "Unknown error.";
            }
            $this->error_msg = "<p class=\"msg\">$error</p>";
        }
    }

    public function present(){
        $html = <<<HTML
<form method="post" action="post/password-validate.php">
<input type="hidden" name="validator" value=$this->validator>
	<fieldset>
		<p>
			<label for="email">Email</label><br>
			<input type="email" id="email" name="email">
		</p>
		<p>
			<label for="password">New password</label><br>
			<input type="password" id="password" name="password">
		</p>
		<p>
			<label for="password2">Re-enter password</label><br>
			<input type="password" id="password2" name="password2">
		</p>
		<p>
			<input type="submit" value="OK" id="ok" name="ok"> <input type="submit" value="Cancel" id="cancel" name="cancel">
		</p>
        $this->error_msg
	</fieldset>
</form>
HTML;
        return $html;
    }

    private $site;	///< The Site object
    private $validator;
    private $error_msg = "";
}