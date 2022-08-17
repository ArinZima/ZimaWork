<?php
    class Bitwise {
        private static bool $is_32_gmp = false;

        /**
         * Run a single check whether the GMP extension is loaded.
         * 
         * @return bool true if GMP extension is loaded.
         */
        public static function Init(): bool {
            Debug::BackEnd("[Bitwise::Init] Checking if GMP is loaded");
            if(extension_loaded('gmp')) {
                Debug::BackEnd("[Bitwise::Init] GMP is loaded");
                self::$is_32_gmp = true;
            }

            return self::$is_32_gmp;
        }

        /**
         * @param \GMP|int|string $a
         * @param \GMP|int|string $b
         * 
         * @return \GMP|int $a & $b
         */
        public static function And($a, $b) {
            if(self::$is_32_gmp) {
                Debug::BackEnd("[Bitwise::And] [GMP] Returning \"and\" request");
                return \gmp_and(self::FloatCast($a), self::FloatCast($b));
            }

            Debug::BackEnd("[Bitwise::And] Returning \"and\" request");
            return $a & $b;
        }

        /**
         * @param \GMP|int|string $a
         * @param \GMP|int|string $b
         * 
         * @return \GMP|int $a | $b
         */
        public static function Or($a, $b) {
            if(self::$is_32_gmp) {
                Debug::BackEnd("[Bitwise::Or] [GMP] Returning \"or\" request");
                return \gmp_or(self::FloatCast($a), self::FloatCast($b));
            }

            Debug::BackEnd("[Bitwise::Or] Returning \"or\" request");
            return $a | $b;
        }

        /**
         * @param \GMP|int|string $a
         * @param \GMP|int|string $b
         * 
         * @return \GMP|int $a ^ $b
         */
        public static function Xor($a, $b) {
            if(self::$is_32_gmp) {
                Debug::BackEnd("[Bitwise::Xor] [GMP] Returning \"xor\" request");
                return \gmp_xor(self::FloatCast($a), self::FloatCast($b));
            }

            Debug::BackEnd("[Bitwise::Xor] Returning \"xor\" request");
            return $a ^ $b;
        }

        /**
         * @param \GMP|int|string $a
         * 
         * @return \GMP|int ~ $a
         */
        public static function Not($a) {
            if(self::$is_32_gmp) {
                Debug::BackEnd("[Bitwise::Not] [GMP] Returning \"not\" request");
                return \gmp_sub(\gmp_neg(self::FloatCast($a)), 1);
            }

            Debug::BackEnd("[Bitwise::Not] Returning \"not\" request");
            return ~ $a;
        }

        /**
         * @param \GMT|int|string $a
         * @param int             $b
         * 
         * @return \GMP|int $a << $b
         */
        public static function ShiftLeft($a, int $b) {
            if(self::$is_32_gmp) {
                Debug::BackEnd("[Bitwise::ShiftLeft] [GMP] Returning \"shift left\" request");
                return \gmp_mul(self::FloatCast($a), \gmp_pow(2, $b));
            }

            Debug::BackEnd("[Bitwise::ShiftLeft] Returning \"shift left\" request");
            return $a << $b;
        }

        /**
         * @param \GMP|int|string $a
         * @param int             $b
         * 
         * @return \GMP|int $a >> $b
         */
        public static function ShiftRight($a, int $b) {
            if(self::$is_32_gmp) {
                Debug::BackEnd("[Bitwise::ShiftRight] [GMP] Returning \"shift right\" request");
                return \gmp_div(self::FloatCast($a), \gmp_pow(2, $b));
            }

            Debug::BackEnd("[Bitwise::ShiftRight] Returning \"shift right\" request");
            return $a >> $b;
        }

        /**
         * @param \GMP|int|string $a
         * @param int             $b
         * 
         * @return bool $a & (1 << $b)
         */
        public static function Test($a, int $b): bool {
            if(self::$is_32_gmp) {
                Debug::BackEnd("[Bitwise::Test] [GMP] Returning \"test\" request");
                return \gmp_testbit(self::FloatCast($a), $b);
            }

            Debug::BackEnd("[Bitwise::Test] Returning \"test\" request");
            return $a & (1 << $b);
        }

        /**
         * @param \GMP|int|string $a
         * @param int             $b
         * 
         * @return \GMP|int $a |= (1 << $b)
         */
        public static function Set($a, int $b) {
            if(self::$is_32_gmp) {
                Debug::BackEnd("[Bitwise::Set] [GMP] Returning \"set\" request");
                $gmp = \gmp_init(self::FloatCast($a));
                \gmp_setbit($gmp, $b);

                return $gmp;
            }

            Debug::BackEnd("[Bitwise::Set] Returning \"set\" request");
            return $a |= (1 << $b);
        }

        /**
         * Safely converts float to string, avoiding locale-dependent issues
         * 
         * @see https://github.com/brick/math/pull/20
         * 
         * @param mixed $value if not a float, it is discarded.
         * 
         * @return mixed|string string if value is a float, otherwise discarded
         */
        public static function FloatCast($value) {
            if(!is_float($value)) {
                Debug::BackEnd("[Bitwise::FloatCase] Input is not float, returning value");
                return $value;
            }

            Debug::BackEnd("[Bitwise::FloatCase] Setting numeric locale");
            $currentLocale = setlocale(LC_NUMERIC, '0');
            setlocale(LC_NUMERIC, 'C');

            $result = (string) $value;

            setlocale(LC_NUMERIC, $currentLocale);

            Debug::BackEnd("[Bitwise::FloatCase] Returning result");
            return $result;
        }

        /**
         * @return bool Whether the GMP extension is loaded
         */
        public static function Is32BitWithGMP(): bool {
            return self::$is_32_gmp;
        }
    }