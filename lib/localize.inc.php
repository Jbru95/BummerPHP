<?php
/**
 * Function to localize our site
 * @param $site, the site object
 */
return function(Bummer\Site $site) {
    // Set the time zone
    date_default_timezone_set('America/Detroit');
    $site->setEmail('bohllia1@msu.edu');
    $site->setRoot('/~armbru43/project2'); // don't change or commit this
    $site->dbConfigure('mysql:host=mysql-user.cse.msu.edu;dbname=bohllia1',
        'bohllia1',       // Database user
        'thriftystairways',     // Database password
        'bummer_');            // Table prefix

};


