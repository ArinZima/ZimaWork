<?php
    namespace Zima\Data;

    interface APIInterface
    {
        /**
         * @param string    $url
         * 
         * @return array
         */
        public function get(string $url);

        /**
         * @param string    $url
         * @param ?array    $data
         * 
         * @return array
         */
        public function post(string $url, $data = false);

        /**
         * @param string    $url
         * @param ?array    $data
         * 
         * @return array
         */
        public function patch(string $url, $data = false);

        /**
         * @param string    $url
         * 
         * @return array
         */
        public function delete(string $url);
    }