<?php
    namespace ITATS\PraktikumTeknikSipil\App;

    use PDO;
    use PDOException;
    use ITATS\PraktikumTeknikSipil\App\Config;

    class Database {
        private static $instance = null;
        private $dbh;
        private $stmt;

        private function __construct() {
            $this->connect();
        }

        public static function getInstance() {
            if (!self::$instance) {
                self::$instance = new self();
            }
            return self::$instance;
        }

        private function connect() {
            Config::loadEnv();

            $host = Config::get('DB_HOST');
            $dbname = Config::get('DB_NAME');
            $user = Config::get('DB_USER');
            $pass = Config::get('DB_PASS');

            if (empty($host) || empty($dbname) || empty($user)) {
                throw new PDOException("Database configuration is incomplete");
            }

            $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";

            try {
                $this->dbh = new PDO($dsn, $user, $pass, [
                    PDO::ATTR_PERSISTENT => true,
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4",
                    PDO::ATTR_EMULATE_PREPARES => false
                ]);
            } catch (PDOException $e) {
                error_log("Database Connection Error: " . $e->getMessage());
                throw new PDOException("Database connection failed. Check error logs for details.");
            }
        }

        /**
         * Prepare SQL query
         * @param string $sql
         */
        public function query($sql) {
            error_log("[SQL] " . $sql); // Debug
            $this->stmt = $this->dbh->prepare($sql);
        }

        /**
         * Bind parameters to prepared statement
         * @param string $param
         * @param mixed $value
         * @param int|null $type
         */
        public function bind($param, $value, $type = null) {
            error_log("[BIND] $param = $value");
            if (is_null($type)) {
                switch (true) {
                    case is_int($value):
                        $type = PDO::PARAM_INT;
                        break;
                    case is_bool($value):
                        $type = PDO::PARAM_BOOL;
                        break;
                    case is_null($value):
                        $type = PDO::PARAM_NULL;
                        break;
                    default:
                        $type = PDO::PARAM_STR;
                }
            }
            $this->stmt->bindValue($param, $value, $type);
        }

        /**
         * Execute the prepared statement
         * @return bool
         */
        public function execute() {
            // try {
            //     return $this->stmt->execute();
            // } catch (PDOException $e) {
            //     // die("Query Execution Error: " . $e->getMessage());
            //     error_log("Query Execution Error: " . $e->getMessage());
            //     // throw new PDOException("Database operation failed" . $e->getMessage());
            //     throw new PDOException("Database operation failed: " . $e->getMessage(), (int)$e->getCode(), $e);
            // }
            try {
                return $this->stmt->execute();
            } catch (PDOException $e) {
                $errorMessage = "Database operation failed:\n" .
                                "Message: " . $e->getMessage() . "\n" .
                                "SQL: " . $this->stmt->queryString . "\n" .
                                "Bindings: " . json_encode($this->bindings ?? []) . "\n";
            
                error_log($errorMessage);
            
                throw new PDOException($errorMessage, (int)$e->getCode(), $e);
            }
            
        }

        /**
         * Get result set as array of rows
         * @return array
         */
        public function resultSet() {
            $this->execute();
            return $this->stmt->fetchAll();
        }

        /**
         * Get single row
         * @return mixed
         */
        public function single() {
            $this->execute();
            return $this->stmt->fetch();
        }

        /**
         * Get row count
         * @return int
         */
        public function rowCount() {
            return $this->stmt->rowCount();
        }

    
        public function beginTransaction() {
            return $this->dbh->beginTransaction();
        }

        public function commit() {
            return $this->dbh->commit();
        }

        public function rollBack() {
            return $this->dbh->rollBack();
        }

        /**
         * Quote a value for safe SQL insertion
         * @param mixed $value
         * @return string
         */
        public function quote($value) {
            if (is_null($value)) {
                return 'NULL';
            }

            if (is_bool($value)) {
                return $value ? '1' : '0';
            }

            if (is_numeric($value)) {
                return (string) $value;
            }

            return $this->dbh->quote($value);
        }

        private function __clone() { }

        public function __wakeup() {
            throw new PDOException("Cannot unserialize database connection");
        }
    }
?>
