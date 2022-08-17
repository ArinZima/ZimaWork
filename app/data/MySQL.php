<?php
    class MySQL {
        private $dbh = null;
        public static function Connect() {
            if(USE_MYSQL === true) {
                Debug::BackEnd("[MySQL::Connect] Attempting connection...");
                try {
                    $this->dbh = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME,DB_USER,DB_PASS);
                } catch (PDOException $e) {
                    $message = "Could not connect to database: " . $e->getMessage();
                    Debug::BackEnd("[MySQL::Connect] Connection failed. See error log for more info.");
                    Debug::Error($message);
                    die($message);
                }
            } else {
                $message = 'USE_MYSQL set to false';
                Debug::Error($message);
                die($message);
            }
        }
    }