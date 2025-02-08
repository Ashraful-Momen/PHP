<?php
// Required dependencies
require 'vendor/autoload.php';

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class ProductAPI {
    private $db;
    private $client;
    private $baseUrl = 'http://your-api-domain.com/api';
    
    // Constructor - Initialize database connection and Guzzle client
    public function __construct() {
        // Database connection
        $this->db = new PDO(
            "mysql:host=localhost;dbname=your_database",
            "username",
            "password",
            array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)
        );
        
        // Initialize Guzzle client
        $this->client = new Client([
            'base_uri' => $this->baseUrl,
            'timeout'  => 30.0,
        ]);
    }
    
    // Create - Add new product with image
    public function createProduct($data) {
        try {
            // Start transaction
            $this->db->beginTransaction();
            
            // Handle image upload
            $imagePath = $this->handleImageUpload($_FILES['image']);
            
            // Prepare SQL query
            $sql = "INSERT INTO products (name, description, price, image_path, created_at) 
                   VALUES (:name, :description, :price, :image_path, NOW())";
            
            $stmt = $this->db->prepare($sql);
            
            // Bind parameters
            $stmt->bindParam(':name', $data['name']);
            $stmt->bindParam(':description', $data['description']);
            $stmt->bindParam(':price', $data['price']);
            $stmt->bindParam(':image_path', $imagePath);
            
            // Execute query
            $stmt->execute();
            
            // Commit transaction
            $this->db->commit();
            
            return ['status' => 'success', 'message' => 'Product created successfully'];
            
        } catch (Exception $e) {
            // Rollback transaction on error
            $this->db->rollBack();
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }
    
    // Image upload handler
    private function handleImageUpload($file) {
        // Validate image
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($file['type'], $allowedTypes)) {
            throw new Exception('Invalid image type');
        }
        
        // Generate unique filename
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = uniqid() . '.' . $extension;
        $uploadPath = 'uploads/' . $filename;
        
        // Move uploaded file
        if (!move_uploaded_file($file['tmp_name'], $uploadPath)) {
            throw new Exception('Failed to upload image');
        }
        
        return $uploadPath;
    }
    
    // Read - Get products with pagination, sorting, and filtering
    public function getProducts($page = 1, $limit = 10, $sort = 'created_at', $order = 'DESC', $filters = []) {
        try {
            // Calculate offset for pagination
            $offset = ($page - 1) * $limit;
            
            // Base query
            $sql = "SELECT * FROM products WHERE 1=1";
            $params = [];
            
            // Apply filters
            if (!empty($filters)) {
                foreach ($filters as $field => $value) {
                    $sql .= " AND $field LIKE :$field";
                    $params[":$field"] = "%$value%";
                }
            }
            
            // Add sorting
            $sql .= " ORDER BY $sort $order";
            
            // Add pagination
            $sql .= " LIMIT :limit OFFSET :offset";
            
            // Prepare and execute query
            $stmt = $this->db->prepare($sql);
            
            // Bind parameters
            foreach ($params as $key => $value) {
                $stmt->bindValue($key, $value);
            }
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
            
            $stmt->execute();
            
            // Get total count for pagination
            $countSql = "SELECT COUNT(*) FROM products WHERE 1=1";
            if (!empty($filters)) {
                foreach ($filters as $field => $value) {
                    $countSql .= " AND $field LIKE :$field";
                }
            }
            $countStmt = $this->db->prepare($countSql);
            foreach ($params as $key => $value) {
                $countStmt->bindValue($key, $value);
            }
            $countStmt->execute();
            $totalCount = $countStmt->fetchColumn();
            
            return [
                'status' => 'success',
                'data' => $stmt->fetchAll(PDO::FETCH_ASSOC),
                'pagination' => [
                    'current_page' => $page,
                    'per_page' => $limit,
                    'total_items' => $totalCount,
                    'total_pages' => ceil($totalCount / $limit)
                ]
            ];
            
        } catch (Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }
    
    // Search products
    public function searchProducts($query) {
        try {
            $sql = "SELECT * FROM products 
                   WHERE name LIKE :query 
                   OR description LIKE :query";
            
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':query', "%$query%");
            $stmt->execute();
            
            return [
                'status' => 'success',
                'data' => $stmt->fetchAll(PDO::FETCH_ASSOC)
            ];
            
        } catch (Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }
    
    // Update product
    public function updateProduct($id, $data) {
        try {
            $this->db->beginTransaction();
            
            // Handle image upload if new image is provided
            $imagePath = null;
            if (isset($_FILES['image'])) {
                $imagePath = $this->handleImageUpload($_FILES['image']);
            }
            
            // Prepare update query
            $sql = "UPDATE products SET 
                   name = :name,
                   description = :description,
                   price = :price";
            
            // Add image path to update if new image is uploaded
            if ($imagePath) {
                $sql .= ", image_path = :image_path";
            }
            
            $sql .= " WHERE id = :id";
            
            $stmt = $this->db->prepare($sql);
            
            // Bind parameters
            $stmt->bindParam(':name', $data['name']);
            $stmt->bindParam(':description', $data['description']);
            $stmt->bindParam(':price', $data['price']);
            $stmt->bindParam(':id', $id);
            
            if ($imagePath) {
                $stmt->bindParam(':image_path', $imagePath);
            }
            
            $stmt->execute();
            $this->db->commit();
            
            return ['status' => 'success', 'message' => 'Product updated successfully'];
            
        } catch (Exception $e) {
            $this->db->rollBack();
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }
    
    // Delete product
    public function deleteProduct($id) {
        try {
            // Get image path before deleting
            $stmt = $this->db->prepare("SELECT image_path FROM products WHERE id = :id");
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $product = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // Delete from database
            $stmt = $this->db->prepare("DELETE FROM products WHERE id = :id");
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            
            // Delete image file if exists
            if ($product && $product['image_path']) {
                if (file_exists($product['image_path'])) {
                    unlink($product['image_path']);
                }
            }
            
            return ['status' => 'success', 'message' => 'Product deleted successfully'];
            
        } catch (Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }
    
    // Example of using Guzzle to make external API requests
    public function makeExternalRequest($endpoint, $method = 'GET', $data = []) {
        try {
            $response = $this->client->request($method, $endpoint, [
                'json' => $data
            ]);
            
            return [
                'status' => 'success',
                'data' => json_decode($response->getBody()->getContents(), true)
            ];
            
        } catch (RequestException $e) {
            return [
                'status' => 'error',
                'message' => $e->getMessage()
            ];
        }
    }
}

// Usage example
$api = new ProductAPI();

// Create product example
$productData = [
    'name' => 'Test Product',
    'description' => 'Test Description',
    'price' => 99.99
];
// $result = $api->createProduct($productData);

// Get products with pagination, sorting, and filtering
$filters = ['name' => 'test'];
$products = $api->getProducts(
    page: 1,
    limit: 10,
    sort: 'price',
    order: 'DESC',
    filters: $filters
);

// Search products
$searchResults = $api->searchProducts('test');

// Update product
$updateData = [
    'name' => 'Updated Product',
    'description' => 'Updated Description',
    'price' => 149.99
];
// $updateResult = $api->updateProduct(1, $updateData);

// Delete product
// $deleteResult = $api->deleteProduct(1);

// Make external API request using Guzzle
$externalData = $api->makeExternalRequest('/external-endpoint');
