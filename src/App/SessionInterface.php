<?php
    namespace Zima\App;

    interface SessionInterface
    {
        /**
         * @return void|false
         */
        public function init();

        /**
         * @return bool
         */
        public function started();
        
        /**
         * @param bool|false $force
         * 
         * @return void
         */
        public function end(bool $force = false);

        /**
         * @param string $key
         * 
         * @return string|null
         */
        public function fetch(string $key);

        /**
         * @param string $key
         * @param mixed $value
         * 
         * @return bool
         */
        public function set(string $key, mixed $value);

        /**
         * @param string $key
         * 
         * @return bool
         */
        public function delete(string $key);
    }