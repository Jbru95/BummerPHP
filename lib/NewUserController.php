<?php
/**
 * Created by PhpStorm.
 * User: Jayson
 * Date: 4/3/2018
 * Time: 7:37 PM
 */

namespace Bummer;

class NewUserController{

    private $redirect;

    public function getRedirect(){
        return $this->redirect;
    }

    public function __construct(Site $site, $session, $post){
        $root = $site->getRoot();
        $this->redirect = "$root/";

        if(isset($post['cancel'])){
            $this->redirect = "new-user.php";
            return;
        }


        // Get all of the stuff from the form
        $email = strip_tags($post['email']);
        $name = strip_tags($post['name']);

        $row = array('id' => null,
            'email' => $email,
            'name' => $name,
            'password' => null,
        );
        $editUser = new User($row);//called edituser because shares name w/ param

        $users = new Users($site);
        // This is a new user
        $mailer = new Email();
        $users->add($editUser, $mailer);

    }

}
