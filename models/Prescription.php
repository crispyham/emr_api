<?php

class Prescription {
    private $conn;
    private $table = 'prescriptions';

    public $id;
    public $appointment_id;
    public $medication_name;
    public $dosage;
    public $instructions;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Get all prescriptions
    public function read() {
        $query = 'SELECT 
                    p.id, 
                    p.appointment_id, 
                    p.medication_name, 
                    p.dosage, 
                    p.instructions 
                  FROM ' . $this->table . ' p 
                  ORDER BY p.id ASC';

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    // Get a single prescription by ID
    public function read_single($id) {
        $query = 'SELECT 
                    p.id, 
                    p.appointment_id, 
                    p.medication_name, 
                    p.dosage, 
                    p.instructions
                  FROM ' . $this->table . ' p
                  WHERE p.id = :id LIMIT 1';  // Adding LIMIT to ensure only one record is returned

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt;
    }

    // Create a new prescription
    public function create() {
        $query = 'INSERT INTO ' . $this->table . ' 
            (appointment_id, medication_name, dosage, instructions) 
            VALUES 
            (:appointment_id, :medication_name, :dosage, :instructions)';

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':appointment_id', $this->appointment_id);
        $stmt->bindParam(':medication_name', $this->medication_name);
        $stmt->bindParam(':dosage', $this->dosage);
        $stmt->bindParam(':instructions', $this->instructions);

        try {
            return $stmt->execute();
        } catch (PDOException $e) {
            echo json_encode(['message' => 'Prescription Not Created']);
            exit();
        }
    }

    // Update an existing prescription
    public function update() {
        $query = 'UPDATE ' . $this->table . ' SET
                    appointment_id = :appointment_id,
                    medication_name = :medication_name,
                    dosage = :dosage,
                    instructions = :instructions
                  WHERE id = :id';

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':appointment_id', $this->appointment_id);
        $stmt->bindParam(':medication_name', $this->medication_name);
        $stmt->bindParam(':dosage', $this->dosage);
        $stmt->bindParam(':instructions', $this->instructions);
        $stmt->bindParam(':id', $this->id);

        try {
            return $stmt->execute();
        } catch (PDOException $e) {
            echo json_encode(['message' => 'Prescription Not Updated']);
            exit();
        }
    }

    // Delete a prescription
    public function delete() {
        $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);

        return $stmt->execute();
    }
}
?>