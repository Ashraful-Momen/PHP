1. use getter / setter : to set private_varibale value privately form other class

2. method overloading (compile time polimorphism) : function name same but function parameter will be different . 
                        funa(), funa(a), funa(a,b,c)

3. method overwriting : fun name and number of parameters have to be the same. class => 
                        class a {func a(int a )} ,class b extend a {func a(int a) {print ("hello");}}

4. (compile time polimorphism) : in class => getting error when compile the code . 
                                funa(int a ), funa(string a) .

5. overloading and overwriting use in abstruction . 


==========================================================================

<?php

// 1. GETTER/SETTER Example - Private variables accessed through methods
class BankAccount {
    private $balance;
    private $accountNumber;
    
    public function __construct($initialBalance = 0) {
        $this->balance = $initialBalance;
        $this->accountNumber = rand(100000, 999999);
    }
    
    // Getter methods
    public function getBalance() {
        return $this->balance;
    }
    
    public function getAccountNumber() {
        return $this->accountNumber;
    }
    
    // Setter methods with validation
    public function setBalance($amount) {
        if ($amount >= 0) {
            $this->balance = $amount;
            return true;
        }
        return false;
    }
    
    public function deposit($amount) {
        if ($amount > 0) {
            $this->balance += $amount;
            echo "Deposited: $" . $amount . " | New Balance: $" . $this->balance . "\n";
        }
    }
}

// 2. METHOD OVERLOADING (Simulated in PHP - PHP doesn't support true method overloading)
class Calculator {
    // PHP doesn't support method overloading directly, so we simulate it
    public function add() {
        $args = func_get_args();
        $numArgs = func_num_args();
        
        switch($numArgs) {
            case 0:
                return $this->addZero();
            case 1:
                return $this->addOne($args[0]);
            case 2:
                return $this->addTwo($args[0], $args[1]);
            case 3:
                return $this->addThree($args[0], $args[1], $args[2]);
            default:
                return $this->addMultiple($args);
        }
    }
    
    private function addZero() {
        echo "No parameters - returning 0\n";
        return 0;
    }
    
    private function addOne($a) {
        echo "Single parameter: $a\n";
        return $a;
    }
    
    private function addTwo($a, $b) {
        echo "Two parameters: $a + $b = " . ($a + $b) . "\n";
        return $a + $b;
    }
    
    private function addThree($a, $b, $c) {
        echo "Three parameters: $a + $b + $c = " . ($a + $b + $c) . "\n";
        return $a + $b + $c;
    }
    
    private function addMultiple($args) {
        $sum = array_sum($args);
        echo "Multiple parameters: " . implode(' + ', $args) . " = $sum\n";
        return $sum;
    }
}

// 3. METHOD OVERRIDING (Runtime Polymorphism)
abstract class Animal {
    protected $name;
    
    public function __construct($name) {
        $this->name = $name;
    }
    
    // Method to be overridden
    public function makeSound() {
        echo "Some generic animal sound\n";
    }
    
    public function getName() {
        return $this->name;
    }
    
    // Abstract method - must be implemented by child classes
    abstract public function getType();
}

class Dog extends Animal {
    // Method overriding - same name and parameters
    public function makeSound() {
        echo $this->name . " says: Woof! Woof!\n";
    }
    
    public function getType() {
        return "Canine";
    }
    
    // Additional method specific to Dog
    public function wagTail() {
        echo $this->name . " is wagging tail happily!\n";
    }
}

class Cat extends Animal {
    // Method overriding - same name and parameters
    public function makeSound() {
        echo $this->name . " says: Meow! Meow!\n";
    }
    
    public function getType() {
        return "Feline";
    }
    
    // Additional method specific to Cat
    public function purr() {
        echo $this->name . " is purring contentedly!\n";
    }
}

// 4. COMPILE-TIME POLYMORPHISM (Type-based method selection)
class DataProcessor {
    public function process($data) {
        if (is_int($data)) {
            return $this->processInteger($data);
        } elseif (is_string($data)) {
            return $this->processString($data);
        } elseif (is_array($data)) {
            return $this->processArray($data);
        } else {
            throw new InvalidArgumentException("Unsupported data type");
        }
    }
    
    private function processInteger($data) {
        echo "Processing integer: $data -> Result: " . ($data * 2) . "\n";
        return $data * 2;
    }
    
    private function processString($data) {
        echo "Processing string: '$data' -> Result: '" . strtoupper($data) . "'\n";
        return strtoupper($data);
    }
    
    private function processArray($data) {
        $sum = array_sum($data);
        echo "Processing array: [" . implode(', ', $data) . "] -> Sum: $sum\n";
        return $sum;
    }
}

// 5. ABSTRACTION with Overloading and Overriding
abstract class Shape {
    protected $color;
    
    public function __construct($color = "black") {
        $this->color = $color;
    }
    
    // Abstract methods - must be implemented
    abstract public function calculateArea();
    abstract public function calculatePerimeter();
    
    // Concrete method that can be overridden
    public function display() {
        echo "This is a " . $this->color . " shape\n";
    }
    
    // Getter/Setter for color
    public function getColor() {
        return $this->color;
    }
    
    public function setColor($color) {
        $this->color = $color;
    }
}

class Rectangle extends Shape {
    private $width;
    private $height;
    
