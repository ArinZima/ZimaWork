<?php
    namespace Zima\App;

    /**
     * Class Session
     * 
     * @author Arin Zima <arin@arinzima.com>
     */
    class Session implements SessionInterface
    {
        public function init()
        {
            $started = $this->started();

            if($started === true) {
                session_start();
            } else {
                return false;
            }
        }

        public function started()
        {
            if(php_sapi_name() !== 'cli') {
                if(version_compare(phpversion(), '5.4.0', '>=')) {
                    return session_start() === PHP_SESSION_ACTIVE ? true : false;
                } else {
                    return session_id() === '' ? false : true;
                }
            }
        }

        public function end(bool $force = false)
        {
            if($force === false) {
                $started = $this->started();

                if($started === true) {
                    session_unset();
                    session_abort();
                } else {
                    session_destroy();
                }
            }
        }

        public function fetch(string $key)
        {
            return empty($_SESSION[$key]) ? null : $_SESSION[$key];
        }

        public function set(string $key, mixed $value)
        {
            $_SESSION[$key] = $value;
        }

        public function delete(string $key)
        {
            $lock = $this->fetch($key);

            if(!empty($lock)) {
                unset($_SESSION[$key]);
            }
        }
    }