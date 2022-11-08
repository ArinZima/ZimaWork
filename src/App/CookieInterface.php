<?php
    namespace Zima\App;

    interface CookieInterface
    {
        /**
         * @param string        $key
         * 
         * @return string|null
         */
        public function fetch(string $name);

        /**
         * @param string        $name
         * @param string        $value
         * @param array         $options
         * 
         * @return bool
         */
        public function set(string $name, string $value, array $options);

        /**
         * @param string        $name
         * 
         * @return bool
         */
        public function delete(string $name, array $options);
    }