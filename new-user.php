<?php
$open = true;
require __DIR__ . "/lib/site.inc.php";
$view = new Bummer\NewUserView($_SESSION);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php echo $view->head(); ?>
</head>

<body>
<div class="new-user">
    <?php
    echo $view->header();
    echo $view->present();
    ?>
</div>
</body>

</html>