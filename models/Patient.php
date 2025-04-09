<?php

class Patient {
    private $conn;
    private $table = 'patients';

    public $patient_id;
    public $first_name;
    public $last_name;
    public $date_of_birth;
    public $gender;
    public $email;
    public $phone;
    public $address;
    public $city;
    public $state;
    public $zip_code;
    public $ssn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Get all patients
    public function read() {
        $query = 'SELECT patient_id, first_name, last_name, date_of_birth, gender, email, phone, address, city, state, zip_code
                  FROM ' . $this->table . ' ORDER BY patient_id ASC';

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    // Get single patient by patient_id
    public function read_single($patient_id) {
        $query = 'SELECT patient_id, first_name, last_name, date_of_birth, gender, email, phone, address, city, state, zip_code
                  FROM ' . $this->table . ' WHERE patient_id = :patient_id LIMIT 1';

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':patient_id', $patient_id);
        $stmt->execute();

        return $stmt;
    }

    // Create new patient
    public function create() {
        $query = 'INSERT INTO ' . $this->table . ' 
            (first_name, last_name, date_of_birth, gender, email, phone, address, city, state, zip_code, ssn) 
            VALUES 
            (:first_name, :last_name, :date_of_birth, :gender, :email, :phone, :address, :city, :state, :zip_code, :ssn)';

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':first_name', $this->first_name);
        $stmt->bindParam(':last_name', $this->last_name);
        $stmt->bindParam(':date_of_birth', $this->date_of_birth);
        $stmt->bindParam(':gender', $this->gender);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':phone', $this->phone);
        $stmt->bindParam(':address', $this->address);
        $stmt->bindParam(':city', $this->city);
        $stmt->bindParam(':state', $this->state);
        $stmt->bindParam(':zip_code', $this->zip_code);
        $stmt->bindParam(':ssn', $this->ssn);

        try {
            return $stmt->execute();
        } catch (PDOException $e) {
            if ($e->getCode() === '23505') {
                echo json_encode(['message' => 'Duplicate SSN']);
            } else {
                echo json_encode(['message' => 'Patient Not Created']);
            }
            exit();
        }
    }

    // Update existing patient
    public function update() {
        $query = 'UPDATE ' . $this->table . ' SET
                    first_name = :first_name,
                    last_name = :last_name,
                    date_of_birth = :date_of_birth,
                    gender = :gender,
                    email = :email,
                    phone = :phone,
                    address = :address,
                    city = :city,
                    state = :state,
                    zip_code = :zip_code,
                    ssn = :ssn
                  WHERE patient_id = :patient_id';

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':first_name', $this->first_name);
        $stmt->bindParam(':last_name', $this->last_name);
        $stmt->bindParam(':date_of_birth', $this->date_of_birth);
        $stmt->bindParam(':gender', $this->gender);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':phone', $this->phone);
        $stmt->bindParam(':address', $this->address);
        $stmt->bindParam(':city', $this->city);
        $stmt->bindParam(':state', $this->state);
        $stmt->bindParam(':zip_code', $this->zip_code);
        $stmt->bindParam(':ssn', $this->ssn);
        $stmt->bindParam(':patient_id', $this->patient_id);

        try {
            return $stmt->execute();
        } catch (PDOException $e) {
            if ($e->getCode() === '23505') {
                echo json_encode(['message' => 'Duplicate SSN']);
            } else {
                echo json_encode(['message' => 'Patient Not Updated']);
            }
            exit();
        }
    }

    // Delete patient
    public function delete() {
        $query = 'DELETE FROM ' . $this->table . ' WHERE patient_id = :patient_id';

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':patient_id', $this->patient_id);

        return $stmt->execute();
    }
}
?>