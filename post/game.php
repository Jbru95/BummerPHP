<?php
require __DIR__ . '/../lib/site.inc.php';
$controller = new Bummer\GameController($site, $_SESSION, $_POST);
header("location: " . $controller->getRedirect());
