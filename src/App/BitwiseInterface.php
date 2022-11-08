<?php
    namespace Zima\App;

    interface BitwiseInterface {
        /**
         * @return bool
         */
        public function init();

        /**
         * @param \GMP|int|string       $a
         * @param \GMP|int|string       $b
         * 
         * @return \GMP|int $a & $b
         */
        public function and(mixed $a, mixed $b);

        /**
         * @param \GMP|int|string       $a
         * @param \GMP|int|string       $b
         * 
         * @return \GMP|int $a | $b
         */
        public function or(mixed $a, mixed $b);

        /**
         * @param \GMP|int|string       $a
         * @param \GMP|int|string       $b
         * 
         * @return \GMP|int $a ^ $b
         */
        public function xor(mixed $a, mixed $b);

        /**
         * @param \GMP|int|string       $a
         * 
         * @return \GMP|int ~ $a
         */
        public function not(mixed $a);

        /**
         * @param \GMP|int|string       $a
         * @param int                   $b
         * 
         * @return \GMP|int $a << $b
         */
        public function shift_left(mixed $a, int $b);

        /**
         * @param \GMP|int|string       $a
         * @param int                   $b
         * 
         * @return \GMP|int $a >> $b
         */
        public function shift_right(mixed $a, int $b);

        /**
         * @param \GMP|int|string       $a
         * @param int                   $b
         * 
         * @return bool $a & (1 << $b)
         */
        public function test(mixed $a, int $b);

        /**
         * @param \GMP|int|string       $a
         * @param int                   $b
         * 
         * @return \GMP|int $a |= (1 << $b)
         */
        public function set(mixed $a, int $b);

        /**
         * @param mixed                 $value
         * 
         * @return mixed|string
         */
        public static function float_cast(mixed $value);
    }