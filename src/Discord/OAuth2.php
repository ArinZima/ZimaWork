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
     * 
     * !! THIS CLASS HAS NOT BEEN TESTED YET. PROCEED WITH EXTREME CAUTION.
     */
    class OAuth2 extends Discord implements OAuth2Interface
    {
        PUBLIC FUNCTION __construct()
        {
            if(DISCORD === false)
            {
                die("ConfigError: \"DISCORD\" is set to false.");
            }
        }

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

                $site->redirect(DISCORD_REDIRECT_LOGIN);
            }
            else
            {
                die("Error: State is invalid.");
            }
        }

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