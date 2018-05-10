<?php
$open = true;
require '../lib/site.inc.php';
$controller = new Bummer\PasswordValidateController($site, $_POST);
header("location: " . $controller->getRedirect());