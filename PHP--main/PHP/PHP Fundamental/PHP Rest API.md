# Complete PHP REST API Guide

## Table of Contents
1. [API Structure](#structure)
2. [Basic CRUD Operations](#crud)
3. [File Handling](#file-handling)
4. [Search Implementation](#search)
5. [Sorting Implementation](#sorting)
6. [Filtering Implementation](#filtering)
7. [Authentication & Authorization](#auth)
8. [Error Handling](#error-handling)
9. [Best Practices](#best-practices)

## 1. API Structure {#structure}

### Directory Structure
```plaintext
/api
├── config/
│   ├── Database.php
│   └── Config.php
├── controllers/
│   ├── UserController.php
│   └── FileController.php
├── models/
│   ├── User.php
│   └── File.php
├── middleware/
│   ├── AuthMiddleware.php
│   └── ValidationMiddleware.php
├── utils/
│   ├── Response.php
│   └── FileHandler.php
└── index.php
```

### Base Configuration
```php
// config/Config.php
class Config {
    // Database configuration
    const DB_HOST = 'localhost';
    const DB_NAME = 'api_db';
    const DB_USER = 'root';
    const DB_PASS = 'password';
    
    // API configuration
    const PAGE_SIZE = 10;
    const UPLOAD_DIR = '../uploads/';
    const ALLOWED_EXTENSIONS = ['jpg', 'png', 'pdf'];
    const MAX_FILE_SIZE = 5242880; // 5MB
}

// config/Database.php
class Database {
    private $conn;
    
    public function connect() {
        try {
            $this->conn = new PDO(
                "mysql:host=" . Config::DB_HOST . 
                ";dbname=" . Config::DB_NAME,
                Config::DB_USER,
                Config::DB_PASS
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->conn;
        } catch(PDOException $e) {
            echo "Connection Error: " . $e->getMessage();
            return null;
        }
    }
}
```

### Response Handler
```php
// utils/Response.php
class Response {
    public static function json($data, $status = 200) {
        header('Content-Type: application/json');
        http_response_code($status);
        echo json_encode($data);
        exit;
    }
    
    public static function error($message, $status = 400) {
        self::json(['error' => $message], $status);
    }
}
```

## 2. Basic CRUD Operations {#crud}

### User Model
```php
// models/User.php
class User {
    private $conn;
    private $table = 'users';
    
    public function __construct($db) {
        $this->conn = $db;
    }
    
    // Create user
    public function create($data) {
        $query = "INSERT INTO " . $this->table . "
                 (name, email, password) 
                 VALUES (:name, :email, :password)";
                 
        $stmt = $this->conn->prepare($query);
        
        // Sanitize and hash
        $data['name'] = htmlspecialchars(strip_tags($data['name']));
        $data['email'] = htmlspecialchars(strip_tags($data['email']));
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        
        // Bind values
        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':password', $data['password']);
        
        if($stmt->execute()) {
            return $this->conn->lastInsertId();
        }
        return false;
    }
    
    // Read user
    public function read($id = null) {
        $query = "SELECT id, name, email FROM " . $this->table;
        if($id) {
            $query .= " WHERE id = :id";
        }
        
        $stmt = $this->conn->prepare($query);
        
        if($id) {
            $stmt->bindParam(':id', $id);
        }
        
        $stmt->execute();
        return $id ? $stmt->fetch(PDO::FETCH_ASSOC) : 
                    $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Update user
    public function update($id, $data) {
        $query = "UPDATE " . $this->table . "
                 SET name = :name, email = :email
                 WHERE id = :id";
                 
        $stmt = $this->conn->prepare($query);
        
        // Sanitize
        $data['name'] = htmlspecialchars(strip_tags($data['name']));
        $data['email'] = htmlspecialchars(strip_tags($data['email']));
        
        // Bind values
        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':id', $id);
        
        return $stmt->execute();
    }
    
    // Delete user
    public function delete($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
```

### User Controller
```php
// controllers/UserController.php
class UserController {
    private $user;
    
    public function __construct() {
        $db = new Database();
        $this->user = new User($db->connect());
    }
    
    // Handle POST request
    public function create() {
        $data = json_decode(file_get_contents("php://input"), true);
        
        if(!$this->validateUser($data)) {
            Response::error("Invalid input data");
        }
        
        $id = $this->user->create($data);
        if($id) {
            Response::json([
                "message" => "User created successfully",
                "id" => $id
            ], 201);
        } else {
            Response::error("Failed to create user");
        }
    }
    
    // Handle GET request
    public function read($id = null) {
        $result = $this->user->read($id);
        if($result) {
            Response::json($result);
        } else {
            Response::error("User not found", 404);
        }
    }
    
    // Handle PUT request
    public function update($id) {
        $data = json_decode(file_get_contents("php://input"), true);
        
        if(!$this->validateUser($data, true)) {
            Response::error("Invalid input data");
        }
        
        if($this->user->update($id, $data)) {
            Response::json(["message" => "User updated successfully"]);
        } else {
            Response::error("Failed to update user");
        }
    }
    
    // Handle DELETE request
    public function delete($id) {
        if($this->user->delete($id)) {
            Response::json(["message" => "User deleted successfully"]);
        } else {
            Response::error("Failed to delete user");
        }
    }
    
    private function validateUser($data, $isUpdate = false) {
        $required = ['name', 'email'];
        if(!$isUpdate) {
            $required[] = 'password';
        }
        
        foreach($required as $field) {
            if(!isset($data[$field]) || empty($data[$field])) {
                return false;
            }
        }
        
        if(!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            return false;
        }
        
        return true;
    }
}
```

## 3. File Handling {#file-handling}

### File Controller
```php
// controllers/FileController.php
class FileController {
    private $uploadDir;
    
    public function __construct() {
        $this->uploadDir = Config::UPLOAD_DIR;
        if(!is_dir($this->uploadDir)) {
            mkdir($this->uploadDir, 0755, true);
        }
    }
    
    // Handle file upload
    public function upload() {
        if(!isset($_FILES['file'])) {
            Response::error("No file uploaded");
        }
        
        $file = $_FILES['file'];
        $fileName = $this->generateFileName($file['name']);
        $filePath = $this->uploadDir . $fileName;
        
        // Validate file
        if(!$this->validateFile($file)) {
            Response::error("Invalid file");
        }
        
        if(move_uploaded_file($file['tmp_name'], $filePath)) {
            Response::json([
                "message" => "File uploaded successfully",
                "file" => $fileName
            ]);
        } else {
            Response::error("Failed to upload file");
        }
    }
    
    // Handle file download
    public function download($fileName) {
        $filePath = $this->uploadDir . $fileName;
        
        if(!file_exists($filePath)) {
            Response::error("File not found", 404);
        }
        
        header('Content-Type: ' . mime_content_type($filePath));
        header('Content-Disposition: attachment; filename="' . $fileName . '"');
        readfile($filePath);
        exit;
    }
    
    private function validateFile($file) {
        $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        
        if($file['size'] > Config::MAX_FILE_SIZE) {
            return false;
        }
        
        if(!in_array($extension, Config::ALLOWED_EXTENSIONS)) {
            return false;
        }
        
        return true;
    }
    
    private function generateFileName($originalName) {
        $extension = pathinfo($originalName, PATHINFO_EXTENSION);
        return uniqid() . '.' . $extension;
    }
}
```

## 4. Search Implementation {#search}

### Search Functionality
```php
// models/User.php (add to existing class)
public function search($params) {
    $query = "SELECT id, name, email FROM " . $this->table . " WHERE 1";
    $bindParams = [];
    
    // Add search conditions
    if(isset($params['search'])) {
        $searchTerm = '%' . $params['search'] . '%';
        $query .= " AND (name LIKE :search OR email LIKE :search)";
        $bindParams[':search'] = $searchTerm;
    }
    
    // Add pagination
    $page = isset($params['page']) ? (int)$params['page'] : 1;
    $limit = Config::PAGE_SIZE;
    $offset = ($page - 1) * $limit;
    
    $query .= " LIMIT :limit OFFSET :offset";
    $bindParams[':limit'] = $limit;
    $bindParams[':offset'] = $offset;
    
    $stmt = $this->conn->prepare($query);
    
    // Bind parameters
    foreach($bindParams as $param => $value) {
        $stmt->bindValue($param, $value);
    }
    
    $stmt->execute();
    
    return [
        'data' => $stmt->fetchAll(PDO::FETCH_ASSOC),
        'page' => $page,
        'limit' => $limit
    ];
}
```

## 5. Sorting Implementation {#sorting}

### Sorting Functionality
```php
// models/User.php (add to existing class)
public function sort($params) {
    $query = "SELECT id, name, email FROM " . $this->table;
    
    // Add sorting
    if(isset($params['sort'])) {
        $allowedColumns = ['name', 'email', 'created_at'];
        $sortColumn = in_array($params['sort'], $allowedColumns) ? 
                     $params['sort'] : 'id';
        
        $sortDirection = isset($params['order']) && 
                        strtoupper($params['order']) === 'DESC' ? 
                        'DESC' : 'ASC';
        
        $query .= " ORDER BY {$sortColumn} {$sortDirection}";
    }
    
    // Add pagination
    $page = isset($params['page']) ? (int)$params['page'] : 1;
    $limit = Config::PAGE_SIZE;
    $offset = ($page - 1) * $limit;
    
    $query .= " LIMIT :limit OFFSET :offset";
    
    $stmt = $this->conn->prepare($query);
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    
    $stmt->execute();
    
    return [
        'data' => $stmt->fetchAll(PDO::FETCH_ASSOC),
        'page' => $page,
        'limit' => $limit
    ];
}
```

## 6. Filtering Implementation {#filtering}

### Filter Functionality
```php
// models/User.php (add to existing class)
public function filter($params) {
    $query = "SELECT id, name, email FROM " . $this->table . " WHERE 1";
    $bindParams = [];
    
    // Add filters
    $allowedFilters = ['name', 'email', 'created_at'];
    
    foreach($allowedFilters as $filter) {
        if(isset($params[$filter])) {
            $query .= " AND {$filter} = :{$filter}";
            $bindParams[":{$filter}"] = $params[$filter];
        }
    }
    
    // Add date range filter
    if(isset($params['date_from']) && isset($params['date_to'])) {
        $query .= " AND created_at BETWEEN :date_from AND :date_to";
        $bindParams[':date_from'] = $params['date_from'];
        $bindParams[':date_to'] = $params['date_to'];
    }
    
    // Add pagination
    $page = isset($params['page']) ? (int)$params['page'] : 1;
    $limit = Config::PAGE_SIZE;
    $offset = ($page - 1) * $limit;
    
    $query .= " LIMIT :limit OFFSET :offset";
    $bindParams[':limit'] = $limit;
    $bindParams[':offset'] = $offset;
    
    $stmt = $this->conn->prepare($query);
    
    // Bind parameters
    foreach($bindParams as $param => $value) {
        $stmt->bindValue($param, $value);
    }
    
    $stmt->execute();
    
    return [
        'data' => $stmt->fetchAll(PDO::FETCH_ASSOC),
        'page' => $page,
        'limit' => $limit
    ];
}
```
# Complete PHP REST API Guide

[Previous sections remain the same until Authentication & Authorization]

## 7. Authentication & Authorization {#auth}

### JWT Authentication
```php
// middleware/AuthMiddleware.php
class AuthMiddleware {
    private static $secretKey = 'your_secret_key_here';
    
    public static function authenticate() {
        $headers = apache_request_headers();
        
        if(!isset($headers['Authorization'])) {
            Response::error("No token provided", 401);
        }
        
        $token = str_replace('Bearer ', '', $headers['Authorization']);
        
        try {
            $decoded = JWT::decode($token, new Key(self::$secretKey, 'HS256'));
            return $decoded;
        } catch(Exception $e) {
            Response::error("Invalid token", 401);
        }
    }
    
    public static function generateToken($userId) {
        $issuedAt = time();
        $expirationTime = $issuedAt + 3600; // Valid for 1 hour
        
        $payload = [
            'iat' => $issuedAt,
            'exp' => $expirationTime,
            'userId' => $userId
        ];
        
        return JWT::encode($payload, self::$secretKey, 'HS256');
    }
}
```

### Role-Based Authorization
```php
// middleware/AuthorizationMiddleware.php
class AuthorizationMiddleware {
    private static $rolePermissions = [
        'admin' => ['create', 'read', 'update', 'delete'],
        'user' => ['read', 'update'],
        'guest' => ['read']
    ];
    
    public static function hasPermission($role, $action) {
        if(!isset(self::$rolePermissions[$role])) {
            return false;
        }
        
        return in_array($action, self::$rolePermissions[$role]);
    }
    
    public static function checkPermission($role, $action) {
        if(!self::hasPermission($role, $action)) {
            Response::error("Insufficient permissions", 403);
        }
    }
}
```

## 8. Error Handling {#error-handling}

### Global Error Handler
```php
// utils/ErrorHandler.php
class ErrorHandler {
    public static function handleException($exception) {
        $response = [
            'error' => true,
            'message' => $exception->getMessage(),
            'code' => $exception->getCode() ?: 500
        ];
        
        if(DEBUG_MODE) {
            $response['trace'] = $exception->getTrace();
        }
        
        Response::json($response, $response['code']);
    }
    
    public static function handleError($errno, $errstr, $errfile, $errline) {
        throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
    }
}

// Register error handlers
set_exception_handler([ErrorHandler::class, 'handleException']);
set_error_handler([ErrorHandler::class, 'handleError']);
```

### Custom Exceptions
```php
// utils/Exceptions.php
class ValidationException extends Exception {
    public function __construct($message = "Validation failed", $code = 400) {
        parent::__construct($message, $code);
    }
}

class NotFoundException extends Exception {
    public function __construct($message = "Resource not found", $code = 404) {
        parent::__construct($message, $code);
    }
}

class AuthenticationException extends Exception {
    public function __construct($message = "Authentication failed", $code = 401) {
        parent::__construct($message, $code);
    }
}
```

## 9. Best Practices {#best-practices}

### API Versioning
```php
// index.php
$router = new Router();

// Version 1 routes
$router->group('/api/v1', function($router) {
    $router->post('/users', 'UserController@create');
    $router->get('/users', 'UserController@read');
    $router->get('/users/:id', 'UserController@read');
    $router->put('/users/:id', 'UserController@update');
    $router->delete('/users/:id', 'UserController@delete');
});

// Version 2 routes (with new features)
$router->group('/api/v2', function($router) {
    $router->get('/users/search', 'UserController@search');
    $router->get('/users/filter', 'UserController@filter');
});
```

### Rate Limiting
```php
// middleware/RateLimitMiddleware.php
class RateLimitMiddleware {
    private static $redis;
    private static $maxRequests = 100; // per minute
    
    public static function check() {
        $ip = $_SERVER['REMOTE_ADDR'];
        $key = "rate_limit:$ip";
        
        self::$redis = new Redis();
        self::$redis->connect('localhost', 6379);
        
        $requests = self::$redis->get($key);
        
        if(!$requests) {
            self::$redis->setex($key, 60, 1);
            return true;
        }
        
        if($requests >= self::$maxRequests) {
            Response::error("Too many requests", 429);
        }
        
        self::$redis->incr($key);
        return true;
    }
}
```

### Request Validation
```php
// middleware/ValidationMiddleware.php
class ValidationMiddleware {
    public static function validate($rules) {
        $data = json_decode(file_get_contents("php://input"), true);
        $errors = [];
        
        foreach($rules as $field => $rule) {
            if(!isset($data[$field]) && strpos($rule, 'required') !== false) {
                $errors[$field] = "Field is required";
                continue;
            }
            
            if(isset($data[$field])) {
                if(strpos($rule, 'email') !== false && 
                   !filter_var($data[$field], FILTER_VALIDATE_EMAIL)) {
                    $errors[$field] = "Invalid email format";
                }
                
                if(strpos($rule, 'min:') !== false) {
                    preg_match('/min:(\d+)/', $rule, $matches);
                    $min = $matches[1];
                    if(strlen($data[$field]) < $min) {
                        $errors[$field] = "Minimum length is $min";
                    }
                }
            }
        }
        
        if(!empty($errors)) {
            Response::json(['errors' => $errors], 422);
        }
        
        return $data;
    }
}
```

### Security Headers
```php
// middleware/SecurityMiddleware.php
class SecurityMiddleware {
    public static function setHeaders() {
        header("X-Frame-Options: DENY");
        header("X-XSS-Protection: 1; mode=block");
        header("X-Content-Type-Options: nosniff");
        header("Content-Security-Policy: default-src 'self'");
        header("Strict-Transport-Security: max-age=31536000; includeSubDomains");
    }
}
```

This completes the PHP REST API Guide with all essential components for building a secure, scalable, and maintainable API.
