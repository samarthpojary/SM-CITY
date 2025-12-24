<?php
namespace App\Controllers;

use App\Models\Complaint;
use App\Models\User;

class ApiController
{
    public function complaints()
    {
        header('Content-Type: application/json');

        $method = $_SERVER['REQUEST_METHOD'];

        switch ($method) {
            case 'GET':
                $this->getComplaints();
                break;
            case 'POST':
                $this->createComplaint();
                break;
            default:
                http_response_code(405);
                echo json_encode(['error' => 'Method not allowed']);
        }
    }

    private function getComplaints()
    {
        $userId = $_GET['user_id'] ?? null;
        $status = $_GET['status'] ?? null;

        $complaints = Complaint::listForRole('citizen', $userId, $status);
        echo json_encode($complaints);
    }

    private function createComplaint()
    {
        $data = json_decode(file_get_contents('php://input'), true);

        if (!$data) {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid JSON data']);
            return;
        }

        // Validate required fields
        $required = ['user_id', 'title', 'description', 'latitude', 'longitude'];
        foreach ($required as $field) {
            if (!isset($data[$field])) {
                http_response_code(400);
                echo json_encode(['error' => "Missing required field: $field"]);
                return;
            }
        }

        $complaintId = Complaint::create($data);
        http_response_code(201);
        echo json_encode(['id' => $complaintId, 'message' => 'Complaint created successfully']);
    }

    public function complaint($id)
    {
        header('Content-Type: application/json');

        $method = $_SERVER['REQUEST_METHOD'];

        switch ($method) {
            case 'GET':
                $complaint = Complaint::find($id);
                if ($complaint) {
                    echo json_encode($complaint);
                } else {
                    http_response_code(404);
                    echo json_encode(['error' => 'Complaint not found']);
                }
                break;
            case 'PUT':
                $this->updateComplaint($id);
                break;
            case 'DELETE':
                $this->deleteComplaint($id);
                break;
            default:
                http_response_code(405);
                echo json_encode(['error' => 'Method not allowed']);
        }
    }

    private function updateComplaint($id)
    {
        $data = json_decode(file_get_contents('php://input'), true);

        if (!$data) {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid JSON data']);
            return;
        }

        $updated = Complaint::update($id, $data);
        if ($updated) {
            echo json_encode(['message' => 'Complaint updated successfully']);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Complaint not found']);
        }
    }

    private function deleteComplaint($id)
    {
        $deleted = Complaint::delete($id);
        if ($deleted) {
            echo json_encode(['message' => 'Complaint deleted successfully']);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Complaint not found']);
        }
    }
}
