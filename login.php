<?php
/**
 * Created by PhpStorm.
 * User: Mingkai
 * Date: 2018/4/3
 * Time: 15:37
 */
$open = true;
require __DIR__ . "/lib/site.inc.php";
$view = new Bummer\LoginView($_SESSION, $_GET);
$view->setTitle('Login');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php echo $view->head(); ?>
</head>

<body>
<div class="login">
    <?php
    echo $view->header();
    echo $view->presentForm();
    ?>
</div>
</body>

</html>