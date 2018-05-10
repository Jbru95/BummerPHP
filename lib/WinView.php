<?php
/**
 * Created by PhpStorm.
 * User: Dakota
 * Date: 4/12/2018
 * Time: 9:51 PM
 */

namespace Bummer;


class WinView extends View
{
    public function __construct($session){
        parent::__construct($session);
        $this->setTitle('New User');
    }

    public function present() {

    }
}