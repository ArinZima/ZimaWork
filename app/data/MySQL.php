<?php
    require './app/main/Base.php';

    class MySQL {
        private $dbh = null;
        public function __construct() {
            if(USE_MYSQL === true) {
                try {
                    $this->dbh = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME,DB_USER,DB_PASS);
                } catch (PDOException $e) {
                    die("Could not connect to database: " . $e->getMessage());
                }
            } else {
                $base = new Base();

                $message = 'Config: USE_MYSQL set to false';
                $base::debug($message);
                die($message);
            }
        }

        public function query(string $sql) {
            $query = $this->dbh->prepare($sql);
            $query->execute();
            return $query;
        }
    }