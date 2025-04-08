<?php
class Database {
    private $conn;

    private $host = "localhost";
    private $port = "5432";
    private $db_name = "emr_platform";
    private $username = "postgres";
    private $password = "default"; // ← Replace with your actual DB password

    public function connect() {
        $this->conn = null;

        try {
            $this->conn = new PDO(
                "pgsql:host={$this->host};port={$this->port};dbname={$this->db_name}",
                $this->username,
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            echo json_encode(['message' => 'Database Connection Error']);
            exit();
        }

        return $this->conn;
    }
}
?>
