<?php
    namespace Zima\Discord;

    interface OAuth2Interface
    {
        /**
         * @return null
         */
        public function request_login(string $state);

        /**
         * @param string    $state
         * 
         * @return null
         */
        public function login();

        /**
         * @return bool
         */
        public function is_valid();

        /**
         * @return bool
         */
        public function refresh();

        /**
         * @return null
         */
        public function logout();
    }