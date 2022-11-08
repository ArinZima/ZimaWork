<?php
    namespace Zima\App;

    interface SiteInterface
    {
        /**
         * @param string    $url
         */
        public function redirect(string $url);

        /**
         * @return string
         */
        public function domain();

        /**
         * @return string
         */
        public function ip();

        /**
         * @param integer $length
         * 
         * @return string
         */
        public function state(int $length = 12);

        /**
         * @param string $var
         * 
         * @return string
         */
        public function sanitize(string $var);
    }