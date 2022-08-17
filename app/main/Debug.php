<?php
    class Debug {
        public static function LogToFile($type, $message = false) {
            if(APP_DEBUG === false || APP_STATUS === 'production' || !$message) {
                return;
            } else {
                $date = date("Y-m-d");
                $log_path = "./logs/{$type}.log-{$date}.txt";

                $logline = "[" . date("H:i:s") . "] " . $message . "\n";
                file_put_contents($log_path, $logline, FILE_APPEND);
            }
        }

        public static function Access() {
            if(APP_DEBUG === false || APP_STATUS === 'production') {
                return;
            } else {
                $date = date("Y-m-d");
                $log_path = "./logs/access.log-{$date}.txt";

                ini_set('auto_prepend_file', $log_path);

                $logline = "[" . date("H:i:s") . "] " . implode(PHP_EOL . PHP_EOL, array(
                    'SERVER: ' . PHP_EOL . print_r($_SERVER, true),
                    'REQUEST: ' . PHP_EOL . print_r($_REQUEST, true)
                )) . "\n";
                file_put_contents($log_path, $logline, FILE_APPEND);
            }
        }

        public static function Error($message = false) {
            return self::LogToFile("error", $message);
        }

        public static function BackEnd($message = false) {
            return self::LogToFile('backend', $message);
        }
    }