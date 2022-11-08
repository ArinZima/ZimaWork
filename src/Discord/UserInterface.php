<?php
    namespace Zima\Discord;

    interface UserInterface
    {
        /**
         * @return array
         */
        public function fetch();

        /**
         * @param string    $user
         * @param ?array    $params
         * 
         * @return string
         */
        public function display_avatar_url(array $user, ?array $params = null);

        /**
         * @param string    $user
         * @param ?array    $params
         * 
         * @return string
         */
        public function display_banner_url(array $user, ?array $params = null);
    }