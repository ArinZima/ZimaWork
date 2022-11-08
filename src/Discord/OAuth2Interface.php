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
         * @return null
         */
        public function logout();
    }