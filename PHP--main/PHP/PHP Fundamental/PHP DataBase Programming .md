<?php
// ==========================================
// Part 1: Basic Database Connection
// ==========================================

// 1.1 PDO Connection
class DatabaseConnection {
    private static $instance = null;
    private $conn;
    
    private function __construct() {
        try {
            $this->conn = new PDO(
                "mysql:host=localhost;dbname=myapp",
                "username",
                "password",
                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
            );
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }
    
    // Singleton pattern
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    public function getConnection() {
        return $this->conn;
    }
}

// Usage
$db = DatabaseConnection::getInstance()->getConnection();

// ==========================================
// Part 2: Basic CRUD Operations
// ==========================================

class UserRepository {
    private $db;
    
    public function __construct() {
        $this->db = DatabaseConnection::getInstance()->getConnection();
    }
    
    // Create
    public function create(array $data): int {
        $sql = "INSERT INTO users (name, email, created_at) VALUES (:name, :email, NOW())";
        $stmt = $this->db->prepare($sql);
        
        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':email', $data['email']);
        
        $stmt->execute();
        return $this->db->lastInsertId();
    }
    
    // Read
    public function find(int $id): ?array {
        $sql = "SELECT * FROM users WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }
    
    // Update
    public function update(int $id, array $data): bool {
        $sql = "UPDATE users SET name = :name, email = :email WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        
        return $stmt->execute([
            ':id' => $id,
            ':name' => $data['name'],
            ':email' => $data['email']
        ]);
    }
    
    // Delete
    public function delete(int $id): bool {
        $sql = "DELETE FROM users WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
}

// ==========================================
// Part 3: Advanced Queries
// ==========================================

class AdvancedQueries {
    private $db;
    
    public function __construct() {
        $this->db = DatabaseConnection::getInstance()->getConnection();
    }
    
    // Join example
    public function getUsersWithOrders(): array {
        $sql = "
            SELECT u.*, COUNT(o.id) as order_count 
            FROM users u 
            LEFT JOIN orders o ON u.id = o.user_id 
            GROUP BY u.id
        ";
        
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Transaction example
    public function createOrderWithItems(array $orderData, array $items): bool {
        try {
            $this->db->beginTransaction();
            
            // Create order
            $stmt = $this->db->prepare("
                INSERT INTO orders (user_id, total_amount) 
                VALUES (:user_id, :total)
            ");
            $stmt->execute([
                ':user_id' => $orderData['user_id'],
                ':total' => $orderData['total']
            ]);
            
            $orderId = $this->db->lastInsertId();
            
            // Create order items
            $itemStmt = $this->db->prepare("
                INSERT INTO order_items (order_id, product_id, quantity) 
                VALUES (:order_id, :product_id, :quantity)
            ");
            
            foreach ($items as $item) {
                $itemStmt->execute([
                    ':order_id' => $orderId,
                    ':product_id' => $item['product_id'],
                    ':quantity' => $item['quantity']
                ]);
            }
            
            $this->db->commit();
            return true;
            
        } catch (Exception $e) {
            $this->db->rollBack();
            throw $e;
        }
    }
}

// ==========================================
// Part 4: Query Builder Pattern
// ==========================================

class QueryBuilder {
    private $table;
    private $where = [];
    private $orderBy = [];
    private $limit = null;
    private $offset = null;
    private $db;
    
    public function __construct(string $table) {
        $this->table = $table;
        $this->db = DatabaseConnection::getInstance()->getConnection();
    }
    
    public function where(string $column, string $operator, $value): self {
        $this->where[] = [$column, $operator, $value];
        return $this;
    }
    
    public function orderBy(string $column, string $direction = 'ASC'): self {
        $this->orderBy[] = [$column, strtoupper($direction)];
        return $this;
    }
    
    public function limit(int $limit): self {
        $this->limit = $limit;
        return $this;
    }
    
    public function offset(int $offset): self {
        $this->offset = $offset;
        return $this;
    }
    
    public function get(): array {
        $sql = $this->buildQuery();
        $stmt = $this->db->prepare($sql);
        
        // Bind where values
        $i = 1;
        foreach ($this->where as $where) {
            $stmt->bindValue($i++, $where[2]);
        }
        
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    private function buildQuery(): string {
        $sql = "SELECT * FROM {$this->table}";
        
        if (!empty($this->where)) {
            $sql .= " WHERE ";
            $conditions = [];
            foreach ($this->where as $where) {
                $conditions[] = "{$where[0]} {$where[1]} ?";
            }
            $sql .= implode(" AND ", $conditions);
        }
        
        if (!empty($this->orderBy)) {
            $sql .= " ORDER BY ";
            $orders = [];
            foreach ($this->orderBy as $order) {
                $orders[] = "{$order[0]} {$order[1]}";
            }
            $sql .= implode(", ", $orders);
        }
        
        if ($this->limit !== null) {
            $sql .= " LIMIT " . $this->limit;
            if ($this->offset !== null) {
                $sql .= " OFFSET " . $this->offset;
            }
        }
        
        return $sql;
    }
}

// ==========================================
// Part 5: Model Implementation
// ==========================================

abstract class Model {
    protected static $table;
    protected static $fillable = [];
    private $attributes = [];
    
    public function __construct(array $attributes = []) {
        $this->fill($attributes);
    }
    
    public function fill(array $attributes): void {
        foreach ($attributes as $key => $value) {
            if (in_array($key, static::$fillable)) {
                $this->attributes[$key] = $value;
            }
        }
    }
    
    public function save(): bool {
        $db = DatabaseConnection::getInstance()->getConnection();
        
        if (isset($this->attributes['id'])) {
            // Update
            $sql = "UPDATE " . static::$table . " SET ";
            $sets = [];
            $values = [];
            
            foreach ($this->attributes as $key => $value) {
                if ($key === 'id') continue;
                $sets[] = "$key = ?";
                $values[] = $value;
            }
            
            $sql .= implode(", ", $sets);
            $sql .= " WHERE id = ?";
            $values[] = $this->attributes['id'];
            
            $stmt = $db->prepare($sql);
            return $stmt->execute($values);
        } else {
            // Insert
            $columns = implode(", ", array_keys($this->attributes));
            $values = array_values($this->attributes);
            $placeholders = str_repeat("?, ", count($values) - 1) . "?";
            
            $sql = "INSERT INTO " . static::$table . " ($columns) VALUES ($placeholders)";
            $stmt = $db->prepare($sql);
            
            if ($stmt->execute($values)) {
                $this->attributes['id'] = $db->lastInsertId();
                return true;
            }
            return false;
        }
    }
    
    public static function find($id) {
        $db = DatabaseConnection::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT * FROM " . static::$table . " WHERE id = ?");
        $stmt->execute([$id]);
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            return new static($result);
        }
        return null;
    }
}

// Example Model
class User extends Model {
    protected static $table = 'users';
    protected static $fillable = ['name', 'email'];
}

// ==========================================
// Part 6: Usage Examples
// ==========================================

// Basic CRUD
$userRepo = new UserRepository();

// Create
$userId = $userRepo->create([
    'name' => 'John Doe',
    'email' => 'john@example.com'
]);

// Read
$user = $userRepo->find($userId);

// Update
$userRepo->update($userId, [
    'name' => 'John Updated',
    'email' => 'john.updated@example.com'
]);

// Delete
$userRepo->delete($userId);

// Query Builder Usage
$users = (new QueryBuilder('users'))
    ->where('age', '>', 18)
    ->orderBy('name', 'ASC')
    ->limit(10)
    ->offset(0)
    ->get();

// Model Usage
$user = new User([
    'name' => 'Jane Doe',
    'email' => 'jane@example.com'
]);
$user->save();

// Find user
$foundUser = User::find(1);
