<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type');

require_once '../db_config.php';

switch($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        // جلب المنتجات
        $stmt = $pdo->query('SELECT * FROM products ORDER BY created_at DESC');
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
        break;

    case 'POST':
        // إضافة منتج جديد
        $data = json_decode(file_get_contents('php://input'), true);
        $sql = "INSERT INTO products (name, price, category, description, image) VALUES (?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            $data['name'],
            $data['price'],
            $data['category'],
            $data['description'],
            $data['image']
        ]);
        echo json_encode(['id' => $pdo->lastInsertId()]);
        break;

    case 'DELETE':
        // حذف منتج
        $id = $_GET['id'];
        $sql = "DELETE FROM products WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
        echo json_encode(['success' => true]);
        break;
}
?>
