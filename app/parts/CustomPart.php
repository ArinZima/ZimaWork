<?php
    class CustomPart {
        public function __construct($partname, $filename) {
            $this->css = DOMAIN . "/theme/css";
            $this->fonts = DOMAIN . "/theme/fonts";
            $this->js = DOMAIN . "/theme/js";

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
            if(USE_CSS === true) {
                echo '<link rel="stylesheet" href="'.$this->css.'/'.$filename.'.css">' . "\n";
            } else {
                $base = new Base();
    
                $message = 'Config: USE_CSS must be true to use custom CSS';
                $base::debug($message);
                die($message);
            }
        }

        private static function Font($filename) {
            if(USE_FONTS === true) {
                echo '<link rel="stylesheet" href="'.$this->fonts.'/'.$filename.'">' . "\n";
            } else {
                $base = new Base();
    
                $message = 'Config: USE_FONTS must be true to use custom fonts';
                $base::debug($message);
                die($message);
            }
        }

        private static function Script($filename) {
            if(USE_JS === true) {
                echo '<script src="'.$this->fonts.'/'.$filename.'.js"></script>' . "\n";
            } else {
                $base = new Base();
    
                $message = 'Config: USE_JS must be true to use custom scripts';
                $base::debug($message);
                die($message);
            }
        }
    }