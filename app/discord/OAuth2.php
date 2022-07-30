<?php
    class OAuth2 extends Discord {
        public static function login_redirect() {
            $base = new Base();

            if(USE_DISCORD === true) {
                $state = Discord::gen_state();

                $params = array(
                    'client_id' => OAUTH2_CLIENT_ID,
                    'redirect_uri' => OAUTH2_REDIRECT_URI,
                    'response_type' => 'code',
                    'scope' => OAUTH2_SCOPES,
                    'state' => $state
                );

                $base::redirect(Discord::$auth . '?' . http_build_query($params));
                die();
            } else {
                $message = 'Config: USE_DISCORD set to false';
                $base::debug($message);
                die($message);
            }
        }

        public static function login() {
            $base = new Base();

            if(USE_DISCORD === true) {
                $state = Discord::get('state');
    
                if($state == Discord::session('state')) {
                    $token = Discord::request(Discord::$token, array(
                      "grant_type" => "authorization_code",
                      'client_id' => OAUTH2_CLIENT_ID,
                      'client_secret' => OAUTH2_CLIENT_SECRET,
                      'redirect_uri' => OAUTH2_REDIRECT_URI,
                      'code' => Discord::get('code')
                    ));
    
                    $logout_token = $token->access_token;
                    $_SESSION['access_token'] = $token->access_token;
    
                    $base::redirect(USER_DIRECT_AFTER_LOGIN);
                } else {
                    $base::redirect(USER_DIRECT_AFTER_LOGIN . "?error=invalid_login");
                }
            } else {
                $message = 'Config: USE_DISCORD set to false';
                $base::debug($message);
                die($message);
            }
        }

        private static function logout_request($url, $data=array()) {
            if(USE_DISCORD === true) {
                $ch = curl_init($url);
                curl_setopt_array($ch, array(
                    CURLOPT_POST => TRUE,
                    CURLOPT_RETURNTRANSFER => TRUE,
                    CURLOPT_IPRESOLVE => CURL_IPRESOLVE_V4,
                    CURLOPT_HTTPHEADER => array('Content-Type: application/x-www-form-urlencoded'),
                    CURLOPT_POSTFIELDS => http_build_query($data)
                ));
                $response = curl_exec($ch);
                return json_decode($response, true);
            } else {
                $message = 'Config: USE_DISCORD set to false';
                $base::debug($message);
                die($message);
            }
        }

        public static function logout() {
            if(USE_DISCORD === true) {
                $base = new Base();
    
                self::logout_request(Discord::$revoke, array(
                    'token' => Discord::session('access_token'),
                    'token_type_hint' => 'access_token',
                    'client_id' => OAUTH2_CLIENT_ID,
                    'client_secret' => OAUTH2_CLIENT_SECRET
                ));
    
                unset($_SESSION['access_token']);
                $base::redirect(USER_DIRECT_AFTER_LOGOUT);
                die();
            } else {
                $message = 'Config: USE_DISCORD set to false';
                $base::debug($message);
                die($message);
            }
        }
    }