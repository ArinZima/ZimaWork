<?php
    require './app/main/Base.php';

    class Part {
        public function __construct($partname) {
            switch ($partname) {
                case "head":
                    return self::Head();
                case "foot":
                    return self::Footer();
            }
        }

        private static function Head() {
            if(USE_AOS === true) {
                echo '<link rel="stylesheet" href="'.DOMAIN.'/theme/external/aos/css/aos.css">' . "\n";
            }

            if(USE_BOOTSTRAP === true) {
                if(MINIFIED === true) {
                    echo '<link rel="stylesheet" href="'.DOMAIN.'/theme/external/bootstrap/css/bootstrap.min.css">' . "\n";
                } else {
                    echo '<link rel="stylesheet" href="'.DOMAIN.'/theme/external/bootstrap/css/bootstrap.css">' . "\n";
                }
            }

            if(USE_FONTAWESOME === true) {
                if(MINIFIED === true) {
                    echo '<link rel="stylesheet" href="'.DOMAIN.'/theme/external/fontawesome/css/all.min.css">' . "\n";
                } else {
                    echo '<link rel="stylesheet" href="'.DOMAIN.'/theme/external/fontawesome/css/all.css">' . "\n";
                }
            }

            if(USE_JQUERY_UI === true) {
                if(USE_JQUERY === true) {
                    if(MINIFIED === true) {
                        echo '<link rel="stylesheet" href="'.DOMAIN.'/theme/external/jquery/ui/css/jquery-ui.min.css">' . "\n";
                    } else {
                        echo '<link rel="stylesheet" href="'.DOMAIN.'/theme/external/jquery/ui/css/jquery-ui.css">' . "\n";
                    }
                } else {
                    $base = new Base();
    
                    $message = 'Config: USE_JQUERY must be true to use jQuery UI';
                    $base::debug($message);
                    die($message);
                }
            }

            if(USE_JQUERY_MOBILE === true) {
                if(USE_JQUERY === true) {
                    if(MINIFIED === true) {
                        echo '<link rel="stylesheet" href="'.DOMAIN.'/theme/external/jquery/mobile/css/jquery.mobile-1.4.5.min.css">' . "\n";
                    } else {
                        echo '<link rel="stylesheet" href="'.DOMAIN.'/theme/external/jquery/mobile/css/jquery.mobile-1.4.5.css">' . "\n";
                    }
                } else {
                    $base = new Base();
    
                    $message = 'Config: USE_JQUERY must be true to use jQuery Mobile';
                    $base::debug($message);
                    die($message);
                }
            }

            if(USE_QUNIT === true) {
                echo '<link rel="stylesheet" href="'.DOMAIN.'/theme/external/qunit/css/qunit-2.19.1.css">' . "\n";
            }
        }

        private static function Footer() {
            if(USE_BOOTSTRAP === true) {
                if(MINIFIED === true) {
                    echo '<script src="'.DOMAIN.'/theme/external/bootstrap/js/bootstrap.min.js"></script>' . "\n";
                } else {
                    echo '<script src="'.DOMAIN.'/theme/external/bootstrap/js/bootstrap.js"></script>' . "\n";
                }
            }

            if(USE_FONTAWESOME === true) {
                if(MINIFIED === true) {
                    echo '<script src="'.DOMAIN.'/theme/external/fontawesome/css/all.min.js"></script>' . "\n";
                } else {
                    echo '<script src="'.DOMAIN.'/theme/external/fontawesome/js/all.js"></script>' . "\n";
                }
            }

            if(USE_JQUERY === true) {
                if(MINIFIED === true) {
                    echo '<script src="'.DOMAIN.'/theme/external/jquery/jquery-3.6.0.min.js"></script>' . "\n";
                } else {
                    echo '<script src="'.DOMAIN.'/theme/external/jquery/jquery-3.6.0.js"></script>' . "\n";
                }
            }

            if(USE_AOS === true) {
                echo '<script src="'.DOMAIN.'/theme/external/aos/js/aos.js"></script>' . "\n";
                echo '<script> AOS.init(); </script>' . "\n";
            }

            if(USE_JQUERY_UI === true) {
                if(USE_JQUERY === true) {
                    if(MINIFIED === true) {
                        echo '<script src="'.DOMAIN.'/theme/external/jquery/ui/js/jquery-ui.min.js"></script>' . "\n";
                    } else {
                        echo '<script src="'.DOMAIN.'/theme/external/jquery/ui/js/jquery-ui.js"></script>' . "\n";
                    }
                } else {
                    $base = new Base();
    
                    $message = 'Config: USE_JQUERY must be true to use jQuery UI';
                    $base::debug($message);
                    die($message);
                }
            }

            if(USE_JQUERY_MOBILE === true) {
                if(USE_JQUERY === true) {
                    if(MINIFIED === true) {
                        echo '<script src="'.DOMAIN.'/theme/external/jquery/mobile/js/jquery.mobile-1.4.5.min.js"></script>' . "\n";
                    } else {
                        echo '<script src="'.DOMAIN.'/theme/external/jquery/mobile/js/jquery.mobile-1.4.5.js"></script>' . "\n";
                    }
                } else {
                    $base = new Base();
    
                    $message = 'Config: USE_JQUERY must be true to use jQuery Mobile';
                    $base::debug($message);
                    die($message);
                }
            }

            if(USE_QUNIT === true) {
                echo '<script src="'.DOMAIN.'/theme/external/qunit/js/qunit-2.19.1.js"></script>' . "\n";
            }
        }
    }