<?php
require_once '../Models/Task.php';
require_once '../Core/Controller.php';

class TaskController extends Controller {
    public function edit($id) {
        $taskModel = new Task();
        $task = $taskModel->getTaskById($id);

        if (!$task) {
            // Handle task not found (e.g., redirect or show an error)
            header('Location: /public/index.php');
            exit;
        }

        $this->render('tasks/edit', ['task' => $task]);
    }

    public function update() {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $taskModel = new Task();
            $data = [
                'id' => $_POST['id'],
                'title' => $_POST['title'],
                'date' => $_POST['date'],
                'start' => $_POST['start'],
                'end' => $_POST['end'],
                'notes' => $_POST['notes'],
                'status' => $_POST['status']
            ];

            $result = $taskModel->updateTask($data);

            if ($result) {
                echo json_encode(["success" => true]);
            } else {
                echo json_encode(["success" => false, "error" => "Failed to update task."]);
            }
            exit;
        }
    }
}
?>