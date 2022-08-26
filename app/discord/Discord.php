<?php
    class Discord {
        public const BASE = 'https://discord.com/api';
        public const USER = 'https://discord.com/api/users/@me';
        public const GUILDS = 'https://discord.com/api/users/@me/guilds';
        public const AUTH = 'https://discord.com/api/oauth2/authorize';
        public const REVOKE = 'https://discord.com/api/oauth2/token/revoke';
        public const TOKEN = 'https://discord.com/api/oauth2/token';

        public static function Request($url, $post=FALSE, $headers=array()) {
            if(USE_DISCORD === true) {
                Debug::BackEnd("[Discord::Request] Initiating cURL configuration");
                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

                if($post)
                  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
              
                $headers[] = 'Accept: application/json';
              
                if(Base::Session('discord_access_token'))
                  $headers[] = 'Authorization: Bearer ' . Base::Session('discord_access_token');
              
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
              
                Debug::BackEnd("[Discord::Request] Executing cURL request");
                $response = curl_exec($ch);
                Debug::BackEnd("[Discord::Request] Returning Array");
                return json_decode($response);
            } else {
                $message = 'USE_DISCORD set to false';
                Debug::Error($message);
                die($message);
            }
        }

        public static function RequestBot($url, $post=FALSE, $headers=array()) {
            if(USE_DISCORD === true) {
                Debug::BackEnd("[Discord::RequestBot] Initiating cURL configuration");
                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

                if($post)
                  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
              
                $headers[] = 'Accept: application/json';
                $headers[] = 'Authorization: Bot ' . DISCORD_BOT_TOKEN;
              
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
              
                Debug::BackEnd("[Discord::RequestBot] Executing cURL request");
                $response = curl_exec($ch);
                Debug::BackEnd("[Discord::RequestBot] Returning Array");
                return json_decode($response);
            } else {
                $message = 'USE_DISCORD set to false';
                Debug::Error($message);
                die($message);
            }
        }

        public static function GenState() {
            if(USE_DISCORD === true) {
                Debug::BackEnd("[Discord::GenState] Generating state");
                $_SESSION['discord_state'] = bin2hex(openssl_random_pseudo_bytes(12));
                Debug::BackEnd("[Discord::GenState] Returning state");
                return $_SESSION['discord_state'];
            } else {
                $message = 'USE_DISCORD set to false';
                Debug::Error($message);
                die($message);
            }
        }
        
        /**
         * OAuth2
         */
        public static function RequestLogin() {
            if(USE_DISCORD === true) {
                Debug::BackEnd("[Discord::RequestLogin] Executing Discord::GenState");
                $state = Discord::GenState();

                Debug::BackEnd("[Discord::RequestLogin] Setting parameters");
                $params = array(
                    'client_id' => DISCORD_CLIENT_ID,
                    'redirect_uri' => DISCORD_REDIRECT_URI,
                    'response_type' => 'code',
                    'scope' => DISCORD_SCOPES,
                    'state' => $state
                );

                Debug::BackEnd("[Discord::RequestLogin] Redirecting");
                Base::Redirect(Discord::AUTH . '?' . http_build_query($params));
                die();
            } else {
                $message = 'USE_DISCORD set to false';
                Debug::Error($message);
                die($message);
            }
        }

        public static function Login() {
            if(USE_DISCORD === true) {
                Debug::BackEnd("[Discord::Login] Checking state");
                $state = Base::Get('state');
    
                if($state == Base::Session('discord_state')) {
                    Debug::BackEnd("[Discord::Login] State valid");
                    Debug::BackEnd("[Discord::Login] Requesting token");
                    $token = Discord::Request(Discord::TOKEN, array(
                      "grant_type" => "authorization_code",
                      'client_id' => DISCORD_CLIENT_ID,
                      'client_secret' => DISCORD_CLIENT_SECRET,
                      'redirect_uri' => DISCORD_REDIRECT_URI,
                      'code' => Base::Get('code')
                    ));
                    
                    Debug::BackEnd("[Discord::Login] Setting access token");
                    $logout_token = $token->access_token;
                    $_SESSION['discord_access_token'] = $token->access_token;

                    Debug::BackEnd("[Discord::Login] Setting refresh token");
                    $_SESSION['discord_refresh_token'] = $token->refresh_token;
    
                    Debug::BackEnd("[Discord::Login] Redirecting");
                    Base::Redirect(DISCORD_DIRECT_AFTER_LOGIN);
                } else {
                    Debug::BackEnd("[Discord::Login] Invalid state, redirecting");
                    Base::Redirect(DISCORD_DIRECT_AFTER_LOGIN . "?error=invalid_login");
                }
            } else {
                $message = 'USE_DISCORD set to false';
                Debug::Error($message);
                die($message);
            }
        }

        private static function LogoutRequest($url, $data=array()) {
            if(USE_DISCORD === true) {
                Debug::BackEnd("[Discord::LogoutRequest] Initializing cURL request");
                $ch = curl_init($url);
                curl_setopt_array($ch, array(
                    CURLOPT_POST => TRUE,
                    CURLOPT_RETURNTRANSFER => TRUE,
                    CURLOPT_IPRESOLVE => CURL_IPRESOLVE_V4,
                    CURLOPT_HTTPHEADER => array('Content-Type: application/x-www-form-urlencoded'),
                    CURLOPT_POSTFIELDS => http_build_query($data)
                ));
                
                Debug::BackEnd("[Discord::LogoutRequest] Executing cURL request");
                $response = curl_exec($ch);

                Debug::BackEnd("[Discord::LogoutRequest] Returning array");
                return json_decode($response, true);
            } else {
                $message = 'USE_DISCORD set to false';
                Debug::Error($message);
                die($message);
            }
        }

        public static function Logout() {
            if(USE_DISCORD === true) {
                Debug::BackEnd("[Discord::Logout] Executing LogoutRequest");
                Discord::LogoutRequest(Discord::REVOKE, array(
                    'token' => Base::Session('discord_access_token'),
                    'token_type_hint' => 'access_token',
                    'client_id' => DISCORD_CLIENT_ID,
                    'client_secret' => DISCORD_CLIENT_SECRET
                ));
    
                Debug::BackEnd("[Discord::Logout] Deleting SESSION keys");
                unset($_SESSION['discord_access_token']);
                unset($_SESSION['discord_refresh_token']);
                Debug::BackEnd("[Discord::Logout] Redirecting");
                Base::redirect(DISCORD_DIRECT_AFTER_LOGOUT);
                die();
            } else {
                $message = 'USE_DISCORD set to false';
                Debug::Error($message);
                die($message);
            }
        }

        public static function Refresh() {
            if(USE_DISCORD === true) {
                Debug::BackEnd("[Discord::Refresh] Executing Discord::Request");
                $token = Discord::Request(Discord::TOKEN, array(
                  "grant_type" => "refresh_token",
                  'client_id' => DISCORD_CLIENT_ID,
                  'client_secret' => DISCORD_CLIENT_SECRET,
                  'refresh_token' => Base::Session('discord_refresh_token')
                ));

                Debug::BackEnd("[Discord::Login] Setting access token");
                $logout_token = $token->access_token;
                $_SESSION['discord_access_token'] = $token->access_token;

                Debug::BackEnd("[Discord::Login] Setting refresh token");
                $_SESSION['discord_refresh_token'] = $token->refresh_token;
            } else {
                $message = 'USE_DISCORD set to false';
                Debug::Error($message);
                die($message);
            }
        }
    }