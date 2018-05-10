<?php
/**
 * Created by PhpStorm.
 * User: Mingkai
 * Date: 2018/4/11
 * Time: 18:08
 */

require __DIR__ . "/../../vendor/autoload.php";

class UserTest extends \PHPUnit_Framework_TestCase
{
    public function test_construct() {
        $row = array('id' => 12,
            'email' => 'dude@ranch.com',
            'name' => 'Team name',
        );
        $user = new Bummer\User($row);
        $this->assertEquals(12, $user->getId());
        $this->assertEquals('dude@ranch.com', $user->getEmail());
        $this->assertEquals('Team name', $user->getName());
    }
}