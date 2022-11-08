<?php
    namespace Zima\Data;

    interface MySQLInterface
    {
        /**
         * @return PDO
         */
        public function connect();
    }