<?php
    class CustomPart {
        public function __construct($partname, $filename) {
            switch ($partname) {
                case "Style":
                    return self::Style($filename);
                case "Font":
                    return self::Font($filename);
                case "Script":
                    return self::Script($filename);
            }
        }

        private static function Style($filename) {
            $domain = Base::ParseDomain();
            if(USE_CSS === true) {
                echo '<link rel="stylesheet" href="'.$domain.'/theme/css/'.$filename.'.css">' . "\n";
            } else {
                $message = 'USE_CSS must be true to use custom CSS';
                Debug::Error($message);
                die($message);
            }
        }

        private static function Font($filename) {
            $domain = Base::ParseDomain();
            if(USE_FONTS === true) {
                echo '<link rel="stylesheet" href="'.$domain.'/theme/fonts/'.$filename.'">' . "\n";
            } else {
                $message = 'USE_FONTS must be true to use custom fonts';
                Debug::Error($message);
                die($message);
            }
        }

        private static function Script($filename) {
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