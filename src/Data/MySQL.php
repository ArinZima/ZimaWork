<?php
    namespace Zima\Data;

    /**
     * Class MySQL
     * 
     * @author Arin Zima <arin@arinzima.com>
     * 
     * TODO: Provide query system
     */
    class MySQL implements MySQLInterface
    {
        private const NOT_ENABLED = "ConfigError: \"MYSQL\" is set to false.";
        private const FAILED = 'Could not connect to database: %s';

        private $dbh = null;
        
        public function connect()
        {
            if(MYSQL === true)
            {
                try
                {
                    $this->dbh = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME,DB_USER,DB_PASS);
                }
                catch (PDOException $e)
                {
                    die(sprintf(self::FAILED));
                }
            }
            else
            {
                die(self::NOT_ENABLED);
            }
        }
    }