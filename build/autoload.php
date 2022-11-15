<?php
    /**
     * TODO: Add Zima\Twitter
     * TODO: Add Zima\Google
     */

    require './config/config.php';

    ini_set('display_errors', 0);
    ini_set('display_startup_errors', 0);
    // error_reporting(E_ALL);

    // Require base interfaces...
    require './src/App/BitwiseInterface.php';
    require './src/App/CookieInterface.php';
    require './src/App/SessionInterface.php';
    require './src/App/SiteInterface.php';
    require './src/App/TimeInterface.php';

    // Require base classes...
    require './src/App/Bitwise.php';
    require './src/App/Cookie.php';
    require './src/App/Session.php';
    require './src/App/Site.php';
    require './src/App/Time.php';

    // Additional interfaces
    require './src/Data/APIInterface.php';
    require './src/Data/MySQLInterface.php';

    require './src/Discord/OAuth2Interface.php';
    require './src/Discord/UserInterface.php';

    require './src/TTV/OAuth2Interface.php';
    require './src/TTV/UserInterface.php';

    // Additional classes
    require './src/Data/API.php';
    require './src/Data/MySQL.php';

    require './src/Discord/Discord.php';
    require './src/Discord/OAuth2.php';
    require './src/Discord/User.php';

    require './src/TTV/Twitch.php';
    require './src/TTV/OAuth2.php';
    require './src/TTV/User.php';