<?php
    namespace Zima\App;

    /**
     * Class Time
     * 
     * @author Arin Zima <arin@arinzima.com>
     */
    class Time implements TimeInterface
    {
        /**
         * Get the current timestamp
         */
        public function current()
        {
            return time();
        }

        /**
         * Format a timestamp to a readable date and time
         */
        public function format(string $format, ?int $timestamp = null)
        {
            return date($format, $timestamp);
        }

        /**
         * Add an amount of seconds to a timestamp
         */
        public function add_seconds(int $timestamp, int $seconds)
        {
            return $timestamp + $seconds;
        }

        /**
         * Remove an amount of seconds from a timestamp
         */
        public function remove_seconds(int $timestamp, int $seconds)
        {
            return $timestamp - $seconds;
        }

        /**
         * Add an amount of minutes to a timestamp
         */
        public function add_minutes(int $timestamp, int $minutes)
        {
            return $timestamp + 60 * $minutes;
        }

        /**
         * Remove an amount of minutes to a timestamp
         */
        public function remove_minutes(int $timestamp, int $minutes)
        {
            return $timestamp - 60 * $minutes;
        }

        /**
         * Add an amount of hours to a timestamp
         */
        public function add_hours(int $timestamp, int $hours)
        {
            return $timestamp + 60 * 60 * $hours;
        }

        /**
         * Remove an amount of hours to a timestamp
         */
        public function remove_hours(int $timestamp, int $hours)
        {
            return $timestamp - 60 * 60 * 24 * $hours;
        }

        /**
         * Add an amount of days to a timestamp
         */
        public function add_days(int $timestamp, int $days)
        {
            return $timestamp + 60 * 60 * 24 * $days;
        }

        /**
         * Remove an amount of days to a timestamp
         */
        public function remove_days(int $timestamp, int $days)
        {
            return $timestamp - 60 * 60 * 24 * $days;
        }
    }