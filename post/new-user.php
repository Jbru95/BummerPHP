<?php

$open = true;
require '../lib/site.inc.php';
$controller = new Bummer\NewUserController($site, $_SESSION, $_POST);
header("location: " . $controller->getRedirect());