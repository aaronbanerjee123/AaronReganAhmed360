<?php
session_start();
include __DIR__ . '/../core/init.php';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $postId = $data['postId'];
    $userId = isset($_SESSION['USER']['id']) ? $_SESSION['USER']['id'] : null; // track which user clicked

    // SQL to insert click record. Adjust table/column names as necessary.
    $sql = "INSERT INTO post_clicks (post_id, user_id) VALUES (:postId, :userId)";
    $stm = $con->prepare($sql);
    $stm->execute(['postId' => $postId, 'userId' => $userId]);

    echo json_encode(['success' => true]);
}
?>