<?php
/**
 * Created by PhpStorm.
 * User: Mingkai
 * Date: 2018/4/6
 * Time: 16:22
 */

$open = true;
require '../lib/site.inc.php';
$controller = new Bummer\HomeController($site, $_SESSION, $_POST);
header("location: " . $controller->getRedirect());