<?php

class Doctor {
    private $conn;
    private $table = 'doctors';

    public $doctor_id;
    public $first_name;
    public $last_name;
    public $specialty;
    public $email;
    public $phone;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Get all doctors
    public function read() {
        $query = 'SELECT doctor_id, first_name, last_name, specialty, email, phone
                  FROM ' . $this->table . ' ORDER BY doctor_id ASC';

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    // Get single doctor by doctor_id
    public function read_single($doctor_id) {
        $query = 'SELECT doctor_id, first_name, last_name, specialty, email, phone
                  FROM ' . $this->table . ' WHERE doctor_id = :doctor_id LIMIT 1';

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':doctor_id', $doctor_id);
        $stmt->execute();

        return $stmt;
    }

    // Create a new doctor
    public function create() {
        $query = 'INSERT INTO ' . $this->table . ' 
            (first_name, last_name, specialty, email, phone) 
            VALUES 
            (:first_name, :last_name, :specialty, :email, :phone)';

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':first_name', $this->first_name);
        $stmt->bindParam(':last_name', $this->last_name);
        $stmt->bindParam(':specialty', $this->specialty);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':phone', $this->phone);

        return $stmt->execute();
    }

    // Update existing doctor
    public function update() {
        $query = 'UPDATE ' . $this->table . ' SET
                    first_name = :first_name,
                    last_name = :last_name,
                    specialty = :specialty,
                    email = :email,
                    phone = :phone
                  WHERE doctor_id = :doctor_id';

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':first_name', $this->first_name);
        $stmt->bindParam(':last_name', $this->last_name);
        $stmt->bindParam(':specialty', $this->specialty);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':phone', $this->phone);
        $stmt->bindParam(':doctor_id', $this->doctor_id);

        return $stmt->execute();
    }

    // Delete doctor
    public function delete() {
        $query = 'DELETE FROM ' . $this->table . ' WHERE doctor_id = :doctor_id';

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':doctor_id', $this->doctor_id);

        return $stmt->execute();
    }
}

?>
