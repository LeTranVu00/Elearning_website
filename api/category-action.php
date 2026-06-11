<?php
/**
 * ============================================================================
 * FILE: api/category-action.php
 * MỤC ĐÍCH: API endpoint xử lý AJAX request cho quản lý danh mục
 * ============================================================================
 */

require_once __DIR__ . '/../core/Database.php';
require_once __DIR__ . '/../core/SessionManager.php';
require_once __DIR__ . '/../models/Course.php';

header('Content-Type: application/json');

SessionManager::start();

// Kiểm tra đăng nhập
if (!SessionManager::isLoggedIn()) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Vui lòng đăng nhập']);
    exit;
}

// Kiểm tra quyền (chỉ admin hoặc instructor)
$vai_tro = SessionManager::get('vai_tro');
if ($vai_tro !== 'admin' && $vai_tro !== 'instructor') {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Bạn không có quyền']);
    exit;
}

$conn = Database::getConnection();
$courseModel = new Course($conn);

// Lấy action từ request
$action = $_REQUEST['action'] ?? null;

try {
    switch ($action) {
        case 'create':
            $data = json_decode(file_get_contents('php://input'), true);
            $categoryName = $data['name'] ?? '';
            
            if (empty($categoryName)) {
                echo json_encode(['success' => false, 'message' => 'Tên danh mục không được rỗng']);
                break;
            }
            
            $result = $courseModel->createCategory($categoryName);
            if ($result !== false) {
                echo json_encode(['success' => true, 'message' => 'Danh mục đã được tạo', 'id' => $result]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Không thể tạo danh mục (có thể trùng tên hoặc tên quá ngắn)']);
            }
            break;

        case 'update':
            $data = json_decode(file_get_contents('php://input'), true);
            $categoryId = (int)($data['id'] ?? 0);
            $categoryName = $data['name'] ?? '';
            
            if (empty($categoryId) || empty($categoryName)) {
                echo json_encode(['success' => false, 'message' => 'Thiếu thông tin']);
                break;
            }
            
            $result = $courseModel->updateCategory($categoryId, $categoryName);
            if ($result) {
                echo json_encode(['success' => true, 'message' => 'Danh mục đã được cập nhật']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Không thể cập nhật danh mục']);
            }
            break;

        case 'delete':
            $data = json_decode(file_get_contents('php://input'), true);
            $categoryId = (int)($data['id'] ?? 0);
            
            if (empty($categoryId)) {
                echo json_encode(['success' => false, 'message' => 'ID danh mục không hợp lệ']);
                break;
            }
            
            $result = $courseModel->deleteCategory($categoryId);
            if ($result) {
                echo json_encode(['success' => true, 'message' => 'Danh mục đã được xóa']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Không thể xóa danh mục (có khóa học sử dụng)']);
            }
            break;

        case 'list':
            $categories = $courseModel->getCategories();
            echo json_encode($categories);
            break;

        default:
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Action không hợp lệ']);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Lỗi: ' . $e->getMessage()]);
}
