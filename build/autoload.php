<?php
    /**
     * TODO: Test Discord & Twitch login.
     * 
     * TODO: Add expiry and refreshing of Discord OAuth2 token.
     * TODO: Add comments to Discord and Twitch functionality.
     * 
     * TODO: Add Zima\App\Session
     * TODO: Add Zima\Twitter
     * TODO: Add Zima\Google
     */

    session_start();
    
    require_once './config/config.php';

    ini_set('display_errors', 0);
    ini_set('display_startup_errors', 0);
    // error_reporting(E_ALL);

    // Require base interfaces...
    require_once './src/App/BitwiseInterface.php';
    require_once './src/App/CookieInterface.php';
    require_once './src/App/SiteInterface.php';
    require_once './src/App/TimeInterface.php';

    // Require base classes...
    require_once './src/App/Bitwise.php';
    require_once './src/App/Cookie.php';
    require_once './src/App/Site.php';
    require_once './src/App/Time.php';

    // Additional interfaces
    require_once './src/Data/APIInterface.php';
    require_once './src/Data/MySQLInterface.php';
    require_once './src/Discord/OAuth2Interface.php';
    require_once './src/Discord/UserInterface.php';
    require_once './src/Twitch/OAuth2Interface.php';
    require_once './src/Twitch/UserInterface.php';

    // Additional classes
    require_once './src/Data/API.php';
    require_once './src/Data/MySQL.php';
    require_once './src/Discord/Discord.php';
    require_once './src/Discord/OAuth2.php';
    require_once './src/Discord/User.php';
    require_once './src/Twitch/Twitch.php';
    require_once './src/Twitch/OAuth2.php';
    require_once './src/Twitch/User.php';