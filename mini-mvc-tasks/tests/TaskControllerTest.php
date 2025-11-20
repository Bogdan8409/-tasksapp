<?php
use PHPUnit\Framework\TestCase;

class TaskControllerTest extends TestCase
{
    protected $controller;

    protected function setUp(): void
    {
        $this->controller = new TaskController();
    }

    public function testEditTask()
    {
        // Simulate a GET request to edit a task
        $_GET['id'] = 1;

        ob_start();
        $this->controller->edit();
        $output = ob_get_clean();

        $this->assertStringContainsString('Editare sarcină', $output);
    }

    public function testUpdateTaskSuccess()
    {
        // Simulate a POST request to update a task
        $_POST = [
            'id' => 1,
            'title' => 'Updated Task',
            'date' => '2023-10-01',
            'start' => '10:00',
            'end' => '11:00',
            'notes' => 'Updated notes',
            'status' => 'open'
        ];

        ob_start();
        $response = $this->controller->update();
        $output = ob_get_clean();

        $this->assertJsonStringEqualsJsonString(
            json_encode(['success' => true]),
            $response
        );
    }

    public function testUpdateTaskInvalidId()
    {
        // Simulate a POST request with an invalid ID
        $_POST = [
            'id' => 0,
            'title' => 'Invalid Task',
            'date' => '2023-10-01',
            'start' => '10:00',
            'end' => '11:00',
            'notes' => 'Invalid notes',
            'status' => 'open'
        ];

        ob_start();
        $response = $this->controller->update();
        $output = ob_get_clean();

        $this->assertJsonStringEqualsJsonString(
            json_encode(['success' => false, 'error' => 'Invalid ID']),
            $response
        );
    }
}
?>