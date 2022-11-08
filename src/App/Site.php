<?php
    namespace Zima\App;

    /**
     * Class Site
     * 
     * @author Arin Zima <arin@arinzima.com>
     */
    class Site implements SiteInterface
    {
        /**
         * Fetch value from URL
         */
        public function get(string $key) {
            return array_key_exists($key, $_GET) ? $_GET[$key] : null;
        }

        /**
         * Redirect a visitor elsewhere
         */
        public function redirect(string $url)
        {
            if(!headers_sent())
            {
                header("Location: {$url}");
            }
            else
            {
                echo "<script>
                    window.location.href = \"{$url}\"
                </script>";
            }
        }

        /**
         * Parse the domain URL.
         */
        public function domain()
        {
            if($_SERVER['HTTPS'] === true)
            {
                return "https://{$_SERVER['SERVER_NAME']}";
            }
            else
            {
                return "http://{$_SERVER['SERVER_NAME']}";
            }
        }

        /**
         * Get the visitor's IP address
         */
        public function ip()
        {
            if(!empty($_SERVER['HTTP_CLIENT_IP']))
            {
                return $_SERVER['HTTP_CLIENT_IP'];
            }
            else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
            {
                return $_SERVER['HTTP_X_FORWARDED_FOR'];
            }
            else
            {
                return $_SERVER['REMOTE_ADDR'];
            }
        }

        /**
         * Generate a state
         * 
         * !! THIS FUNCTION USES OPENSSL. IF OPENSSL IS UNAVAILABLE, THIS FUNCTION WILL NOT WORK. 
         * 
         * TODO: Add handling for non-OpenSSL usage.
         */
        public function state(int $length = 12)
        {
            if(extension_loaded('openssl'))
            {
                return bin2hex(openssl_random_pseudo_bytes($length));
            }
        }

        /**
         * Sanitize input for data storing
         */
        public function sanitize(string $var)
        {
            $var = stripslashes($var);
            $var = strip_tags($var);
            $var = htmlentities($var);
            $var = htmlspecialchars($var);

            return $var;
        }
    }