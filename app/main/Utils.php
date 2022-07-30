<?php
    class Utils {
        public static function get_user_ip() {
            if(!empty($_SERVER['HTTP_CLIENT_IP'])) {
                return $_SERVER['HTTP_CLIENT_IP'];
            } else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                return $_SERVER['HTTP_X_FORWARDED_FOR'];
            } else {
                return $_SERVER['REMOTE_ADDR'];
            }
        }

        public static function gen_string(int $length = 32) {
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $character_length = strlen($characters); $val = '';

            for($ii = 0; $ii < $length; $ii++) {
                $val .= $characters[rand(0, $character_length - 1)];
            }

            return $val;
        }

        public static function sanitize_string(string $var) {
            $var = stripslashes($var);
            $var = strip_tags($var);
            $var = htmlentities($var);
            $var = htmlspecialchars($var);

            return $var;
        }
    }
?>