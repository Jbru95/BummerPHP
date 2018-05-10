<?php
require __DIR__ . "/lib/site.inc.php";
if ($_SESSION["inTurn"] == true) {
    $game = $_SESSION["game"];
} else {
    $game = new Bummer\Game($site, $_SESSION);//controller getting $game from JSON
    $_SESSION['game'] = $game;
}
$view = new Bummer\GameView($game, $_SESSION);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php echo $view->head(); ?>
    <script>
        /**
         * Initialize monitoring for a server push command.
         * @param key Key we will receive.
         */
        function pushInit(key) {
            var conn = new WebSocket('ws://webdev.cse.msu.edu/ws');
            conn.onopen = function (e) {
                console.log("Connection to push established!");
                conn.send(key);
            };

            conn.onmessage = function (e) {
                try {
                    var msg = JSON.parse(e.data);
                    if (msg.cmd === "reload") {
                        location.reload();
                    }
                } catch (e) {
                }
            };
        }

        pushInit("craigkeygame");
    </script>
</head>

<body>
<div class="game">
    <?php
    echo $view->header();
    echo $view->present();
    ?>
</div>
</body>

</html>