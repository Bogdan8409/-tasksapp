<?php
class Task {
    private $conn;
    private $table = 'tasks';

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getTask($id) {
        $stmt = $this->conn->prepare("SELECT * FROM " . $this->table . " WHERE id = ?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function updateTask($id, $title, $date, $start, $end, $notes, $status) {
        $stmt = $this->conn->prepare("UPDATE " . $this->table . " SET title=?, dates=?, starttime=?, endtime=?, notes=?, status=? WHERE id=?");
        $stmt->bind_param('ssssssi', $title, $date, $start, $end, $notes, $status, $id);
        return $stmt->execute();
    }

    public function validateTaskData($data) {
        // Basic validation logic
        return !empty($data['title']) && !empty($data['date']) && !empty($data['start']) && !empty($data['end']);
    }
}
?>