<?php
    class Twitch {
        public const BASE = 'https://id.twitch.tv';
        public const AUTH = Twitch::BASE . '/oauth2/authorize';
        public const TOKEN = Twitch::BASE . '/oauth2/token';
        public const VALIDATE = Twitch::BASE . '/oauth2/validate';
        public const REVOKE = Twitch::BASE . '/oauth2/revoke';

        public const BASE2 = 'https://api.twitch.tv';
        public const USER = Twitch::BASE2 . '/helix/users';

        public const UT_FALSE = 'USE_TWITCH set to false';

        public static function Request($url, $post=null, $headers=array()) {
            if(USE_TWITCH === true) {
                Debug::BackEnd("[Twitch::Request] Initiating cURL configuration");
                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                if(!empty($post))
                    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));

                $headers[] = 'Accept: application/json';

                if(Base::Session("ttv_access_token"))
                    $headers[] = 'Authorization: Bearer ' . Base::Session('ttv_access_token');

                if($url == Twitch::USER)
                    $headers[] = 'Client-Id: ' . TTV_CLIENT_ID;

                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

                Debug::BackEnd("[Twitch::Request] Executing cURL request");
                $response = curl_exec($ch);
                Debug::BackEnd("[Twitch::Request] Returning array");
                return json_decode($response);
            } else {
                Debug::Error(Twitch::UT_FALSE);
                die(Twitch::UT_FALSE);
            }
        }

        public static function GenState() {
            if(USE_TWITCH === true) {
                Debug::BackEnd("[Twitch::GenState] Generating state");
                $_SESSION['ttv_state'] = bin2hex(openssl_random_pseudo_bytes(12));
                Debug::BackEnd("[Twitch::GenState] Returning state");
                return $_SESSION['ttv_state'];
            } else {
                Debug::Error(Twitch::UT_FALSE);
                die(Twitch::UT_FALSE);
            }
        }

        /**
         * OAuth2
         */
        public static function RequestLogin() {
            if(USE_TWITCH === true) {
                Debug::BackEnd("[Twitch::RequestLogin] Executing Twitch::GenState");
                $state = Twitch::GenState();

                Debug::BackEnd("[Twitch::RequestLogin] Setting parameters");
                $params = array(
                    'response_type' => 'code',
                    'client_id' => TTV_CLIENT_ID,
                    'redirect_uri' => TTV_REDIRECT_URI,
                    'scope' => TTV_SCOPES,
                    'state' => $state
                );

                Debug::BackEnd("[Twitch::RequestLogin] Executing Base::Redirect");
                Base::Redirect(Twitch::AUTH . '?' . http_build_query($params));
                die();
            } else {
                Debug::Error(Twitch::UT_FALSE);
                die(Twitch::UT_FALSE);
            }
        }

        public static function Login() {
            if(USE_TWITCH === true) {
                Debug::BackEnd("[Twitch::Login] Checking state");
                $state = Base::Get('state');

                if($state == Base::Session('ttv_state')) {
                    Debug::BackEnd("[Twitch::Login] State valid, checking for errors");
                    if(Base::Get('error')) {
                        $error = Base::Get('error_description');
                        $error = preg_replace('/(.*), (.*)/', '$0 --> $2 $1', $error);

                        Debug::BackEnd("[Twitch::Login] Twitch returned error");
                        Debug::Error($error);
                    } else {
                        Debug::BackEnd("[Twitch::Login] Requesting token");
                        $token = Twitch::Request(Twitch::TOKEN, array(
                            'client_id' => TTV_CLIENT_ID,
                            'client_secret' => TTV_CLIENT_SECRET,
                            'code' => Base::Get('code'),
                            'grant_type' => 'authorization_code',
                            'redirect_uri' => TTV_REDIRECT_URI
                        ));

                        var_dump($token);

                        Debug::BackEnd("[Twitch::Login] Setting access token");
                        $_SESSION['ttv_access_token'] = $token->access_token;

                        Debug::BackEnd("[Twitch::Login] Setting refresh token");
                        $_SESSION['ttv_refresh_token'] = $token->refresh_token;

                        Debug::BackEnd("[Twitch::Login] Executing Base::Redirect");
                        Base::Redirect(TTV_DIRECT_AFTER_LOGIN);
                    }
                } else {
                    Debug::BackEnd("[Twitch::Login] Invalid state, redirecting");
                    Base::Redirect(TTV_DIRECT_AFTER_LOGIN . "?error=invalid_login");
                }
            } else {
                Debug::Error(Twitch::UT_FALSE);
                die(Twitch::UT_FALSE);
            }
        }

        public static function IsValid() {
            if(USE_TWITCH === true) {
                Debug::BackEnd("[Twitch::IsValid] Getting access token");
                $token = Base::Session('ttv_access_token');
                
                if(!empty($token)) {
                    Debug::BackEnd("[Twitch::IsValid] Access token exists, validating");
                    $call = Twitch::Request(Twitch::VALIDATE);
                    if(empty($call->status)) {
                        Debug::BackEnd("[Twitch::IsValid] Access token valid");
                        $_SESSION['ttv_user'] = $call->login;
                        return true;
                    } else {
                        Debug::BackEnd("[Twitch::IsValid] Access token invalid, need refresh");
                        return false;
                    }
                }
            } else {
                Debug::Error(Twitch::UT_FALSE);
                die(Twitch::UT_FALSE);
            }
        }

        public static function Refresh() {
            if(USE_TWITCH === true) {
                Debug::BackEnd("[Twitch::Refresh] Getting access and refresh tokens");
                $token = Base::Session('ttv_access_token');
                $refresh = Base::Session('ttv_refresh_token');

                if(!empty($token) && !empty($refresh)) {
                    Debug::BackEnd("[Twitch::Refresh] Requesting refresh");
                    $new_token = Twitch::Request(Twitch::TOKEN, array(
                        'client_id' => TTV_CLIENT_ID,
                        'client_secret' => TTV_CLIENT_SECRET,
                        'grant_type' => 'refresh_token',
                        'refresh_token' => $refresh
                    ));

                    if(empty($new_token->error)) {
                        Debug::BackEnd("[Twitch::Refresh] Setting access token");
                        $_SESSION['ttv_access_token'] = $token->access_token;

                        Debug::BackEnd("[Twitch::Refresh] Setting refresh token");
                        $_SESSION['ttv_refresh_token'] = $token->refresh_token;
                    } else {
                        Debug::Error($new_token->message);
                        die($new_token->status . ' ' . $new_token->error . ': ' . $new_token->message);
                    }
                }
            } else {
                Debug::Error(Twitch::UT_FALSE);
                die(Twitch::UT_FALSE);
            }
        }

        private static function LogoutRequest($url, $data=array()) {
            if(USE_TWITCH === true) {
                Debug::BackEnd("[Twitch::LogoutRequest] Initializing cURL request");
                $ch = curl_init($url);
                curl_setopt_array($ch, array(
                    CURLOPT_POST => TRUE,
                    CURLOPT_RETURNTRANSFER => TRUE,
                    CURLOPT_IPRESOLVE => CURL_IPRESOLVE_V4,
                    CURLOPT_HTTPHEADER => array('Content-Type: application/x-www-form-urlencoded'),
                    CURLOPT_POSTFIELDS => http_build_query($data)
                ));

                Debug::BackEnd("[Twitch::LogoutRequest] Executing cURL request");
                $res = curl_exec($ch);

                Debug::BackEnd("[Twitch::LogoutRequest] Returning array");
                return json_decode($res, true);
            } else {
                Debug::Error(Twitch::UT_FALSE);
                die(Twitch::UT_FALSE);
            }
        }

        public static function Logout() {
            if(USE_TWITCH === true) {
                Debug::BackEnd("[Twitch::Logout] Executing Twitch::LogoutRequest");
                $call = Twitch::LogoutRequest(Twitch::REVOKE, array(
                    'client_id' => TTV_CLIENT_ID,
                    'token' => Base::Session('ttv_access_token')
                ));

                if(empty($call->status)) {
                    Debug::BackEnd("[Twitch::Logout] Deleting SESSION keys");
                    unset($_SESSION['ttv_access_token']);
                    unset($_SESSION['ttv_refresh_token']);
                    unset($_SESSION['ttv_user']);
                    
                    Debug::BackEnd("[Twitch::Logout] Executing Base::Redirect");
                    Base::Redirect(TTV_DIRECT_AFTER_LOGOUT);
                } else {
                    Debug::BackEnd($call->message);
                    die($call->message);
                }
            } else {
                Debug::Error(Twitch::UT_FALSE);
                die(Twitch::UT_FALSE);
            }
        }

        /**
         * User
         */
        public static function FetchUser() {
            if(USE_TWITCH === true) {
                Debug::BackEnd("[Twitch::Request] Initiating cURL configuration");
                $ch = curl_init(Twitch::USER);
                curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                if(!empty($post))
                    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));

                $headers[] = 'Accept: application/json';

                if(Base::Session("ttv_access_token")) {
                    $headers[] = 'Authorization: Bearer ' . Base::Session('ttv_access_token');
                    $headers[] = 'Client-Id: ' . TTV_CLIENT_ID;
                }

                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

                Debug::BackEnd("[Twitch::Request] Executing cURL request");
                $response = curl_exec($ch);
                Debug::BackEnd("[Twitch::Request] Returning array");
                $call = json_decode($response, true);

                return $call;
            } else {
                Debug::Error(Twitch::UT_FALSE);
                die(Twitch::UT_FALSE);
            }
        }
    }