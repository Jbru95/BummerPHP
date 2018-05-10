<?php
/**
 * Created by PhpStorm.
 * User: Mingkai
 * Date: 2018/4/3
 * Time: 16:18
 */

$open = true;
require '../lib/site.inc.php';
$controller = new Bummer\LoginController($site, $_SESSION, $_POST);
header("location: " . $controller->getRedirect());