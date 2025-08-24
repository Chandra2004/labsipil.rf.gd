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
                    PDO::ATTR_PERSISTENT => false, // Nonaktifkan persisten untuk skalabilitas, uji sesuai kebutuhan
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
    
        public function query($sql) {
            if (Config::get('DEBUG_MODE', false)) {
                error_log("[SQL] " . $sql);
            }
            try {
                $this->stmt = $this->dbh->prepare($sql);
                if ($this->stmt === false) {
                    throw new PDOException("Failed to prepare statement: $sql");
                }
            } catch (PDOException $e) {
                error_log("Prepare Statement Error: " . $e->getMessage());
                throw $e;
            }
        }
    
        public function bind($param, $value, $type = null) {
            if (Config::get('DEBUG_MODE', false)) {
                error_log("[BIND] $param = $value");
            }
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
    
        public function execute() {
            try {
                return $this->stmt->execute();
            } catch (PDOException $e) {
                $errorMessage = "Database operation failed:\n" .
                                "Message: " . $e->getMessage() . "\n" .
                                "SQL: " . $this->stmt->queryString . "\n";
                error_log($errorMessage);
                throw new PDOException($errorMessage, (int)$e->getCode(), $e);
            }
        }
    
        public function resultSet() {
            $this->execute();
            $result = $this->stmt->fetchAll();
            $this->stmt->closeCursor();
            return $result;
        }
    
        public function single() {
            $this->execute();
            $result = $this->stmt->fetch();
            $this->stmt->closeCursor();
            return $result;
        }
    
        public function rowCount() {
            return $this->stmt->rowCount();
        }
    
        public function beginTransaction() {
            if (!$this->dbh->inTransaction()) {
                return $this->dbh->beginTransaction();
            }
            return true;
        }
    
        public function commit() {
            return $this->dbh->commit();
        }
    
        public function rollBack() {
            return $this->dbh->rollBack();
        }
    
        public function quote($value) {
            if (is_null($value)) {
                return 'NULL';
            }
            return $this->dbh->quote($value);
        }
    
        private function __clone() { }
    
        public function __wakeup() {
            throw new PDOException("Cannot unserialize database connection");
        }
    }
