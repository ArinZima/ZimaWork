<?php
    namespace Zima\Discord;

    use Zima\App\Cookie;

    /**
     * Class Discord
     * 
     * @author Arin Zima <arin@arinzima.com>
     * 
     * !! THIS CLASS HAS NOT BEEN TESTED YET. PROCEED WITH EXTREME CAUTION.
     */
    class Discord {
        public const NOT_ENABLED = "ConfigError: \"DISCORD\" is set to false."; 

        public const BASE = 'https://discord.com/api';
        public const USER = 'https://discord.com/api/users/@me';
        public const GUILDS = 'https://discord.com/api/users/@me/guilds';
        public const AUTH = 'https://discord.com/api/oauth2/authorize';
        public const REVOKE = 'https://discord.com/api/oauth2/token/revoke';
        public const TOKEN = 'https://discord.com/api/oauth2/token';

        /**
         * Submit an API request to Discord.
         *
         * @param string $url
         * @param array|null $post
         * @param array $headers
         * 
         * @return array
         */
        public function request(string $url, array $post = null, array $headers = []) 
        {
            if(DISCORD === true)
            {
                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

                if(!empty($post))
                    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));

                $headers[] = 'Accept: application/json';

                $cookie = new Cookie();
                $access = $cookie->fetch("discord_access_token");

                if(!empty($access))
                    $headers[] = 'Authorization: Bearer ' . $access;

                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

                $response = curl_exec($ch);
                return json_decode($response, true);
            }
            else
            {
                die(self::NOT_ENABLED);
            }
        }
    }