<?php
// Previous Calculator and UserService examples remain the same...

// ==========================================
// Part 3: API Testing
// ==========================================

// 1. API Controller Example
class UserApiController {
    private $userService;

    public function __construct(UserService $userService) {
        $this->userService = $userService;
    }

    public function store(array $request) {
        // Validate request
        if (empty($request['name']) || empty($request['email'])) {
            return [
                'status' => 422,
                'errors' => ['All fields are required']
            ];
        }

        // Process request
        return [
            'status' => 201,
            'data' => $this->userService->createUser($request)
        ];
    }

    public function show($id) {
        $user = $this->userService->findUser($id);
        
        if (!$user) {
            return [
                'status' => 404,
                'errors' => ['User not found']
            ];
        }

        return [
            'status' => 200,
            'data' => $user
        ];
    }
}

// 2. PHPUnit API Tests
class UserApiTest extends TestCase {
    private $userService;
    private $controller;

    protected function setUp(): void {
        parent::setUp();
        $this->userService = $this->createMock(UserService::class);
        $this->controller = new UserApiController($this->userService);
    }

    public function test_it_creates_user_successfully() {
        // Arrange
        $userData = [
            'name' => 'John Doe',
            'email' => 'john@example.com'
        ];

        $this->userService
            ->expects($this->once())
            ->method('createUser')
            ->with($userData)
            ->willReturn(['id' => 1] + $userData);

        // Act
        $response = $this->controller->store($userData);

        // Assert
        $this->assertEquals(201, $response['status']);
        $this->assertArrayHasKey('data', $response);
        $this->assertEquals('John Doe', $response['data']['name']);
    }

    public function test_it_validates_required_fields() {
        $response = $this->controller->store(['name' => 'John Doe']);
        
        $this->assertEquals(422, $response['status']);
        $this->assertArrayHasKey('errors', $response);
    }

    public function test_it_returns_404_for_non_existent_user() {
        $this->userService
            ->method('findUser')
            ->willReturn(null);

        $response = $this->controller->show(999);
        
        $this->assertEquals(404, $response['status']);
    }
}

// 3. Pest API Tests
describe('UserApi', function () {
    beforeEach(function () {
        $this->userService = mock(UserService::class);
        $this->controller = new UserApiController($this->userService);
    });

    test('creates user successfully', function () {
        // Arrange
        $userData = [
            'name' => 'John Doe',
            'email' => 'john@example.com'
        ];

        $this->userService
            ->expect(
                createUser: fn() => ['id' => 1] + $userData
            );

        // Act
        $response = $this->controller->store($userData);

        // Assert
        expect($response)
            ->toHaveKey('status', 201)
            ->and($response['data'])
            ->toHaveKey('name', 'John Doe');
    });

    test('validates required fields', function () {
        $response = $this->controller->store(['name' => 'John Doe']);
        
        expect($response)
            ->toHaveKey('status', 422)
            ->toHaveKey('errors');
    });
});

// 4. Laravel API Testing Example
class UserApiTestLaravel extends TestCase {
    public function test_create_user_endpoint() {
        // Make actual HTTP request to your API
        $response = $this->postJson('/api/users', [
            'name' => 'John Doe',
            'email' => 'john@example.com'
        ]);

        $response
            ->assertStatus(201)
            ->assertJson([
                'data' => [
                    'name' => 'John Doe',
                    'email' => 'john@example.com'
                ]
            ]);
    }

    public function test_get_user_endpoint() {
        // Test GET request
        $response = $this->getJson('/api/users/1');

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'email'
                ]
            ]);
    }
}

// 5. Pest Laravel API Testing
test('create user endpoint', function () {
    $response = postJson('/api/users', [
        'name' => 'John Doe',
        'email' => 'john@example.com'
    ]);

    $response
        ->assertStatus(201)
        ->assertJson(fn (AssertableJson $json) =>
            $json->has('data')
                 ->where('data.name', 'John Doe')
                 ->etc()
        );
});

test('get user endpoint', function () {
    $response = getJson('/api/users/1');

    $response
        ->assertOk()
        ->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'email'
            ]
        ]);
});

// 6. Testing External APIs
class ExternalApiTest extends TestCase {
    public function test_external_api_call() {
        // Using Guzzle HTTP client
        $mock = new MockHandler([
            new Response(200, [], json_encode([
                'id' => 1,
                'name' => 'John Doe'
            ]))
        ]);

        $handlerStack = HandlerStack::create($mock);
        $client = new Client(['handler' => $handlerStack]);

        $response = $client->get('/api/external/users/1');
        
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertArrayHasKey('name', json_decode($response->getBody(), true));
    }
}
