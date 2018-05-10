<?php
require __DIR__ . "/../vendor/autoload.php";

$site = new Bummer\Site();
$localize = require __DIR__ . '/localize.inc.php';
if(is_callable($localize)) {
    $localize($site);
}

// Start the PHP session system
session_start();
define("SITE_SESSION", 'site');
if(isset($_SESSION[SITE_SESSION])){
    $site = $_SESSION[SITE_SESSION];
}

$user = null;
if(isset($_SESSION[Bummer\User::SESSION_NAME])) {
    $user = $_SESSION[Bummer\User::SESSION_NAME];
}

// redirect if user is not logged in
if(!isset($open) && $user === null) {
    $root = $site->getRoot();
    header("location: $root/login.php");
    exit;
}