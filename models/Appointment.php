<?php

class Appointment {
    private $conn;
    private $table = 'appointments';

    public $id;
    public $patient_id;
    public $doctor_id;
    public $scheduled_date;
    public $reason;
    public $status;

    // Constructor with DB
    public function __construct($db) {
        $this->conn = $db;
    }

    // Get all appointments
    public function read() {
        $query = 'SELECT 
                    a.id, 
                    a.scheduled_date, 
                    a.reason, 
                    a.status,
                    p.first_name || \' \' || p.last_name AS patient_name,
                    d.first_name || \' \' || d.last_name AS doctor_name
                  FROM ' . $this->table . ' a
                  JOIN patients p ON a.patient_id = p.patient_id
                  JOIN doctors d ON a.doctor_id = d.doctor_id
                  ORDER BY a.id ASC';

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Get single appointment by id
    public function read_single($id) {
        $query = 'SELECT 
                    a.id, 
                    a.scheduled_date, 
                    a.reason, 
                    a.status,
                    p.first_name || \' \' || p.last_name AS patient_name,
                    d.first_name || \' \' || d.last_name AS doctor_name
                  FROM ' . $this->table . ' a
                  JOIN patients p ON a.patient_id = p.patient_id
                  JOIN doctors d ON a.doctor_id = d.doctor_id
                  WHERE a.id = :id'; // Ensuring the correct WHERE clause
                  
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);  // Binding the ID
        $stmt->execute();
    
        return $stmt;
    }
    

    // Create appointment
    public function create() {
        $query = 'INSERT INTO ' . $this->table . ' 
                  (patient_id, doctor_id, scheduled_date, reason, status) 
                  VALUES 
                  (:patient_id, :doctor_id, :scheduled_date, :reason, :status)';

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':patient_id', $this->patient_id);
        $stmt->bindParam(':doctor_id', $this->doctor_id);
        $stmt->bindParam(':scheduled_date', $this->scheduled_date);
        $stmt->bindParam(':reason', $this->reason);
        $stmt->bindParam(':status', $this->status);

        return $stmt->execute();
    }

    // Update appointment
    public function update() {
        $query = 'UPDATE ' . $this->table . ' 
                  SET patient_id = :patient_id,
                      doctor_id = :doctor_id,
                      scheduled_date = :scheduled_date,
                      reason = :reason,
                      status = :status
                  WHERE id = :id';

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':patient_id', $this->patient_id);
        $stmt->bindParam(':doctor_id', $this->doctor_id);
        $stmt->bindParam(':scheduled_date', $this->scheduled_date);
        $stmt->bindParam(':reason', $this->reason);
        $stmt->bindParam(':status', $this->status);
        $stmt->bindParam(':id', $this->id);

        return $stmt->execute();
    }

    // Delete appointment
    public function delete() {
        $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);

        return $stmt->execute();
    }
}

?>
