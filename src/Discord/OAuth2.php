<?php
    namespace Zima\Discord;

    use Zima\Discord\Discord;
    use Zima\App\Site;
    use Zima\App\Cookie;
    use Zima\App\Time;

    /**
     * Class OAuth2
     * 
     * @author Arin Zima <arin@arinzima.com>
     */
    class OAuth2 extends Discord implements OAuth2Interface
    {
        /**
         * Check if config value is set to "true"
         */
        PUBLIC FUNCTION __construct()
        {
            if(DISCORD === false)
            {
                die("ConfigError: \"DISCORD\" is set to false.");
            }
        }

        /**
         * If not logged in, redirect to authorize
         */
        public function request_login(string $state)
        {
            $discord = new Discord();
            $site = new Site();

            $_SESSION['state'] = $state;

            $params = [
                'client_id' => DISCORD_CLIENT_ID,
                'redirect_uri' => DISCORD_REDIRECT_URI,
                'response_type' => 'code',
                'scope' => DISCORD_SCOPES,
                'state' => $state
            ];

            $site->redirect($discord::AUTH . '?' . http_build_query($params));
            die();
        }

        /**
         * Send a request to receive an access token
         */
        public function login()
        {
            $discord = new Discord();
            $site = new Site();
            $cookie = new Cookie();

            $state_get = $site->get("state");
            $state = $_SESSION['state'];

            if($state == $state_get)
            {
                $token = $discord->request($discord::TOKEN, [
                    'grant_type' => 'authorization_code',
                    'client_id' => DISCORD_CLIENT_ID,
                    'client_secret' => DISCORD_CLIENT_SECRET,
                    'redirect_uri' => DISCORD_REDIRECT_URI,
                    'code' => $site->get('code')
                ]);

                $time = new Time();

                $cookie->set('discord_access_token', $token['access_token'], [
                    'expires' => $time->add_days($time->current(), 7)
                ]);

                $cookie->set('discord_refresh_token', $token['refresh_token'], [
                    'expires' => $time->add_days($time->current(), 7)
                ]);

                $cookie->set('discord_expires', $time->add_seconds($time->current(), $token['expires_in']), [
                    'expires' => $time->add_days($time->current(), 7)
                ]);

                $site->redirect(DISCORD_REDIRECT_LOGIN);
            }
            else
            {
                die("Error: State is invalid.");
            }
        }

        /**
         * Check if saved access token is valid
         */
        public function is_valid()
        {
            $cookie = new Cookie();
            $time = new Time();

            $now = $time->current();
            $expires = $cookie->fetch('discord_expires');
            
            if($now < $expires) {
                return true;
            } else {
                return false;
            }
        }

        /**
         * If access token is invalid, refresh it
         */
        public function refresh()
        {
            $discord = new Discord();
            $cookie = new Cookie();
            $time = new Time();

            $refresh = $cookie->fetch('discord_refresh_token');

            $token = $discord->request(Discord::TOKEN, [
                'client_id' => DISCORD_CLIENT_ID,
                'client_secret' => DISCORD_CLIENT_SECRET,
                'grant_type' => 'refresh_token',
                'refresh_token' => $refresh
            ], [
                'Content-Type: application/x-www-form-urlencoded'
            ]);

            $cookie->set('discord_access_token', $token['access_token'], [
                'expires' => $time->add_days($time->current(), 7)
            ]);

            $cookie->set('discord_refresh_token', $token['refresh_token'], [
                'expires' => $time->add_days($time->current(), 7)
            ]);

            $cookie->set('discord_expires', $time->add_seconds($time->current(), $token['expires_in']), [
                'expires' => $time->add_days($time->current(), 7)
            ]);

            return true;
        }

        /**
         * Revoke a user's access token
         */
        public function logout()
        {
            $site = new Site();
            $cookie = new Cookie();

            self::request_logout([
                'token' => $cookie->fetch('discord_access_token'),
                'token_type_hint' => 'access_token',
                'client_id' => DISCORD_CLIENT_ID,
                'client_secret' => DISCORD_CLIENT_SECRET
            ]);

            $cookie->delete('discord_access_token', []);
            $site->redirect(DISCORD_REDIRECT_LOGOUT);
        }

        /**
         * API request to revoking an access token
         */
        private static function request_logout(array $data)
        {
            $discord = new Discord();

            $ch = curl_init($discord::REVOKE);
            curl_setopt_array($ch, [
                CURLOPT_POST => true,
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_IPRESOLVE => CURL_IPRESOLVE_V4,
                CURLOPT_HTTPHEADER => [ 'Content-Type: application/x-www-form-urlencoded' ],
                CURLOPT_POSTFIELDS => http_build_query($data)
            ]);

            $response = curl_exec($ch);

            return json_decode($response, true);
        }
    }