<?php

class Diagnosis {
    private $conn;
    private $table = 'diagnoses';

    // Diagnosis properties
    public $id;
    public $appointment_id;
    public $diagnosis_code;
    public $description;

    // Constructor with DB
    public function __construct($db) {
        $this->conn = $db;
    }

    // Get all diagnoses
    public function read() {
        $query = 'SELECT id, appointment_id, diagnosis_code, description
                  FROM ' . $this->table . ' 
                  ORDER BY id ASC';

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    // Get a single diagnosis by id
    public function read_single($id) {
        // SQL query to select a single diagnosis based on the provided ID
        $query = 'SELECT id, appointment_id, diagnosis_code, description
                  FROM ' . $this->table . ' 
                  WHERE id = :id LIMIT 1'; // Filter by id
    
        // Prepare statement
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    
        return $stmt;
    }

    // Create a new diagnosis
    public function create() {
        $query = 'INSERT INTO ' . $this->table . ' 
                  (appointment_id, diagnosis_code, description) 
                  VALUES 
                  (:appointment_id, :diagnosis_code, :description)';

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':appointment_id', $this->appointment_id);
        $stmt->bindParam(':diagnosis_code', $this->diagnosis_code);
        $stmt->bindParam(':description', $this->description);

        try {
            return $stmt->execute();
        } catch (PDOException $e) {
            echo json_encode(['message' => 'Diagnosis Not Created']);
            exit();
        }
    }

    // Update an existing diagnosis
    public function update() {
        $query = 'UPDATE ' . $this->table . ' 
                  SET appointment_id = :appointment_id,
                      diagnosis_code = :diagnosis_code,
                      description = :description
                  WHERE id = :id';

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':appointment_id', $this->appointment_id);
        $stmt->bindParam(':diagnosis_code', $this->diagnosis_code);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':id', $this->id);

        try {
            return $stmt->execute();
        } catch (PDOException $e) {
            echo json_encode(['message' => 'Diagnosis Not Updated']);
            exit();
        }
    }

    // Delete a diagnosis
    public function delete($id) {
        // Check if the diagnosis exists before attempting to delete
        $check_query = 'SELECT id FROM ' . $this->table . ' WHERE id = :id LIMIT 1';
        $stmt = $this->conn->prepare($check_query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    
        // If diagnosis doesn't exist, return false
        if ($stmt->rowCount() == 0) {
            return false;
        }
    
        // Prepare the delete query if diagnosis exists
        $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';
    
        // Prepare statement
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
    
        // Execute the delete query
        return $stmt->execute();
    }
    
    
}
?>