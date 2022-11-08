<?php
    namespace Zima\App;

    interface TimeInterface
    {
        /**
         * @return int
         */
        public function current();

        /**
         * @param string        $format
         * @param int           $timestamp
         * 
         * @return string
         */
        public function format(string $format, ?int $timestamp = null);

        /**
         * @param int           $timestamp
         * @param int           $seconds
         * 
         * @return int        
         */
        public function add_seconds(int $timestamp, int $seconds);

        /**
         * @param int           $timestamp
         * @param int           $seconds
         * 
         * @return int
         */
        public function remove_seconds(int $timestamp, int $seconds);

        /**
         * @param int           $timestamp
         * @param int           $minutes
         * 
         * @return int
         */
        public function add_minutes(int $timestamp, int $minutes);

        /**
         * @param int           $timestamp
         * @param int           $minutes
         * 
         * @return int
         */
        public function remove_minutes(int $timestamp, int $minutes);

        /**
         * @param int           $timestamp
         * @param int           $hours
         * 
         * @return int
         */
        public function add_hours(int $timestamp, int $minutes);

        /**
         * @param int           $timestamp
         * @param int           $hours
         * 
         * @return int
         */
        public function remove_hours(int $timestamp, int $minutes);

        /**
         * @param int           $timestamp
         * @param int           $days
         * 
         * @return int
         */
        public function add_days(int $timestamp, int $minutes);

        /**
         * @param int           $timestamp
         * @param int           $days
         * 
         * @return int
         */
        public function remove_days(int $timestamp, int $minutes);
    }