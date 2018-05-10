<?php
$open = true;
require __DIR__ . "/lib/site.inc.php";
$view = new Bummer\WinView($_SESSION);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php echo $view->head(); ?>
</head>

<body>
<div class="Win">
    <?php
    echo $view->header();
    echo $view->present();
    ?>
</div>
</body>

</html>