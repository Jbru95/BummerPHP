<?php
/**
 * Created by PhpStorm.
 * User: Mingkai
 * Date: 2018/4/3
 * Time: 15:29
 */

namespace Bummer;


class LoginController{

    public function __construct(Site $site, array &$session, array $post)
    {
        $users = new Users($site);

        $email = strip_tags($post['email']);
        $password = strip_tags($post['password']);
        $user = $users->login($email, $password);
        $session[User::SESSION_NAME] = $user;

        $root = $site->getRoot();
        if ($user === null) {
            $this->redirect = "$root/login.php?e";
            $session['ERROR'] = "Invalid Login Credentials";
        }
        else {
            $this->redirect = "$root/";
            $_SESSION["inTurn"] = false;
        }
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