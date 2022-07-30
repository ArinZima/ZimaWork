<?php
    class Discord {
        public static string $base = 'https://discord.com/api';
        public static string $user = 'https://discord.com/api/users/@me';
        public static string $guilds = 'https://discord.com/api/users/@me/guilds';
        public static string $auth = 'https://discord.com/api/oauth2/authorize';
        public static string $revoke = 'https://discord.com/api/oauth2/token/revoke';
        public static string $token = 'https://discord.com/api/oauth2/token';

        public static function request($url, $post=FALSE, $headers=array()) {
            if(USE_DISCORD === true) {
                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
              
                $response = curl_exec($ch);
    
                if($post)
                  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
              
                $headers[] = 'Accept: application/json';
              
                if(self::session('access_token'))
                  $headers[] = 'Authorization: Bearer ' . self::session('access_token');
              
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
              
                $response = curl_exec($ch);
                return json_decode($response);
            } else {
                $message = 'Config: USE_DISCORD set to false';
                $base::debug($message);
                die($message);
            }
        }

        public static function gen_state() {
            if(USE_DISCORD === true) {
                $_SESSION['state'] = bin2hex(openssl_random_pseudo_bytes(12));
                return $_SESSION['state'];
            } else {
                $message = 'Config: USE_DISCORD set to false';
                $base::debug($message);
                die($message);
            }
        }

        public static function get($key, $default=NULL) {
            if(USE_DISCORD === true) {
                return array_key_exists($key, $_GET) ? $_GET[$key] : $default;
            } else {
                $message = 'Config: USE_DISCORD set to false';
                $base::debug($message);
                die($message);
            }
        }

        public static function session($key, $default=NULL) {
            if(USE_DISCORD === true) {
                return array_key_exists($key, $_SESSION) ? $_SESSION[$key] : $default;
            } else {
                $message = 'Config: USE_DISCORD set to false';
                $base::debug($message);
                die($message);
            }
        }
    }