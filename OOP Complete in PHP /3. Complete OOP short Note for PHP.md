# PHP OOP Complete Concepts - Simple Notes

## 1. CLASS & OBJECT

**Class**: Blueprint/Template to create objects
```php
class Car { public $color; }  // Class definition
```

**Object**: Instance of a class
```php
$myCar = new Car();  // Object creation
```

**Key Note**: Class is like a cookie cutter, Object is the actual cookie

---

## 2. DYNAMIC vs STATIC OBJECT

**Dynamic Object**: Created at runtime using `new` keyword
```php
$car = new Car();  // Memory allocated during script execution
```

**Static Object**: Properties/methods accessed without creating object
```php
Car::$staticVar;  // Access static property directly
```

**Key Note**: Dynamic = create instance first, Static = use class directly

---

## 3. INHERITANCE

**Single Inheritance**: One child, one parent
```php
class Dog extends Animal { }  // Dog inherits from Animal
```

**Multilevel Inheritance**: Chain of inheritance
```php
class Animal { } → class Dog extends Animal { } → class Puppy extends Dog { }
```

**Multiple Inheritance**: Not directly supported (use traits/interfaces)
```php
// Not allowed: class Dog extends Animal, Pet { }
```

**Key Note**: Child gets all parent properties. PHP = single inheritance + traits

---

## 4. OVERLOADING vs OVERRIDING

**Method Overriding**: Same method name, different implementation
```php
class Parent { function speak() { echo "parent"; } }
class Child extends Parent { function speak() { echo "child"; } }  // Override
```

**Property Overloading**: Dynamic properties using magic methods
```php
function __get($name) { }  // Dynamic property access
```

**Key Note**: PHP doesn't support method overloading like Java. Use overriding + magic methods

---

## 5. INTERFACE

**Contract that classes must follow**
```php
interface Drawable { public function draw(); }  // Interface
class Circle implements Drawable { public function draw() { } }  // Must implement
```

**Multiple Interfaces**:
```php
class MyClass implements Interface1, Interface2 { }
```

**Key Note**: Interface = what to do, Class = how to do. Can implement multiple

---

## 6. ABSTRACT CLASS

**Abstract Class**: Cannot create object, can have abstract methods
```php
abstract class Shape { abstract public function draw(); }  // Cannot: new Shape()
class Circle extends Shape { public function draw() { } }   // Must implement
```

**Key Note**: Abstract class = incomplete class. Child must complete abstract methods

---

## 7. TRAIT

**Reusable code blocks that can be included in classes**
```php
trait Loggable { public function log($msg) { echo $msg; } }
class User { use Loggable; }  // Include trait
```

**Multiple Traits**:
```php
class MyClass { use Trait1, Trait2; }
```

**Key Note**: Trait = copy-paste code into class. Solves multiple inheritance problem

---

## 8. ACCESS MODIFIERS

**Public**: Accessible everywhere
```php
public $age;  // Can access: $obj->age
```

**Protected**: Same class + child classes
```php
protected $name;  // Only parent and child can access
```

**Private**: Only within same class
```php
private $secret;  // Only this class can access
```

**Key Note**: Public = everyone, Protected = family only, Private = only me

---

## 9. STATIC KEYWORD

**Static Property**: Shared by all objects
```php
static $count = 0;  // Access: ClassName::$count
```

**Static Method**: Called without creating object
```php
static function display() { }  // Call: ClassName::display()
```

**Key Note**: Static = belongs to class, not object. Use :: to access

---

## 10. MAGIC METHODS

**Constructor/Destructor**:
```php
function __construct() { }  // Called when object created
function __destruct() { }   // Called when object destroyed
```

**Property Access**:
```php
function __get($name) { }   // Dynamic property get
function __set($name, $value) { }  // Dynamic property set
```

**Key Note**: Magic methods start with __ and handle special events

---

## 11. DIFFERENCES

### Interface vs Abstract vs Trait

| Feature | Interface | Abstract Class | Trait |
|---------|-----------|----------------|-------|
| **Purpose** | Contract/Rules | Partial implementation | Code reuse |
| **Methods** | Only declarations | Can have concrete methods | Complete methods |
| **Properties** | Constants only | Can have properties | Can have properties |
| **Inheritance** | Multiple allowed | Single only | Multiple allowed |
| **Instantiation** | Cannot create object | Cannot create object | Cannot use alone |
| **Example** | `implements Drawable` | `extends Shape` | `use Loggable` |

```php
// Interface - Rules to follow
interface Flyable { public function fly(); }

// Abstract - Partial class
abstract class Bird { abstract function fly(); public function eat() { } }

// Trait - Reusable code
trait Singable { public function sing() { echo "singing"; } }
```

### Access Modifiers Differences

| Modifier | Same Class | Child Class | Outside Class | Package |
|----------|------------|-------------|---------------|---------|
| **public** | ✅ | ✅ | ✅ | ✅ |
| **protected** | ✅ | ✅ | ❌ | ❌ |
| **private** | ✅ | ❌ | ❌ | ❌ |

```php
class Parent {
    public $pub = "everyone";      // Accessible everywhere
    protected $prot = "family";    // Only parent and child
    private $priv = "only me";     // Only this class
}
```

---

## 12. VISIBILITY & SCOPE

**Global Scope**: Variables outside class
```php
$global = "I'm global";  // Access anywhere with global keyword
```

**Class Scope**: Properties and methods within class
```php
$this->property;  // Current object
self::$static;    // Current class static
parent::method(); // Parent class method
```

**Key Note**: $this = current object, self = current class, parent = parent class

---

## 13. NAMESPACES

**Organize classes to avoid naming conflicts**
```php
namespace MyProject\Models;
class User { }  // Full name: MyProject\Models\User
```

**Using namespaces**:
```php
use MyProject\Models\User;  // Import
$user = new User();         // Use imported class
```

**Key Note**: Namespace = folder structure for classes. Prevents name conflicts

---

## 14. AUTOLOADING

**Automatically load class files when needed**
```php
spl_autoload_register(function($class) {
    require_once $class . '.php';  // Auto-load class files
});
```

**Key Note**: No need to manually include class files. PSR-4 standard recommended

---

## 15. QUICK REFERENCE

| Concept | Syntax | Key Point |
|---------|--------|-----------|
| **Class** | `class Car { }` | Blueprint for objects |
| **Object** | `$car = new Car();` | Instance of class |
| **Inheritance** | `extends Parent` | Child gets parent features |
| **Interface** | `implements Interface` | Contract to follow |
| **Abstract** | `abstract class` | Incomplete class |
| **Trait** | `use Trait` | Reusable code blocks |
| **Public** | `public $var` | Everyone can access |
| **Protected** | `protected $var` | Family only |
| **Private** | `private $var` | Only same class |
| **Static** | `static $var` | Belongs to class |
| **Constructor** | `__construct()` | Object creation |
| **Namespace** | `namespace Name` | Organize classes |

---

## 16. BEST PRACTICES

- Use **PascalCase** for class names: `UserProfile`
- Use **camelCase** for methods: `getUserName()`
- Use **snake_case** for properties: `$user_name`
- Always use **visibility modifiers** (public/protected/private)
- Use **type hints** for better code: `function setAge(int $age)`
- Follow **PSR standards** for consistency

**Key Note**: Consistent naming and PSR standards make code readable and maintainable
