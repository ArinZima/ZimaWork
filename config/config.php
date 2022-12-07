<?php
    /**
     * Basic Information
     */
    define("WEBSITE_NAME", "My Website");
    define("DESCRIPTION", "My website, made using ZimaWork!");
    define("THEME_COLOR", "#000000");

    /**
     * HTTPS must be true or false
     */
    define("HTTPS", false);
    define("APP_DEBUG", true);
    
    /**
     * Database Information
     * 
     * If using MySQL with this framework, we recommend the InnoDB engine.
     */
    define("MYSQL", false);
    define("DB_HOST", "localhost");
    define("DB_USER", "root");
    define("DB_PASS", "");
    define("DB_NAME", "zimawork");

    /**
     * API Information
     * 
     * You can use an API alongside MySQL!
     */
    define("API", false);
    define("API_BASE", "https://api.example.com/v1/");
    define("API_AUTH", "");

    /**
     * Discord API
     * 
     * Use Discord within your app!
     * Currently limited to authentication and fetching the authenticated user.
     */
    define("DISCORD", true);
    define("DISCORD_CLIENT_ID", "");
    define("DISCORD_CLIENT_SECRET", "");
    define("DISCORD_REDIRECT_URI", "");
    define("DISCORD_SCOPES", "identify");

    define("DISCORD_REDIRECT_LOGIN", "");
    define("DISCORD_REDIRECT_LOGOUT", "");

    /**
     * Twitch API
     * 
     * Additionally, you may use Twitch in your app as well!
     * Currently limited to authentication and fetching the authenticated user.
     */
    define("TWITCH", false);
    define("TTV_CLIENT_ID", "");
    define("TTV_CLIENT_SECRET", "");
    define("TTV_REDIRECT_URI", "");
    define("TTV_SCOPES", "user:read:email");
    
    define("TTV_REDIRECT_LOGIN", "");
    define("TTV_REDIRECT_LOGOUT", "");
