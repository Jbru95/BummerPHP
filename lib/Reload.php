<?php
/**
 * Created by PhpStorm.
 * User: Jayson
 * Date: 4/12/2018
 * Time: 2:17 PM
 */

namespace Bummer;


class Reload
{

    public function __construct($key){//constructor pushes a reload command to all users w/ key $key

        $pushKey = $key;
        $msg = json_encode(array('key'=>$pushKey, 'cmd'=>'reload'));

        $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);

        $sock_data = socket_connect($socket, '127.0.0.1', 8078);
        if(!$sock_data) {
            echo "Failed to connect";
        } else {
            socket_write($socket, $msg, strlen($msg));
        }
        socket_close($socket);
    }
}