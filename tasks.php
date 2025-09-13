<?php
require_once 'includes/config.php';

if(!isset($_SESSION["user_id"]) || $_SESSION["user_id"] === null){
    header("location: login.php");
    exit;
}

$user_id = $_SESSION["user_id"];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST['action'] ?? '';

    if ($action == 'add') {
        $title = trim($_POST["title"]);
        $description = trim($_POST["description"]);

        if (!empty($title)) {
            $sql = "INSERT INTO tasks (user_id, title, description) VALUES (:user_id, :title, :description)";
            if ($stmt = $pdo->prepare($sql)) {
                $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
                $stmt->bindParam(":title", $title, PDO::PARAM_STR);
                $stmt->bindParam(":description", $description, PDO::PARAM_STR);
                $stmt->execute();
            }
            unset($stmt);
        }
    }

    if ($action == 'delete') {
        $task_id = $_POST['task_id'];
        $sql = "DELETE FROM tasks WHERE id = :task_id AND user_id = :user_id";
        if ($stmt = $pdo->prepare($sql)) {
            $stmt->bindParam(":task_id", $task_id, PDO::PARAM_INT);
            $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
            $stmt->execute();
        }
        unset($stmt);
    }

    if ($action == 'update_status') {
        $task_id = $_POST['task_id'];
        $new_status = $_POST['new_status'];
        $sql = "UPDATE tasks SET status = :status WHERE id = :task_id AND user_id = :user_id";
        if ($stmt = $pdo->prepare($sql)) {
            $stmt->bindParam(":status", $new_status, PDO::PARAM_INT);
            $stmt->bindParam(":task_id", $task_id, PDO::PARAM_INT);
            $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
            $stmt->execute();
        }
        unset($stmt);
    }

    header("location: index.php");
    exit();
}
?>