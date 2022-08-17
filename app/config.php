<?php
    /**
     * Basic Information
     */
    /**
     * DOMAIN must be name.extension
     * define("DOMAIN", "example.com")
     */
    define("DOMAIN", "example.com");
    define("WEBSITE_NAME", "My Website");
    define("DESCRIPTION", "My Website Description");
    define("THEME_COLOR", "#000000");
    /**
     * HTTPS must be true or false
     */
    define("HTTPS", false);
    /**
     * APP_DEBUG must be true or false
     */
    define("APP_DEBUG", true);
    /**
     * APP_STATUS must be "development" or "production"
     * It is recommended to use "development" during development, and "production" when published
     */
    define("APP_STATUS", "development");

    /**
     * Database Information
     */
    /**
     * USE_MYSQL must be true or false
     * If true, the app will try to connect to the database directly.
     */
    define("USE_MYSQL", false);
    define("DB_HOST", "localhost");
    define("DB_USER", "root");
    define("DB_PASS", "");
    define("DB_NAME", "app_data");
    /**
     * If not using MySQL, you can use an API instead
     * You can also use both at the same time!
     */
    define("USE_API", false);
    define("API_BASE", "https://example.com/api");
    define("API_AUTH", "");

    /**
     * Discord API
     * Use Discord within your app! Currently limited to logging in through OAuth2 and fetching users
     */
    define("USE_DISCORD", false);
    define("OAUTH2_CLIENT_ID", "1234567890");
    define("OAUTH2_CLIENT_SECRET", "Th15_15_n0t_4_r3al_k3y");
    define("OAUTH2_REDIRECT_URI", "");
    define("OAUTH2_SCOPES", "identify guilds");
    /**
     * Additionally, you may use your bot to use the API differently
     */
    define("BOT_TOKEN", "");
    /**
     * After login or logout, redirect them here
     */
    define("USER_DIRECT_AFTER_LOGIN", "");
    define("USER_DIRECT_AFTER_LOGOUT", "");

    /** 
     * Plugins
     * Enable or disable the use of plugins easily
     */
    define("USE_AOS", false);
    define("USE_BOOTSTRAP", false);
    define("USE_FONTAWESOME", false);
    /**
     * In order to use jQuery UI and jQuery Mobile, you must enable jQuery as well
     */
    define("USE_JQUERY", false);
    define("USE_JQUERY_UI", false);
    define("USE_JQUERY_MOBILE", false);
    define("USE_QUNIT", false);
    /**
     * Should plugins use minified files, where available?
     */
    define("MINIFIED", true);

    /**
     * Custom CSS, JS or fonts
     */
    define("USE_CSS", false);
    define("USE_JS", false);
    define("USE_FONTS", false);
?>