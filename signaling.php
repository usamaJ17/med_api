// signaling.php
<?php
session_start();

if (!isset($_SESSION['peers'])) {
    $_SESSION['peers'] = [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['peer_id'])) {
        $_SESSION['peers'][$data['peer_id']] = $data;
        echo json_encode(['status' => 'ok']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'peer_id missing']);
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $peer_id = $_GET['peer_id'] ?? null;

    if ($peer_id && isset($_SESSION['peers'][$peer_id])) {
        echo json_encode($_SESSION['peers'][$peer_id]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'peer not found']);
    }
}
?>
