<?php
    class Discord {
        public static string $base = 'https://discord.com/api';
        public static string $user = 'https://discord.com/api/users/@me';
        public static string $guilds = 'https://discord.com/api/users/@me/guilds';
        public static string $auth = 'https://discord.com/api/oauth2/authorize';
        public static string $revoke = 'https://discord.com/api/oauth2/token/revoke';
        public static string $token = 'https://discord.com/api/oauth2/token';

        public static function Request($url, $post=FALSE, $headers=array()) {
            if(USE_DISCORD === true) {
                Debug::BackEnd("[Discord::Request] Initiating cURL configuration");
                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

                if($post)
                  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
              
                $headers[] = 'Accept: application/json';
              
                if(Base::Session('access_token'))
                  $headers[] = 'Authorization: Bearer ' . Base::Session('access_token');
              
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
                $headers[] = 'Authorization: Bot ' . BOT_TOKEN;
              
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
                $_SESSION['state'] = bin2hex(openssl_random_pseudo_bytes(12));
                Debug::BackEnd("[Discord::GenState] Returning state");
                return $_SESSION['state'];
            } else {
                $message = 'USE_DISCORD set to false';
                Debug::Error($message);
                die($message);
            }
        }
    }