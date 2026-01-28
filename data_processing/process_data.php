<?php
require_once("../config/db.php");

header('Content-Type: application/json');

$response = [
    "success" => false,
    "message" => "",
    "data" => null
];

try {
    $conn = Database::getInstance();
    
    $action = $_POST['action'] ?? $_GET['action'] ?? '';
    
    switch($action) {
        case 'add_student':
            $stmt = $conn->prepare("INSERT INTO students (Student_Id, Student_Name, Student_Class) VALUES (:student_id, :student_name, :student_class)");
            $stmt->execute([
                ':student_id' => htmlspecialchars($_POST['student_id']),
                ':student_name' => htmlspecialchars($_POST['student_name']),
                ':student_class' => htmlspecialchars($_POST['student_class'])
            ]);
            $response = [
                'success' => true,
                'message' => "Student added successfully",
                'data' => ['id' => $conn->lastInsertId()]
            ];
            break;
            
        case 'get_students':
            $stmt = $conn->prepare("SELECT * FROM students ORDER BY Student_Id");
            $stmt->execute();
            $students = $stmt->fetchAll();
            $response = [
                'success' => true,
                'data' => $students
            ];
            break;
            
        case 'update_student':
            $stmt = $conn->prepare("UPDATE students SET Student_Name = :student_name, Student_Class = :student_class WHERE Student_Id = :student_id");
            $stmt->execute([
                ':student_id' => htmlspecialchars($_POST['student_id']),
                ':student_name' => htmlspecialchars($_POST['student_name']),
                ':student_class' => htmlspecialchars($_POST['student_class'])
            ]);
            $response = [
                'success' => true,
                'message' => "Student updated successfully"
            ];
            break;
            
        case 'delete_student':
            $stmt = $conn->prepare("DELETE FROM students WHERE Student_Id = :student_id");
            $stmt->execute([':student_id' => $_POST['student_id']]);
            $response = [
                'success' => true,
                'message' => "Student deleted successfully"
            ];
            break;
            
        default:
            $response['message'] = "Invalid action";
            break;
    }
} catch(PDOException $e) {
    $response['message'] = "Database error: " . $e->getMessage();
} catch(Exception $e) {
    $response['message'] = "Error: " . $e->getMessage();
}

echo json_encode($response);
?>