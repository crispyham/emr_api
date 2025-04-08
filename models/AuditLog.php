<?php

class AuditLog {
    private $conn;
    private $table = 'audit_logs';

    // Audit log properties
    public $id;
    public $user_id;
    public $action_type;
    public $record_type;
    public $record_id;
    public $timestamp;
    public $details;
    public $ip_address;
    public $user_agent;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Create an audit log entry
    public function create() {
        $query = 'INSERT INTO ' . $this->table . ' 
            (user_id, action_type, record_type, record_id, timestamp, details, ip_address, user_agent) 
            VALUES 
            (:user_id, :action_type, :record_type, :record_id, :timestamp, :details, :ip_address, :user_agent)';
        
        $stmt = $this->conn->prepare($query);

        // Bind the values to the placeholders
        $stmt->bindParam(':user_id', $this->user_id);
        $stmt->bindParam(':action_type', $this->action_type);
        $stmt->bindParam(':record_type', $this->record_type);
        $stmt->bindParam(':record_id', $this->record_id);
        $stmt->bindParam(':timestamp', $this->timestamp);
        $stmt->bindParam(':details', $this->details);
        $stmt->bindParam(':ip_address', $this->ip_address);
        $stmt->bindParam(':user_agent', $this->user_agent);

        // Execute the query
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    // Get all audit logs
    public function read() {
        $query = 'SELECT id, user_id, action_type, record_type, record_id, timestamp, details, ip_address, user_agent 
                  FROM ' . $this->table . ' ORDER BY timestamp DESC';
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    // Get a single audit log by ID
    public function read_single($id) {
        $query = 'SELECT id, user_id, action_type, record_type, record_id, timestamp, details, ip_address, user_agent 
                  FROM ' . $this->table . ' WHERE id = :id LIMIT 1';
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt;
    }

    // Update an existing audit log entry
    public function update() {
        $query = 'UPDATE ' . $this->table . ' 
                  SET user_id = :user_id, 
                      action_type = :action_type, 
                      record_type = :record_type, 
                      record_id = :record_id, 
                      timestamp = :timestamp, 
                      details = :details, 
                      ip_address = :ip_address, 
                      user_agent = :user_agent
                  WHERE id = :id';

        $stmt = $this->conn->prepare($query);

        // Bind the values to the placeholders
        $stmt->bindParam(':user_id', $this->user_id);
        $stmt->bindParam(':action_type', $this->action_type);
        $stmt->bindParam(':record_type', $this->record_type);
        $stmt->bindParam(':record_id', $this->record_id);
        $stmt->bindParam(':timestamp', $this->timestamp);
        $stmt->bindParam(':details', $this->details);
        $stmt->bindParam(':ip_address', $this->ip_address);
        $stmt->bindParam(':user_agent', $this->user_agent);
        $stmt->bindParam(':id', $this->id);

        // Execute the query
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    // Delete an audit log entry
    public function delete() {
        $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);

        return $stmt->execute();
    }
}

?>
