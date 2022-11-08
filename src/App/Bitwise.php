<?php
    namespace Zima\App;

    /**
     * Class Bitwise
     * 
     * @author Arin Zima <arin@arinzima.com>
     * @see https://github.com/discord-php/DiscordPHP
     */
    class Bitwise implements BitwiseInterface
    {
        private static bool $gmp = false;

        /**
         * Run a single check whether the GMP extension is loaded.
         */
        public function init()
        {
            if(extension_loaded("gmp"))
            {
                self::$gmp = true;
            }

            return self::$gmp;
        }

        public function and(mixed $a, mixed $b)
        {
            if(self::$gmp) {
                return \gmp_and(self::float_cast($a), self::float_case($b));
            }

            return $a & $b;
        }

        public function or(mixed $a, mixed $b)
        {
            if(self::$gmp)
            {
                return \gmp_or(self::float_cast($a), self::float_cast($b));
            }

            return $a | $b;
        }

        public function xor(mixed $a, mixed $b)
        {
            if(self::$gmp)
            {
                return \gmp_xor(self::float_cast($a), self::float_cast($b));
            }

            return $a ^ $b;
        }

        public function not(mixed $a)
        {
            if(self::$gmp)
            {
                return \gmp_sub(\gmp_neg(self::float_cast($a)), 1);
            }

            return ~ $a;
        }

        public function shift_left(mixed $a, int $b)
        {
            if(self::$gmp)
            {
                return \gmp_mul(self::float_cast($a), \gmp_pow(2, $b));
            }

            return $a << $b;
        }

        public function shift_right(mixed $a, int $b)
        {
            if(self::$gmp)
            {
                return \gmp_div(self::float_cast($a), \gmp_pow(2, $b));
            }

            return $a >> $b;
        }

        public function test(mixed $a, int $b)
        {
            if(self::$gmp)
            {
                return \gmp_testbit(self::float_cast($a), $b);
            }

            return $a & (1 << $b);
        }

        public function set(mixed $a, int $b)
        {
            if(self::$gmp)
            {
                $gmp = \gmp_init(self::float_cast($a));
                \gmp_setbit($gmp, $b);

                return $gmp;
            }

            return $a |= (1 << $b);
        }

        /**
         * Safely converts float to string, avoiding locale-dependent issues
         * 
         * @see https://github.com/brick/math/pull/20
         */
        public static function float_cast(mixed $value)
        {
            if(!is_float($value))
            {
                return $value;
            }

            $currentLocale = setlocale(LC_NUMERIC, '0');
            setlocale(LC_NUMERIC, 'C');

            $result = (string) $value;

            setlocale(LC_NUMERIC, $currentLocale);

            return $result;
        }
    }