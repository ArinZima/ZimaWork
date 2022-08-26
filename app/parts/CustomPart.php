<?php
    class CustomPart {
        public static function Style($filename) {
            $domain = Base::ParseDomain();
            if(USE_CSS === true) {
                echo '<link rel="stylesheet" href="'.$domain.'/theme/css/'.$filename.'.css">' . "\n";
            } else {
                $message = 'USE_CSS must be true to use custom CSS';
                Debug::Error($message);
                die($message);
            }
        }

        public static function Font($filename) {
            $domain = Base::ParseDomain();
            if(USE_FONTS === true) {
                echo '<link rel="stylesheet" href="'.$domain.'/theme/fonts/'.$filename.'">' . "\n";
            } else {
                $message = 'USE_FONTS must be true to use custom fonts';
                Debug::Error($message);
                die($message);
            }
        }

        public static function Script($filename) {
            $domain = Base::ParseDomain();
            if(USE_JS === true) {
                echo '<script src="'.$domain.'/theme/js/'.$filename.'.js"></script>' . "\n";
            } else {
                $message = 'USE_JS must be true to use custom scripts';
                Debug::Error($message);
                die($message);
            }
        }
    }