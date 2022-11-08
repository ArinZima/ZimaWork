<?php
    namespace Zima\TTV;

    use Zima\TTV\Twitch;
    use Zima\App\Cookie;
    use Zima\App\Site;
    use Zima\App\Time;

    /**
     * Class OAuth2 (Twitch)
     * 
     * @author Arin Zima (arin@arinzima.com)
     * 
     * !! THIS CLASS HAS NOT BEEN TESTED YET. PROCEED WITH EXTREME CAUTION.
     */
    class OAuth2 extends Twitch implements OAuth2Interface
    {
        public function __construct()
        {
            if(TWITCH === false)
            {
                die(Twitch::NOT_ENABLED);
            }
        }

        public function request_login(string $state)
        {
            $site = new Site();

            $_SESSION['state'] = $state;

            $params = [
                'client_id' =>  TTV_CLIENT_ID,
                'response_type' => 'code',
                'redirect_uri' => TTV_REDIRECT_URI,
                'scope' => TTV_SCOPES,
                'state' => $state
            ];

            $site->redirect(Twitch::AUTH . '?' . http_build_query($params));
            die();
        }

        public function login()
        {
            $cookie = new Cookie();
            $site = new Site();

            $state_get = $site->get('state');
            $state = $_SESSION['state'];

            if($state == $state_get)
            {
                $twitch = new Twitch();
                $token = $twitch->request(Twitch::TOKEN, [
                    'grant_type' => 'authorization_code',
                    'client_id' => TTV_CLIENT_ID,
                    'client_secret' => TTV_CLIENT_SECRET,
                    'code' => $site->get('code'),
                    'redirect_uri' => TTV_REDIRECT_URI
                ]);

                $time = new Time();
                $current = $time->current();
                $week = $time->add_days($current, 7);

                $cookie->set('ttv_access_token', $token['access_token'], [
                    'expires' => $week
                ]);

                $cookie->set('ttv_refresh_token', $token['refresh_token'], [
                    'expires' => $week
                ]);

                $site->redirect(TTV_REDIRECT_LOGIN);
            }
            else
            {
                die("Error: State is invalid.");
            }
        }

        public function is_valid()
        {
            $cookie = new Cookie();
            $token = $cookie->fetch('ttv_access_token');

            if(!empty($token))
            {
                $twitch = new Twitch();
                $call = $twitch->request(Twitch::VALIDATE);

                if(empty($call['status']))
                {
                    return true;
                }
                else
                {
                    return false;
                }
            }
        }

        public function refresh()
        {
            $cookie = new Cookie();
            $token = $cookie->fetch('ttv_access_token');
            $refresh = $cookie->fetch('ttv_refresh_token');

            if(!empty($token) && !empty($refresh))
            {
                $twitch = new Twitch();
                $new_token = $twitch->request(Twitch::TOKEN, [
                    'client_id' => TTV_CLIENT_ID,
                    'client_secret' => TTV_CLIENT_SECRET,
                    'grant_type' => 'refresh_token',
                    'refresh_token' => $refresh
                ]);

                if(empty($new_token['error']))
                {
                    $time = new Time();
                    $current = $time->current();
                    $week = $time->add_days($current, 7);

                    $cookie->set('ttv_access_token', $new_token['access_token'], [
                        'expires' => $week
                    ]);

                    $cookie->set('ttv_refresh_token', $new_token['refresh_token'], [
                        'expires' => $week
                    ]);
                }
                else
                {
                    die($new_token['status'] . ' ' . $new_token['error'] . ': ' . $new_token['message']);
                }
            }
        }

        public function logout()
        {
            $cookie = new Cookie();
            $site = new Site();

            $call = self::request_logout();

            if(empty($call['status']))
            {
                $cookie->delete('ttv_access_token');
                $cookie->delete('ttv_refresh_token');
                $site->redirect(TTV_REDIRECT_LOGOUT);
            }
            else
            {
                die($call['message']);
            }
        }

        private static function request_logout()
        {
            $cookie = new Cookie();
            $token = $cookie->fetch('ttv_access_token');

            $params = [
                'client_id' => TTV_CLIENT_ID,
                'token' => $token
            ];

            $ch = curl_init(Twitch::REVOKE);
            curl_setopt_array($ch, [
                CURLOPT_POST => TRUE,
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_IPRESOLVE => CURL_IPRESOLVE_V4,
                CURLOPT_HTTPHEADER => ['Content-Type: application/x-www/form-urlencoded'],
                CURLOPT_POSTFIELDS => http_build_query($params)
            ]);

            $res = curl_exec($ch);

            return json_decode($res, true);
        }
    }