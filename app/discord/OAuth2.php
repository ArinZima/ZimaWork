<?php
    class OAuth2 extends Discord {
        public static function RequestLogin() {
            if(USE_DISCORD === true) {
                Debug::BackEnd("[OAuth2::RequestLogin] Executing Discord::GenState");
                $state = Discord::GenState();

                Debug::BackEnd("[OAuth2::RequestLogin] Setting parameters");
                $params = array(
                    'client_id' => OAUTH2_CLIENT_ID,
                    'redirect_uri' => OAUTH2_REDIRECT_URI,
                    'response_type' => 'code',
                    'scope' => OAUTH2_SCOPES,
                    'state' => $state
                );

                Debug::BackEnd("[OAuth2::RequestLogin] Redirecting");
                Base::Redirect(Discord::$auth . '?' . http_build_query($params));
                die();
            } else {
                $message = 'USE_DISCORD set to false';
                Debug::Error($message);
                die($message);
            }
        }

        public static function Login() {
            if(USE_DISCORD === true) {
                Debug::BackEnd("[OAuth2::Login] Checking state");
                $state = Base::Get('state');
    
                if($state == Base::Session('state')) {
                    Debug::BackEnd("[OAuth2::Login] State valid");
                    Debug::BackEnd("[OAuth2::Login] Requesting token");
                    $token = Discord::Request(Discord::$token, array(
                      "grant_type" => "authorization_code",
                      'client_id' => OAUTH2_CLIENT_ID,
                      'client_secret' => OAUTH2_CLIENT_SECRET,
                      'redirect_uri' => OAUTH2_REDIRECT_URI,
                      'code' => Base::Get('code')
                    ));
    
                    
                    Debug::BackEnd("[OAuth2::Login] Setting token");
                    $logout_token = $token->access_token;
                    $_SESSION['access_token'] = $token->access_token;
    
                    Debug::BackEnd("[OAuth2::Login] Redirecting");
                    Base::Redirect(USER_DIRECT_AFTER_LOGIN);
                } else {
                    Debug::BackEnd("[OAuth2::Login] Invalid state, redirecting");
                    Base::Redirect(USER_DIRECT_AFTER_LOGIN . "?error=invalid_login");
                }
            } else {
                $message = 'USE_DISCORD set to false';
                Debug::Error($message);
                die($message);
            }
        }

        private static function LogoutRequest($url, $data=array()) {
            if(USE_DISCORD === true) {
                Debug::BackEnd("[OAuth2::LogoutRequest] Initializing cURL request");
                $ch = curl_init($url);
                curl_setopt_array($ch, array(
                    CURLOPT_POST => TRUE,
                    CURLOPT_RETURNTRANSFER => TRUE,
                    CURLOPT_IPRESOLVE => CURL_IPRESOLVE_V4,
                    CURLOPT_HTTPHEADER => array('Content-Type: application/x-www-form-urlencoded'),
                    CURLOPT_POSTFIELDS => http_build_query($data)
                ));
                
                Debug::BackEnd("[OAuth2::LogoutRequest] Executing cURL request");
                $response = curl_exec($ch);

                Debug::BackEnd("[OAuth2::LogoutRequest] Returning array");
                return json_decode($response, true);
            } else {
                $message = 'USE_DISCORD set to false';
                Debug::Error($message);
                die($message);
            }
        }

        public static function Logout() {
            if(USE_DISCORD === true) {
                Debug::BackEnd("[OAuth2::Logout] Executing LogoutRequest");
                self::LogoutRequest(Discord::$revoke, array(
                    'token' => Base::Session('access_token'),
                    'token_type_hint' => 'access_token',
                    'client_id' => OAUTH2_CLIENT_ID,
                    'client_secret' => OAUTH2_CLIENT_SECRET
                ));
    
                Debug::BackEnd("[OAuth2::Logout] Deleting SESSION key");
                unset($_SESSION['access_token']);
                Debug::BackEnd("[OAuth2::Logout] Redirecting");
                Base::redirect(USER_DIRECT_AFTER_LOGOUT);
                die();
            } else {
                $message = 'USE_DISCORD set to false';
                Debug::Error($message);
                die($message);
            }
        }
    }