    public function __construct($width, $height, $color = "blue") {
        parent::__construct($color);
        $this->width = $width;
        $this->height = $height;
    }
    
    // Implementing abstract methods
    public function calculateArea() {
        return $this->width * $this->height;
    }
    
    public function calculatePerimeter() {
        return 2 * ($this->width + $this->height);
    }
    
    // Overriding display method
    public function display() {
        echo "Rectangle: {$this->width}x{$this->height}, Color: {$this->color}\n";
        echo "Area: " . $this->calculateArea() . ", Perimeter: " . $this->calculatePerimeter() . "\n";
    }
    
    // Getters and Setters
    public function getWidth() { return $this->width; }
    public function getHeight() { return $this->height; }
    public function setWidth($width) { $this->width = $width; }
    public function setHeight($height) { $this->height = $height; }
}

class Circle extends Shape {
    private $radius;
    
    public function __construct($radius, $color = "red") {
        parent::__construct($color);
        $this->radius = $radius;
    }
    
    // Implementing abstract methods
    public function calculateArea() {
        return pi() * $this->radius * $this->radius;
    }
    
    public function calculatePerimeter() {
        return 2 * pi() * $this->radius;
    }
    
    // Overriding display method
    public function display() {
        echo "Circle: radius {$this->radius}, Color: {$this->color}\n";
        echo "Area: " . round($this->calculateArea(), 2) . ", Perimeter: " . round($this->calculatePerimeter(), 2) . "\n";
    }
    
    // Getters and Setters
    public function getRadius() { return $this->radius; }
    public function setRadius($radius) { $this->radius = $radius; }
}

// Interface for additional abstraction
interface Drawable {
    public function draw();
}

class Triangle extends Shape implements Drawable {
    private $side1, $side2, $side3;
    
    public function __construct($side1, $side2, $side3, $color = "green") {
        parent::__construct($color);
        $this->side1 = $side1;
        $this->side2 = $side2;
        $this->side3 = $side3;
    }
    
    public function calculateArea() {
        // Using Heron's formula
        $s = ($this->side1 + $this->side2 + $this->side3) / 2;
        return sqrt($s * ($s - $this->side1) * ($s - $this->side2) * ($s - $this->side3));
    }
    
    public function calculatePerimeter() {
        return $this->side1 + $this->side2 + $this->side3;
    }
    
    public function display() {
        echo "Triangle: sides {$this->side1}, {$this->side2}, {$this->side3}, Color: {$this->color}\n";
        echo "Area: " . round($this->calculateArea(), 2) . ", Perimeter: " . $this->calculatePerimeter() . "\n";
    }
    
    // Implementing interface method
    public function draw() {
        echo "Drawing a triangle with ASCII art:\n";
        echo "    /\\\n";
        echo "   /  \\\n";
        echo "  /____\\\n";
    }
}

// DEMONSTRATION
echo "=== COMPLETE OOP DEMONSTRATION ===\n\n";

// 1. Getter/Setter Demo
echo "1. GETTER/SETTER DEMO:\n";
echo "----------------------\n";
$account = new BankAccount(1000);
echo "Account Number: " . $account->getAccountNumber() . "\n";
echo "Initial Balance: $" . $account->getBalance() . "\n";
$account->deposit(500);
$account->setBalance(2000);
echo "Updated Balance: $" . $account->getBalance() . "\n\n";

// 2. Method Overloading Demo
echo "2. METHOD OVERLOADING DEMO:\n";
echo "---------------------------\n";
$calc = new Calculator();
$calc->add();
$calc->add(5);
$calc->add(10, 20);
$calc->add(1, 2, 3);
$calc->add(1, 2, 3, 4, 5);
echo "\n";

// 3. Method Overriding Demo
echo "3. METHOD OVERRIDING DEMO:\n";
echo "--------------------------\n";
$dog = new Dog("Buddy");
$cat = new Cat("Whiskers");

$animals = [$dog, $cat];
foreach ($animals as $animal) {
    echo "Animal: " . $animal->getName() . " (Type: " . $animal->getType() . ")\n";
    $animal->makeSound(); // Polymorphic call
}
$dog->wagTail();
$cat->purr();
echo "\n";

// 4. Compile-time Polymorphism Demo
echo "4. COMPILE-TIME POLYMORPHISM DEMO:\n";
echo "----------------------------------\n";
$processor = new DataProcessor();
$processor->process(42);
$processor->process("hello world");
$processor->process([1, 2, 3, 4, 5]);
echo "\n";

// 5. Abstraction with Overloading and Overriding Demo
echo "5. ABSTRACTION DEMO:\n";
echo "--------------------\n";
$rectangle = new Rectangle(10, 5, "blue");
$circle = new Circle(7, "red");
$triangle = new Triangle(3, 4, 5, "green");

$shapes = [$rectangle, $circle, $triangle];
foreach ($shapes as $shape) {
    $shape->display(); // Polymorphic call
    if ($shape instanceof Drawable) {
        $shape->draw();
    }
    echo "---\n";
}

// Demonstrating getter/setter with shapes
echo "Changing rectangle color:\n";
echo "Original color: " . $rectangle->getColor() . "\n";
$rectangle->setColor("purple");
echo "New color: " . $rectangle->getColor() . "\n";
$rectangle->display();

echo "\n=== END OF DEMONSTRATION ===\n";

?>
