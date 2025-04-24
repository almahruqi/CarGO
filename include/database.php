<?php
class Database {
    private $host;
    private $username;
    private $password;
    private $database;
    private $connection;
    private static $instance = null;

    private function __construct() {
        $this->host = 'localhost';
        $this->username = 'root';
        $this->password = '';
        $this->database = 'cargo';
        $this->connect();
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function connect() {
        try {
            $this->connection = new mysqli($this->host, $this->username, $this->password, $this->database);
            
            if ($this->connection->connect_error) {
                throw new Exception("Connection failed: " . $this->connection->connect_error);
            }

            // Set charset to utf8mb4
            $this->connection->set_charset("utf8mb4");

        } catch (Exception $e) {
            error_log("Database connection error: " . $e->getMessage());
            throw new Exception("Database connection failed. Please try again later.");
        }
    }

    public function query($sql, $params = [], $types = '') {
        try {
            $stmt = $this->connection->prepare($sql);
            
            if (!$stmt) {
                throw new Exception("Prepare failed: " . $this->connection->error);
            }

            if (!empty($params)) {
                $stmt->bind_param($types, ...$params);
            }

            if (!$stmt->execute()) {
                throw new Exception("Execute failed: " . $stmt->error);
            }

            return $stmt;
        } catch (Exception $e) {
            error_log("Query error: " . $e->getMessage());
            throw new Exception("Database operation failed. Please try again later.");
        }
    }

    public function fetch($sql, $params = [], $types = '') {
        try {
            $stmt = $this->query($sql, $params, $types);
            $result = $stmt->get_result();
            return $result->fetch_assoc();
        } catch (Exception $e) {
            error_log("Fetch error: " . $e->getMessage());
            throw new Exception("Failed to fetch data. Please try again later.");
        }
    }

    public function fetchAll($sql, $params = [], $types = '') {
        try {
            $stmt = $this->query($sql, $params, $types);
            $result = $stmt->get_result();
            $rows = [];
            while ($row = $result->fetch_assoc()) {
                $rows[] = $row;
            }
            return $rows;
        } catch (Exception $e) {
            error_log("FetchAll error: " . $e->getMessage());
            throw new Exception("Failed to fetch data. Please try again later.");
        }
    }

    public function insert($table, $data) {
        try {
            $columns = implode(', ', array_keys($data));
            $values = implode(', ', array_fill(0, count($data), '?'));
            $types = str_repeat('s', count($data));
            
            $sql = "INSERT INTO $table ($columns) VALUES ($values)";
            $stmt = $this->query($sql, array_values($data), $types);
            
            return $this->connection->insert_id;
        } catch (Exception $e) {
            error_log("Insert error: " . $e->getMessage());
            throw new Exception("Failed to insert data. Please try again later.");
        }
    }

    public function update($table, $data, $where, $whereParams = [], $whereTypes = '') {
        try {
            $set = implode(' = ?, ', array_keys($data)) . ' = ?';
            $types = str_repeat('s', count($data)) . $whereTypes;
            
            $sql = "UPDATE $table SET $set WHERE $where";
            $params = array_merge(array_values($data), $whereParams);
            
            $stmt = $this->query($sql, $params, $types);
            return $stmt->affected_rows;
        } catch (Exception $e) {
            error_log("Update error: " . $e->getMessage());
            throw new Exception("Failed to update data. Please try again later.");
        }
    }

    public function delete($table, $where, $params = [], $types = '') {
        try {
            $sql = "DELETE FROM $table WHERE $where";
            $stmt = $this->query($sql, $params, $types);
            return $stmt->affected_rows;
        } catch (Exception $e) {
            error_log("Delete error: " . $e->getMessage());
            throw new Exception("Failed to delete data. Please try again later.");
        }
    }

    public function beginTransaction() {
        $this->connection->begin_transaction();
    }

    public function commit() {
        $this->connection->commit();
    }

    public function rollback() {
        $this->connection->rollback();
    }

    public function escape($value) {
        return $this->connection->real_escape_string($value);
    }

    public function getLastError() {
        return $this->connection->error;
    }

    public function getLastInsertId() {
        return $this->connection->insert_id;
    }

    public function __destruct() {
        if ($this->connection) {
            $this->connection->close();
        }
    }
}

// Example usage:
/*
$db = Database::getInstance();

// Fetch single row
$user = $db->fetch("SELECT * FROM users WHERE id = ?", [1], 'i');

// Fetch multiple rows
$users = $db->fetchAll("SELECT * FROM users WHERE status = ?", ['active'], 's');

// Insert
$id = $db->insert('users', [
    'name' => 'John',
    'email' => 'john@example.com'
]);

// Update
$db->update('users', 
    ['name' => 'John Doe'], 
    'id = ?', 
    [1], 
    'i'
);

// Delete
$db->delete('users', 'id = ?', [1], 'i');

// Transaction
$db->beginTransaction();
try {
    $db->insert('orders', ['user_id' => 1, 'amount' => 100]);
    $db->update('users', ['balance' => 900], 'id = ?', [1], 'i');
    $db->commit();
} catch (Exception $e) {
    $db->rollback();
    throw $e;
}
*/
?> 