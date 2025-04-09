<?php

class MedicalRecord {
    private $conn;
    private $table = 'medical_records';

    public $id;
    public $appointment_id;
    public $notes;
    public $created_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Get all medical records
    public function read() {
        $query = 'SELECT id, appointment_id, notes, created_at FROM ' . $this->table . ' ORDER BY id ASC';
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        return $stmt;
    }

    // Get single medical record by id
    public function read_single($id) {
        $query = 'SELECT id, appointment_id, notes, created_at 
                  FROM ' . $this->table . ' 
                  WHERE id = :id LIMIT 1';
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        
        return $stmt;
    }

    // Create a new medical record
    public function create() {
        $query = 'INSERT INTO ' . $this->table . ' (appointment_id, notes, created_at) 
                  VALUES (:appointment_id, :notes, :created_at)';
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':appointment_id', $this->appointment_id);
        $stmt->bindParam(':notes', $this->notes);
        $stmt->bindParam(':created_at', $this->created_at);
        
        return $stmt->execute();
    }

    // Update an existing medical record
    public function update() {
        $query = 'UPDATE ' . $this->table . ' 
                  SET appointment_id = :appointment_id, notes = :notes, created_at = :created_at 
                  WHERE id = :id';
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':appointment_id', $this->appointment_id);
        $stmt->bindParam(':notes', $this->notes);
        $stmt->bindParam(':created_at', $this->created_at);
        $stmt->bindParam(':id', $this->id);
        
        return $stmt->execute();
    }

    // Delete a medical record
    public function delete() {
        $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':id', $this->id);
        
        return $stmt->execute();
    }
}
?>