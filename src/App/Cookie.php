<?php
    namespace Zima\App;

    /**
     * Class Cookie
     * 
     * @author Arin Zima <arin@arinzima.com>
     */
    class Cookie implements CookieInterface
    {
        /**
         * Fetch a cookie to read it's value
         */
        public function fetch(string $name)
        {
            if(!isset($_COOKIE[$name]))
            {
                return null;
            }
            else
            {
                return $_COOKIE[$name];
            }
        }

        /**
         * Set a new cookie
         */
        public function set(string $name, string $key, array $options)
        {
            $expires = $options['expires'];
            $path = isset($options['path']) ? $options['path'] : '/';
            $domain = isset($options['domain']) ? $options['domain'] : $_SERVER['SERVER_NAME'];
            $secure = isset($options['secure']) ? $options['secure'] : true;
            $httponly = isset($options['httponly']) ? $options['httponly'] : true;

            $set = setcookie($name, $key, $expires, $path, $domain, $secure, $httponly);

            return $set;
        }

        /**
         * Delete an existing cookie
         */
        public function delete(string $name, array $options = null)
        {
            $path = isset($options['path']) ? $options['path'] : '/';
            $domain = isset($options['domain']) ? $options['domain'] : $_SERVER['SERVER_NAME'];
            $secure = isset($options['secure']) ? $options['secure'] : true;
            $httponly = isset($options['httponly']) ? $options['httponly'] : true;

            if(isset($_COOKIE[$name]))
            {
                unset($_COOKIE[$name]);
                $set = setcookie($name, "", time() - 3600, $path, $domain, $secure, $httponly);
                return $set;
            } else {
                return false;
            }
        }
    }