<?php
    class Base {
        public static function debug($message = false) {
            if(APP_DEBUG === false || APP_STATUS === 'production' || !$message) {
                return;
            } else {
                $date = date("Y-m-d");
                $log_path = "./logs/log-{$date}.txt";

                $logline = "[" . date("H:i:s") . "] " . $message . "\n";
                file_put_contents($log_path, $logline, FILE_APPEND);
            }
        }

        public static function redirect($url) {
            if(!headers_sent()) {
                header("Location: {$url}");
            } else {
                echo "<script>
                    window.location.href = \"{$url}\";
                </script>";
            }
        }

        public static function https() {
            if(HTTPS === true) {
                if($_SERVER['HTTPS'] != 'on') {
                    self::redirect('https://' . DOMAIN . $_SERVER['REQUEST_URI']);
                    exit();
                }
            }
        }
    }