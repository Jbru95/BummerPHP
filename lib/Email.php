<?php
/**
 * Created by PhpStorm.
 * User: HP
 * Date: 2018/3/25
 * Time: 13:51
 */

namespace Bummer;


/**
 * Email adapter class
 */
class Email {
    public function mail($to, $subject, $message, $headers) {
        mail($to, $subject, $message, $headers);
    }
}