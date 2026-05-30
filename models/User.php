<?php
namespace Models;

use PDO;

class User {
    private $conn;
    private $table = 'nguoi_dung';
    
    public function __construct($db) {
        $this->conn = $db;
    }
    
    // Tìm user bằng email
    public function findByEmail($email) {
        $query = "SELECT * FROM " . $this->table . " WHERE email = :email LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        
        if ($stmt->rowCount() > 0) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        return false;
    }
    
    // Tìm user bằng ID
    public function findById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        
        if ($stmt->rowCount() > 0) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        return false;
    }
    
    // Tạo user mới
    public function create($data) {
        $query = "INSERT INTO " . $this->table . " 
                  (ho_ten, email, avatar, vai_tro, trang_thai, mat_khau) 
                  VALUES (:ho_ten, :email, :avatar, :vai_tro, :trang_thai, :mat_khau)";
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':ho_ten', $data['ho_ten']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':avatar', $data['avatar']);
        $stmt->bindParam(':vai_tro', $data['vai_tro']);
        $stmt->bindParam(':trang_thai', $data['trang_thai']);
        $stmt->bindParam(':mat_khau', $data['mat_khau']);
        
        if ($stmt->execute()) {
            return $this->conn->lastInsertId();
        }
        return false;
    }
    
    // Cập nhật user (avatar)
    public function update($id, $data) {
        $query = "UPDATE " . $this->table . " SET avatar = :avatar WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':avatar', $data['avatar']);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
    
    // Kiểm tra user có tồn tại không
    public function exists($id) {
        $query = "SELECT id FROM " . $this->table . " WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }
    
    // Lấy danh sách tất cả user
    public function getAll() {
        $query = "SELECT * FROM " . $this->table . " ORDER BY id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Xóa user
    public function delete($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
?>