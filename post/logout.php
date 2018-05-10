<?php
$open = true;
require '../lib/site.inc.php';

$controller = new Bummer\LogoutController($site, $_SESSION);
header("location: " . $controller->getRedirect());