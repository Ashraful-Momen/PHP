<?php

// 1. SINGLETON PATTERN
// Real-world example: Database Connection
class Database {
    // Store the single instance of the class
    private static $instance = null;
    
    // Store the database connection
    private $connection;
    
    // Make constructor private so no one can create new instance directly
    private function __construct() {
        $this->connection = "Connected to MySQL";
    }
    
    // This is how we get the single instance
    public static function getInstance() {
        // If no instance exists, create one
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    // Example method to run a query
    public function query($sql) {
        return "Running query: " . $sql;
    }
}

// Usage Example:
$db = Database::getInstance();
echo $db->query("SELECT * FROM users");

// -------------------------------

// 2. FACTORY PATTERN
// Real-world example: Social Media Post Creator

// Step 1: Create an interface for all posts
interface SocialMediaPost {
    public function create();
}

// Step 2: Create concrete classes for different types of posts
class FacebookPost implements SocialMediaPost {
    public function create() {
        return "Created a Facebook post";
    }
}

class TwitterPost implements SocialMediaPost {
    public function create() {
        return "Created a Tweet";
    }
}

// Step 3: Create the factory class
class SocialMediaFactory {
    public function createPost($type) {
        // Create different posts based on type
        switch ($type) {
            case 'facebook':
                return new FacebookPost();
            case 'twitter':
                return new TwitterPost();
            default:
                throw new Exception("Invalid post type");
        }
    }
}

// Usage Example:
$factory = new SocialMediaFactory();
$facebookPost = $factory->createPost('facebook');
echo $facebookPost->create();

// -------------------------------

// 3. BUILDER PATTERN
// Real-world example: Pizza Order System

class Pizza {
    public $size;
    public $cheese;
    public $toppings = [];
}

class PizzaBuilder {
    private $pizza;
    
    public function __construct() {
        // Create new pizza object
        $this->pizza = new Pizza();
    }
    
    public function setSize($size) {
        // Set pizza size
        $this->pizza->size = $size;
        return $this;
    }
    
    public function addCheese($cheese) {
        // Add cheese type
        $this->pizza->cheese = $cheese;
        return $this;
    }
    
    public function addTopping($topping) {
        // Add a topping
        $this->pizza->toppings[] = $topping;
        return $this;
    }
    
    public function build() {
        // Return the final pizza
        return $this->pizza;
    }
}

// Usage Example:
$pizza = (new PizzaBuilder())
    ->setSize('large')
    ->addCheese('mozzarella')
    ->addTopping('mushrooms')
    ->addTopping('pepperoni')
    ->build();

// -------------------------------

// 4. ADAPTER PATTERN
// Real-world example: Payment System Integration

// Old payment system
class OldPaymentSystem {
    public function processPayment($amount) {
        return "Processing payment of $amount using old system";
    }
}

// New payment interface
interface NewPaymentInterface {
    public function processNewPayment($amount, $currency);
}

// Adapter to make old system work with new interface
class PaymentAdapter implements NewPaymentInterface {
    private $oldSystem;
    
    public function __construct(OldPaymentSystem $oldSystem) {
        $this->oldSystem = $oldSystem;
    }
    
    public function processNewPayment($amount, $currency) {
        // Convert new format to old format and process
        $convertedAmount = $this->convertCurrency($amount, $currency);
        return $this->oldSystem->processPayment($convertedAmount);
    }
    
    private function convertCurrency($amount, $currency) {
        // Simple conversion example
        return $amount * 1.1;
    }
}

// Usage Example:
$oldSystem = new OldPaymentSystem();
$adapter = new PaymentAdapter($oldSystem);
echo $adapter->processNewPayment(100, 'USD');

// -------------------------------

// 5. OBSERVER PATTERN
// Real-world example: Newsletter System

// Step 1: Create subscriber interface
interface Subscriber {
    public function update($message);
}

// Step 2: Create concrete subscriber
class EmailSubscriber implements Subscriber {
    private $email;
    
    public function __construct($email) {
        $this->email = $email;
    }
    
    public function update($message) {
        return "Sending email to {$this->email}: {$message}";
    }
}

// Step 3: Create newsletter class
class Newsletter {
    private $subscribers = [];
    
    public function subscribe(Subscriber $subscriber) {
        $this->subscribers[] = $subscriber;
    }
    
    public function notify($message) {
        foreach ($this->subscribers as $subscriber) {
            echo $subscriber->update($message);
        }
    }
}

// Usage Example:
$newsletter = new Newsletter();
$subscriber1 = new EmailSubscriber("user1@example.com");
$subscriber2 = new EmailSubscriber("user2@example.com");

$newsletter->subscribe($subscriber1);
$newsletter->subscribe($subscriber2);
$newsletter->notify("New article published!");

// -------------------------------

// 6. STRATEGY PATTERN
// Real-world example: Shipping Calculator

// Step 1: Create strategy interface
interface ShippingStrategy {
    public function calculate($package);
}

// Step 2: Create concrete strategies
class FedExStrategy implements ShippingStrategy {
    public function calculate($package) {
        return "FedEx shipping cost: $25";
    }
}

class UPSStrategy implements ShippingStrategy {
    public function calculate($package) {
        return "UPS shipping cost: $20";
    }
}

// Step 3: Create context class
class ShippingCalculator {
    private $strategy;
    
    public function setStrategy(ShippingStrategy $strategy) {
        $this->strategy = $strategy;
    }
    
    public function calculate($package) {
        return $this->strategy->calculate($package);
    }
}

// Usage Example:
$calculator = new ShippingCalculator();
$calculator->setStrategy(new FedExStrategy());
echo $calculator->calculate("My Package");

// -------------------------------

// 7. CHAIN OF RESPONSIBILITY
// Real-world example: Support Ticket System

abstract class SupportHandler {
    protected $nextHandler;
    
    public function setNext($handler) {
        $this->nextHandler = $handler;
        return $handler;
    }
    
    public function handle($ticket) {
        if ($this->nextHandler) {
            return $this->nextHandler->handle($ticket);
        }
        return null;
    }
}

class TechnicalSupport extends SupportHandler {
    public function handle($ticket) {
        if ($ticket['type'] === 'technical') {
            return "Technical support handling ticket";
        }
        return parent::handle($ticket);
    }
}

class BillingSupport extends SupportHandler {
    public function handle($ticket) {
        if ($ticket['type'] === 'billing') {
            return "Billing support handling ticket";
        }
        return parent::handle($ticket);
    }
}

// Usage Example:
$technical = new TechnicalSupport();
$billing = new BillingSupport();

$technical->setNext($billing);

$ticket = ['type' => 'technical'];
echo $technical->handle($ticket);
