<?php
/**
 * Function to localize our game
 * @param $game The Site object
 */
return function(Bummer\Site $site) {
    // Set the time zone
    date_default_timezone_set('America/Detroit');
    $site->setEmail('huangxu5@msu.edu');
    $site->setRoot('/~huangxu5/project2'); // don't change or commit this
    $site->dbConfigure('mysql:host=mysql-user.cse.msu.edu;dbname=bohllia1',
        'bohllia1',       // Database user
        'thriftystairways',     // Database password
        'bummer_test_');            // Table prefix

};


