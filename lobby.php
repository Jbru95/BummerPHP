<?php
/**
 * Created by PhpStorm.
 * User: Mingkai
 * Date: 2018/4/6
 * Time: 15:55
 */
require __DIR__ . "/lib/site.inc.php";
$view = new Bummer\LobbyView($site, $_SESSION, $_GET);
if($view->isRedirect()) {
    header("location: " . $view->getRedirect());
    $view->resetRedirect();
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
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


        pushInit("craigkey");
    </script>
    <?php echo $view->head(); ?>
</head>

<body>
<div class="lobby">
    
    <?php
    echo $view->lobbyHeader();
    echo $view->present();
    ?>

</div>

</body>
</html>