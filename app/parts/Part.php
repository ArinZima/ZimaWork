<?php
    class Part {
        public static function Head() {
            $domain = Base::ParseDomain();
            echo '<!-- Metadata -->
            <meta content="IE-edge" http-equiv="X-UA-Compatible">
            <meta content="width=device-width, initial-scale=1, viewport-fit=cover, shrink-to-fit=no" name="viewport">
            <meta content="text/html; charset=utf-8" http-equiv="Content-Type">
            <meta content="index, nofollow" name="robots">
            <meta content="1 days" name="revisit-after">
            <meta content="'.WEBSITE_NAME.'" name="author">
        
            <!-- OG Properties -->
            <meta content="'.$domain.'" property="og:url">
            <meta content="'.WEBSITE_NAME.'" property="og:site_name">
            <meta content="'.WEBSITE_NAME.'" property="og:title">
            <meta content="'.$domain.'/theme/img/logo.png" property="og:image">
            <meta content="'.DESCRIPTION.'" property="og:description">
        
            <!-- Twitter Properties -->
            <meta content="summary" name="twitter:card">
            <meta content="'.$domain.'" name="twitter:url">
            <meta content="'.WEBSITE_NAME.'" name="twitter:title">
            <meta content="'.$domain.'/theme/img/logo.png" name="twitter:image">
            <meta content="'.DESCRIPTION.'" name="description">
        
            <!-- Other Properties -->
            <meta content="'.WEBSITE_NAME.'" name="title">
            <meta content="'.THEME_COLOR.'" name="theme-color">
        
            <!-- Favicon -->
            <link rel="icon" href="'.$domain.'/theme/favicon/logo.ico">';

            if(USE_AOS === true) {
                echo '<link rel="stylesheet" href="'.$domain.'/theme/external/aos/css/aos.css">' . "\n";
            }

            if(USE_BOOTSTRAP === true) {
                if(MINIFIED === true) {
                    echo '<link rel="stylesheet" href="'.$domain.'/theme/external/bootstrap/css/bootstrap.min.css">' . "\n";
                } else {
                    echo '<link rel="stylesheet" href="'.$domain.'/theme/external/bootstrap/css/bootstrap.css">' . "\n";
                }
            }

            if(USE_FONTAWESOME === true) {
                if(MINIFIED === true) {
                    echo '<link rel="stylesheet" href="'.$domain.'/theme/external/fontawesome/css/all.min.css">' . "\n";
                } else {
                    echo '<link rel="stylesheet" href="'.$domain.'/theme/external/fontawesome/css/all.css">' . "\n";
                }
            }

            if(USE_JQUERY_UI === true) {
                if(USE_JQUERY === true) {
                    if(MINIFIED === true) {
                        echo '<link rel="stylesheet" href="'.$domain.'/theme/external/jquery/ui/css/jquery-ui.min.css">' . "\n";
                    } else {
                        echo '<link rel="stylesheet" href="'.$domain.'/theme/external/jquery/ui/css/jquery-ui.css">' . "\n";
                    }
                } else {
                    $message = 'USE_JQUERY must be true to use jQuery UI';
                    Debug::Error($message);
                    die($message);
                }
            }

            if(USE_JQUERY_MOBILE === true) {
                if(USE_JQUERY === true) {
                    if(MINIFIED === true) {
                        echo '<link rel="stylesheet" href="'.$domain.'/theme/external/jquery/mobile/css/jquery.mobile-1.4.5.min.css">' . "\n";
                    } else {
                        echo '<link rel="stylesheet" href="'.$domain.'/theme/external/jquery/mobile/css/jquery.mobile-1.4.5.css">' . "\n";
                    }
                } else {
                    $message = 'USE_JQUERY must be true to use jQuery Mobile';
                    Debug::Error($message);
                    die($message);
                }
            }

            if(USE_QUNIT === true) {
                echo '<link rel="stylesheet" href="'.$domain.'/theme/external/qunit/css/qunit-2.19.1.css">' . "\n";
            }
        }

        public static function Footer() {
            $domain = Base::ParseDomain();
            if(USE_BOOTSTRAP === true) {
                if(MINIFIED === true) {
                    echo '<script src="'.$domain.'/theme/external/bootstrap/js/bootstrap.min.js"></script>' . "\n";
                } else {
                    echo '<script src="'.$domain.'/theme/external/bootstrap/js/bootstrap.js"></script>' . "\n";
                }
            }

            if(USE_FONTAWESOME === true) {
                if(MINIFIED === true) {
                    echo '<script src="'.$domain.'/theme/external/fontawesome/css/all.min.js"></script>' . "\n";
                } else {
                    echo '<script src="'.$domain.'/theme/external/fontawesome/js/all.js"></script>' . "\n";
                }
            }

            if(USE_JQUERY === true) {
                if(MINIFIED === true) {
                    echo '<script src="'.$domain.'/theme/external/jquery/jquery-3.6.0.min.js"></script>' . "\n";
                } else {
                    echo '<script src="'.$domain.'/theme/external/jquery/jquery-3.6.0.js"></script>' . "\n";
                }
            }

            if(USE_AOS === true) {
                echo '<script src="'.$domain.'/theme/external/aos/js/aos.js"></script>' . "\n";
                echo '<script> AOS.init(); </script>' . "\n";
            }

            if(USE_JQUERY_UI === true) {
                if(USE_JQUERY === true) {
                    if(MINIFIED === true) {
                        echo '<script src="'.$domain.'/theme/external/jquery/ui/js/jquery-ui.min.js"></script>' . "\n";
                    } else {
                        echo '<script src="'.$domain.'/theme/external/jquery/ui/js/jquery-ui.js"></script>' . "\n";
                    }
                } else {
                    $message = 'USE_JQUERY must be true to use jQuery UI';
                    Debug::Error($message);
                    die($message);
                }
            }

            if(USE_JQUERY_MOBILE === true) {
                if(USE_JQUERY === true) {
                    if(MINIFIED === true) {
                        echo '<script src="'.$domain.'/theme/external/jquery/mobile/js/jquery.mobile-1.4.5.min.js"></script>' . "\n";
                    } else {
                        echo '<script src="'.$domain.'/theme/external/jquery/mobile/js/jquery.mobile-1.4.5.js"></script>' . "\n";
                    }
                } else {
                    $message = 'USE_JQUERY must be true to use jQuery Mobile';
                    Debug::Error($message);
                    die($message);
                }
            }

            if(USE_QUNIT === true) {
                echo '<script src="'.$domain.'/theme/external/qunit/js/qunit-2.19.1.js"></script>' . "\n";
            }
        }
    }