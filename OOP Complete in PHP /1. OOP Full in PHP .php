<?php

/**
 * 1. CLASS AND OBJECT BASICS
 * A class is a template for objects, and an object is an instance of a class
 */

class Car {
    // Properties (attributes)
    public $brand;
    public $color;
    private $mileage = 0;

    // Constructor - called when object is created
    public function __construct($brand, $color) {
        $this->brand = $brand;
        $this->color = $color;
    }

    // Method to drive the car
    public function drive($distance) {
        $this->mileage += $distance;
        return "Driving {$distance} km";
    }

    // Method to get mileage
    public function getMileage() {
        return $this->mileage;
    }
}

// Creating objects
$car1 = new Car("Toyota", "Red");
$car2 = new Car("Honda", "Blue");

// Using objects
echo $car1->drive(100);  // Outputs: Driving 100 km
echo $car1->getMileage(); // Outputs: 100

/**
 * 2. ENCAPSULATION
 * Bundling data and methods that work on that data within one unit
 */

class BankAccount {
    // Private properties - cannot be accessed directly from outside
    private $balance = 0;
    private $accountNumber;

    // Constructor
    public function __construct($accountNumber) {
        $this->accountNumber = $accountNumber;
    }

    // Public method to deposit money
    public function deposit($amount) {
        if ($amount > 0) {
            $this->balance += $amount;
            return "Deposited $amount";
        }
        return "Invalid amount";
    }

    // Public method to withdraw money
    public function withdraw($amount) {
        if ($amount <= $this->balance) {
            $this->balance -= $amount;
            return "Withdrawn $amount";
        }
        return "Insufficient funds";
    }

    // Getter method
    public function getBalance() {
        return $this->balance;
    }
}

$account = new BankAccount("1234567890");
$account->deposit(1000);
echo $account->getBalance(); // Outputs: 1000

/**
 * 3. INHERITANCE
 * Allows a class to inherit properties and methods from another class
 */

// Parent class
class Animal {
    protected $name;
    protected $age;

    public function __construct($name, $age) {
        $this->name = $name;
        $this->age = $age;
    }

    public function makeSound() {
        return "Some sound";
    }
}

// Child class inheriting from Animal
class Dog extends Animal {
    private $breed;

    public function __construct($name, $age, $breed) {
        parent::__construct($name, $age);
        $this->breed = $breed;
    }

    // Override parent's method
    public function makeSound() {
        return "Woof!";
    }

    // New method specific to Dog
    public function fetch() {
        return "{$this->name} is fetching the ball";
    }
}

$dog = new Dog("Buddy", 3, "Golden Retriever");
echo $dog->makeSound(); // Outputs: Woof!
echo $dog->fetch(); // Outputs: Buddy is fetching the ball

/**
 * 4. POLYMORPHISM
 * Ability of objects of different classes to respond to the same method call
 */

interface Shape {
    public function calculateArea();
}

class Circle implements Shape {
    private $radius;

    public function __construct($radius) {
        $this->radius = $radius;
    }

    public function calculateArea() {
        return pi() * $this->radius * $this->radius;
    }
}

class Rectangle implements Shape {
    private $width;
    private $height;

    public function __construct($width, $height) {
        $this->width = $width;
        $this->height = $height;
    }

    public function calculateArea() {
        return $this->width * $this->height;
    }
}

// Polymorphic behavior
function printArea(Shape $shape) {
    echo "Area: " . $shape->calculateArea();
}

$circle = new Circle(5);
$rectangle = new Rectangle(4, 6);

printArea($circle); // Outputs: Area: 78.539816339745
printArea($rectangle); // Outputs: Area: 24

/**
 * 5. ABSTRACTION
 * Hiding complex implementation details and showing only necessary features
 */

abstract class Database {
    abstract public function connect();
    abstract public function query($sql);
    abstract public function disconnect();

    // Common method for all databases
    public function executeQuery($sql) {
        $this->connect();
        $result = $this->query($sql);
        $this->disconnect();
        return $result;
    }
}

class MySQLDatabase extends Database {
    public function connect() {
        return "Connected to MySQL";
    }

    public function query($sql) {
        return "Executing MySQL query: $sql";
    }

    public function disconnect() {
        return "Disconnected from MySQL";
    }
}

/**
 * 6. MAGIC METHODS
 * Special methods that override PHP's default behavior
 */

class Person {
    private $data = [];

    // Magic method to set inaccessible properties
    public function __set($name, $value) {
        $this->data[$name] = $value;
    }

    // Magic method to get inaccessible properties
    public function __get($name) {
        return $this->data[$name] ?? null;
    }

    // Magic method called when object is treated as a string
    public function __toString() {
        return "Person Object";
    }
}

/**
 * 7. TRAITS
 * Reusable code that can be included in multiple classes
 */

trait Logger {
    public function log($message) {
        echo "Logging: $message";
    }
}

trait Timestamp {
    public function getTimestamp() {
        return date('Y-m-d H:i:s');
    }
}

class UserActivity {
    use Logger, Timestamp;

    public function doSomething() {
        $this->log("Action performed at " . $this->getTimestamp());
    }
}

/**
 * 8. STATIC METHODS AND PROPERTIES
 * Accessible without creating an instance of the class
 */

class MathHelper {
    public static $pi = 3.14159;

    public static function square($number) {
        return $number * $number;
    }
}

echo MathHelper::$pi; // Access static property
echo MathHelper::square(4); // Call static method

/**
 * 9. NAMESPACES
 * Way to encapsulate related classes, interfaces, functions and constants
 */

namespace MyApp\Utils;

class Helper {
    public static function formatDate($date) {
        return date('Y-m-d', strtotime($date));
    }
}

// Using the namespaced class
use MyApp\Utils\Helper;
echo Helper::formatDate('2024-01-21');

/**
 * 10. TYPE HINTING AND RETURN TYPES
 * Specifying the expected type of parameters and return values
 */

class Calculator {
    public function add(int $a, int $b): int {
        return $a + $b;
    }

    public function divide(float $a, float $b): ?float {
        if ($b === 0) {
            return null;
        }
        return $a / $b;
    }
}

/**
 * 11. FINAL KEYWORD
 * Prevents child classes from overriding methods
 */

final class Config {
    public static function getAPIKey() {
        return "your-api-key";
    }
}

// This will cause an error
// class ExtendedConfig extends Config {} // Cannot extend final class

/**
 * 12. INTERFACES AND CONTRACTS
 * Defining a contract that classes must fulfill
 */

interface PaymentGateway {
    public function processPayment(float $amount): bool;
    public function refund(float $amount): bool;
}

class PayPalGateway implements PaymentGateway {
    public function processPayment(float $amount): bool {
        // Implementation
        return true;
    }

    public function refund(float $amount): bool {
        // Implementation
        return true;
    }
}

/**
 * 13. DEPENDENCY INJECTION
 * Injecting dependencies instead of creating them inside the class
 */

class UserService {
    private $database;

    public function __construct(Database $database) {
        $this->database = $database;
    }

    public function getUser($id) {
        return $this->database->query("SELECT * FROM users WHERE id = $id");
    }
}

/**
 * 14. EXCEPTION HANDLING
 * Handling errors in OOP way
 */

class CustomException extends Exception {
    public function errorMessage() {
        return "Error on line {$this->getLine()} in {$this->getFile()}: {$this->getMessage()}";
    }
}

try {
    throw new CustomException("Something went wrong!");
} catch (CustomException $e) {
    echo $e->errorMessage();
} finally {
    echo "Cleanup code here";
}
