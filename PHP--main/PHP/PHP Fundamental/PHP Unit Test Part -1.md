<?php
// ==========================================
// Part 1: PHPUnit Testing
// ==========================================

// 1. Basic Class to Test
class Calculator {
    public function add($a, $b) {
        return $a + $b;
    }

    public function divide($a, $b) {
        if ($b === 0) {
            throw new InvalidArgumentException("Division by zero");
        }
        return $a / $b;
    }
}

// 2. PHPUnit Test Class
use PHPUnit\Framework\TestCase;

class CalculatorTest extends TestCase {
    private Calculator $calculator;

    // Setup method runs before each test
    protected function setUp(): void {
        $this->calculator = new Calculator();
    }

    // Basic test method
    public function test_it_can_add_numbers(): void {
        $result = $this->calculator->add(4, 2);
        $this->assertEquals(6, $result);
    }

    // Test with data provider
    /** @dataProvider additionProvider */
    public function test_it_can_add_various_numbers($a, $b, $expected): void {
        $result = $this->calculator->add($a, $b);
        $this->assertEquals($expected, $result);
    }

    // Data provider method
    public function additionProvider(): array {
        return [
            'adding positive numbers' => [2, 2, 4],
            'adding negative numbers' => [-1, -1, -2],
            'adding zero' => [0, 5, 5],
        ];
    }

    // Exception testing
    public function test_it_throws_exception_when_dividing_by_zero(): void {
        $this->expectException(InvalidArgumentException::class);
        $this->calculator->divide(10, 0);
    }
}

// ==========================================
// Part 2: Pest Testing
// ==========================================

// Same Calculator class as above

// Pest test file (calculator.test.php)
test('it can add numbers', function () {
    $calculator = new Calculator();
    
    $result = $calculator->add(4, 2);
    
    expect($result)->toBe(6);
});

// Group related tests
describe('Calculator', function () {
    beforeEach(function () {
        $this->calculator = new Calculator();
    });

    test('adds numbers correctly', function () {
        expect($this->calculator->add(2, 2))->toBe(4);
    });

    test('throws exception when dividing by zero', function () {
        expect(fn() => $this->calculator->divide(10, 0))
            ->toThrow(InvalidArgumentException::class);
    });
});

// Dataset testing in Pest
test('it can add various numbers')
    ->with([
        [2, 2, 4],
        [-1, -1, -2],
        [0, 5, 5],
    ])
    ->expect(fn ($a, $b, $expected) => 
        (new Calculator())->add($a, $b)
    )->toBe(fn ($a, $b, $expected) => $expected);

// Higher Order Tests
test('basic calculations')
    ->expect(['add', 'divide'])
    ->toBePublicMethods(Calculator::class);

// ==========================================
// Common Testing Patterns (Both frameworks)
// ==========================================

// 1. Mocking Example
class UserService {
    private $database;

    public function __construct($database) {
        $this->database = $database;
    }

    public function findUser($id) {
        return $this->database->query("SELECT * FROM users WHERE id = ?", [$id]);
    }
}

// PHPUnit Mock
class UserServiceTest extends TestCase {
    public function test_it_finds_user() {
        // Create mock
        $database = $this->createMock(Database::class);
        
        // Set expectations
        $database->expects($this->once())
                ->method('query')
                ->with("SELECT * FROM users WHERE id = ?", [1])
                ->willReturn(['id' => 1, 'name' => 'John']);
        
        $service = new UserService($database);
        $result = $service->findUser(1);
        
        $this->assertEquals('John', $result['name']);
    }
}

// Pest Mock
test('it finds user using mock', function () {
    $database = mock(Database::class)
        ->expect(
            query: fn() => ['id' => 1, 'name' => 'John']
        );
    
    $service = new UserService($database);
    $result = $service->findUser(1);
    
    expect($result)->toHaveKey('name', 'John');
});
