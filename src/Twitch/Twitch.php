<?php
    namespace Zima\TTV;

    use Zima\App\Cookie;

    /**
     * Class Twitch
     * 
     * @author Arin Zima <arin@arinzima.com>
     * 
     * !! THIS CLASS HAS NOT BEEN TESTED YET. PROCEED WITH EXTREME CAUTION.
     */
    class Twitch
    {
        public const BASE = 'https://id.twitch.tv';
        public const AUTH = Twitch::BASE . '/oauth2/authorize';
        public const TOKEN = Twitch::BASE . '/oauth2/token';
        public const VALIDATE = Twitch::BASE . '/oauth2/validate';
        public const REVOKE = Twitch::BASE . '/oauth2/revoke';

        public const BASE2 = 'https://api.twitch.tv';
        public const USER = Twitch::BASE2 . '/helix/users';

        public const NOT_ENABLED = "ConfigError: \"TWITCH\" is set to false.";

        public function request($url, $post=null, $headers=[])
        {
            $cookie = new Cookie();

            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            if(!empty($post))
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));

            $headers[] = 'Accept: application/json';

            if($cookie->fetch("ttv_access_token")) {
                $headers[] = 'Authorization: Bearer ' . $cookie->fetch('ttv_access_token');
                $headers[] = 'Client-Id: ' . TTV_CLIENT_ID;
            }

            if($url == self::USER)
                $headers[] = 'Client-Id: ' . TTV_CLIENT_ID;

            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            $response = curl_exec($ch);
            return json_decode($response, true);
        }
    }