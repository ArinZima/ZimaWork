<?php
    class Base {
        public static function Get($key, $default=NULL) {
            if(USE_DISCORD === true) {
                Debug::BackEnd("[Base::Get] Checking if array key exists");
                return array_key_exists($key, $_GET) ? $_GET[$key] : $default;
            } else {
                $message = 'USE_DISCORD set to false';
                Debug::Error($message);
                die($message);
            }
        }

        public static function Session($key, $default=NULL) {
            if(USE_DISCORD === true) {
                Debug::BackEnd("[Base::Session] Checking if array key exists");
                return array_key_exists($key, $_SESSION) ? $_SESSION[$key] : $default;
            } else {
                $message = 'USE_DISCORD set to false';
                Debug::Error($message);
                die($message);
            }
        }

        public static function Redirect($url) {
            if(!headers_sent()) {
                Debug::BackEnd("[Base::Redirect] Headers are not yet sent, sending Location");
                header("Location: {$url}");
            } else {
                Debug::BackEnd("[Base::Redirect] Headers are sent, using JavaScript");
                echo "<script>
                    window.location.href = \"{$url}\";
                </script>";
            }
        }

        public static function HTTPS() {
            if(HTTPS === true) {
                Debug::BackEnd("[Base::HTTPS] HTTPS option is true");
                if($_SERVER['HTTPS'] != 'on') {
                    Debug::BackEnd("[Base::HTTPS] Server HTTPS is not on, redirecting");
                    self::redirect('https://' . DOMAIN . $_SERVER['REQUEST_URI']);
                    exit();
                }
            } else {
                Debug::BackEnd("[Base::HTTPS] HTTPS option is false, exiting");
            }
        }

        public static function ParseDomain() {
            if(HTTPS === true) {
                return "https://" . DOMAIN;
            } else {
                return "http://" . DOMAIN;
            }
        }

        public static function GetUserIP() {
            if(!empty($_SERVER['HTTP_CLIENT_IP'])) {
                Debug::BackEnd("[Base::GetUserIP] Returning client IP");
                return $_SERVER['HTTP_CLIENT_IP'];
            } else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                Debug::BackEnd("[Base::GetUserIP] Returning x forwarded for");
                return $_SERVER['HTTP_X_FORWARDED_FOR'];
            } else {
                Debug::BackEnd("[Base::GetUserIP] Returning remote address");
                return $_SERVER['REMOTE_ADDR'];
            }
        }

        public static function GenString(int $length = 32) {
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $character_length = strlen($characters); $val = '';

            Debug::BackEnd("[Base::GenString] Initiating for loop");
            for($ii = 0; $ii < $length; $ii++) {
                $val .= $characters[rand(0, $character_length - 1)];
            }

            Debug::BackEnd("[Base::GenString] Returning result");
            return $val;
        }

        public static function SanitizeString(string $var) {
            Debug::BackEnd("[Base::SanitizeString] Stripping slashes");
            $var = stripslashes($var);
            Debug::BackEnd("[Base::SanitizeString] Stripping tags");
            $var = strip_tags($var);
            Debug::BackEnd("[Base::SanitizeString] Converting to HTML character entity equivalents");
            $var = htmlentities($var);
            Debug::BackEnd("[Base::SanitizeString] Converting to HTML character entity equivalents (x2)");
            $var = htmlspecialchars($var);

            return $var;
        }
    }