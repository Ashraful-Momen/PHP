# Complete PHP Concurrency Guide

## Table of Contents
1. [Understanding Concurrency in PHP](#understanding)
2. [Process Control](#process-control)
3. [Multi-Threading with pthreads](#pthreads)
4. [Asynchronous Programming](#async)
5. [Parallel Processing](#parallel)
6. [Swoole Extension](#swoole)
7. [ReactPHP](#reactphp)
8. [Best Practices](#best-practices)

## 1. Understanding Concurrency in PHP {#understanding}

### Basic Concepts
```php
// PHP is traditionally single-threaded
// Main ways to achieve concurrency:
// 1. Process Control (pcntl)
// 2. Multi-Threading (pthreads)
// 3. Asynchronous Programming
// 4. Parallel Processing
// 5. Event Loop Libraries
```

### Process Models
```php
// Sequential Processing (Traditional)
foreach ($items as $item) {
    process($item);    // Each item processed one after another
}

// Parallel Processing
$processes = [];
foreach ($items as $item) {
    $pid = pcntl_fork();    // Create new process
    if ($pid == 0) {        // Child process
        process($item);
        exit;               // Exit child process
    } else {               // Parent process
        $processes[] = $pid;
    }
}

// Wait for all processes
foreach ($processes as $pid) {
    pcntl_waitpid($pid, $status);
}
```

## 2. Process Control (pcntl) {#process-control}

### Basic Process Management
```php
// Fork a process
$pid = pcntl_fork();
if ($pid == -1) {
    // Fork failed
    die('Could not fork');
} else if ($pid) {
    // Parent process
    echo "Parent process (PID: " . getmypid() . ")\n";
    pcntl_wait($status); // Wait for child
} else {
    // Child process
    echo "Child process (PID: " . getmypid() . ")\n";
    // Do child process work
    exit(0);
}

// Signal handling
declare(ticks = 1); // Enable tick processing for signal handling

// Register signal handler
pcntl_signal(SIGTERM, function($signo) {
    echo "Received signal $signo\n";
    exit;
});
```

### Process Pools
```php
class ProcessPool {
    private $size;
    private $processes = [];
    
    public function __construct(int $size) {
        $this->size = $size;
    }
    
    public function execute(array $tasks) {
        $chunks = array_chunk($tasks, ceil(count($tasks) / $this->size));
        
        foreach ($chunks as $chunk) {
            $pid = pcntl_fork();
            
            if ($pid == -1) {
                die('Could not fork');
            } else if ($pid) {
                // Parent
                $this->processes[] = $pid;
            } else {
                // Child
                foreach ($chunk as $task) {
                    $this->processTask($task);
                }
                exit(0);
            }
        }
        
        // Wait for all processes
        foreach ($this->processes as $pid) {
            pcntl_waitpid($pid, $status);
        }
    }
    
    private function processTask($task) {
        // Process individual task
    }
}

// Usage
$pool = new ProcessPool(4);  // Create pool with 4 processes
$pool->execute($tasks);      // Execute tasks in parallel
```

## 3. Multi-Threading with pthreads {#pthreads}

### Basic Threading
```php
// Define a thread class
class WorkerThread extends Thread {
    private $work;
    
    public function __construct($work) {
        $this->work = $work;
    }
    
    public function run() {
        // This is the code that will run in the thread
        printf("Thread #%lu working on %s\n", $this->getThreadId(), $this->work);
    }
}

// Create and start threads
$threads = [];
for ($i = 0; $i < 4; $i++) {
    $threads[$i] = new WorkerThread("Task $i");
    $threads[$i]->start();
}

// Wait for threads to finish
foreach ($threads as $thread) {
    $thread->join();
}
```

### Thread Pool Implementation
```php
class ThreadPool {
    private $size;
    private $workers = [];
    private $queue;
    
    public function __construct(int $size) {
        $this->size = $size;
        $this->queue = new Threaded();
        
        // Create worker threads
        for ($i = 0; $i < $this->size; $i++) {
            $this->workers[$i] = new Worker($this->queue);
            $this->workers[$i]->start();
        }
    }
    
    public function submit($task) {
        $this->queue[] = $task;
    }
    
    public function shutdown() {
        foreach ($this->workers as $worker) {
            $worker->shutdown();
        }
    }
}

class Worker extends Thread {
    private $queue;
    
    public function __construct($queue) {
        $this->queue = $queue;
    }
    
    public function run() {
        while (true) {
            if (count($this->queue)) {
                $task = $this->queue->shift();
                if ($task) {
                    call_user_func($task);
                }
            }
            usleep(100);
        }
    }
}
```

## 4. Asynchronous Programming {#async}

### Promises and Futures
```php
// Using Guzzle Promises
use GuzzleHttp\Promise\Promise;

$promise = new Promise(
    function () use (&$promise) {
        // Async operation
        $result = someAsyncOperation();
        $promise->resolve($result);
    }
);

$promise
    ->then(
        function ($value) {
            echo "Success: $value\n";
        },
        function ($reason) {
            echo "Failed: $reason\n";
        }
    );
```

### Generators for Async Operations
```php
function async($generator) {
    $iterator = $generator();
    
    function next($iterator, $value = null) {
        try {
            $result = $iterator->send($value);
            if ($result instanceof Promise) {
                $result->then(
                    function ($value) use ($iterator) {
                        next($iterator, $value);
                    },
                    function ($error) use ($iterator) {
                        $iterator->throw($error);
                    }
                );
            }
        } catch (Exception $e) {
            // Handle error
        }
    }
    
    next($iterator);
}

// Usage
async(function () {
    try {
        $result1 = yield someAsyncOperation();
        $result2 = yield anotherAsyncOperation($result1);
        echo "Final result: $result2\n";
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
});
```

## 5. Parallel Processing {#parallel}

### Using parallel Extension
```php
// Create a runtime
$runtime = new \parallel\Runtime();

// Execute code in parallel
$future = $runtime->run(function() {
    // This code runs in parallel
    $result = heavyComputation();
    return $result;
});

// Get result
$result = $future->value();

// Multiple parallel operations
$futures = [];
foreach ($data as $item) {
    $runtime = new \parallel\Runtime();
    $futures[] = $runtime->run(function() use ($item) {
        return processItem($item);
    });
}

// Collect results
$results = [];
foreach ($futures as $future) {
    $results[] = $future->value();
}
```

## 6. Swoole Extension {#swoole}

### HTTP Server
```php
$http = new Swoole\HTTP\Server("127.0.0.1", 9501);

$http->on("start", function ($server) {
    echo "Swoole http server is started at http://127.0.0.1:9501\n";
});

$http->on("request", function ($request, $response) {
    $response->header("Content-Type", "text/plain");
    $response->end("Hello World\n");
});

$http->start();
```

### Coroutines
```php
Co\run(function() {
    // Create multiple coroutines
    go(function() {
        $mysql = new Swoole\Coroutine\MySQL();
        $mysql->connect([
            'host' => '127.0.0.1',
            'user' => 'root',
            'password' => 'root',
            'database' => 'test',
        ]);
        $result = $mysql->query('SELECT * FROM users');
    });
    
    go(function() {
        $redis = new Swoole\Coroutine\Redis();
        $redis->connect('127.0.0.1', 6379);
        $value = $redis->get('key');
    });
});
```

## 7. ReactPHP {#reactphp}

### Event Loop
```php
$loop = React\EventLoop\Factory::create();

// Timer
$loop->addPeriodicTimer(1, function () {
    echo "Tick\n";
});

// Async file operations
$filesystem = React\Filesystem\Filesystem::create($loop);
$filesystem->file('test.txt')->getContents()->then(
    function ($contents) {
        echo $contents;
    },
    function ($error) {
        echo "Error: " . $error->getMessage() . "\n";
    }
);

// HTTP Client
$client = new React\Http\Browser($loop);
$client->get('http://example.com/')->then(
    function (Psr\Http\Message\ResponseInterface $response) {
        echo $response->getBody();
    }
);

$loop->run();
```

## 8. Best Practices {#best-practices}

### Resource Management
```php
// Proper resource cleanup
function cleanupProcess() {
    // Clean up resources
    global $resources;
    foreach ($resources as $resource) {
        $resource->close();
    }
}

// Register shutdown function
register_shutdown_function('cleanupProcess');
```

### Error Handling
```php
// Process error handling
function handleProcessError($errno, $errstr, $errfile, $errline) {
    // Log error
    error_log("Process error: [$errno] $errstr in $errfile on line $errline");
    
    // Terminate process gracefully
    exit(1);
}

set_error_handler('handleProcessError');
```

### Performance Monitoring
```php
class ProcessMonitor {
    private $startTime;
    private $memoryStart;
    
    public function start() {
        $this->startTime = microtime(true);
        $this->memoryStart = memory_get_usage();
    }
    
    public function end() {
        $duration = microtime(true) - $this->startTime;
        $memoryUsed = memory_get_usage() - $this->memoryStart;
        
        echo sprintf(
            "Process took %.2f seconds and used %.2f MB memory\n",
            $duration,
            $memoryUsed / 1024 / 1024
        );
    }
}
```

Remember:
1. Choose the right concurrency model for your needs
2. Always handle process/thread cleanup properly
3. Implement proper error handling
4. Monitor resource usage
5. Use appropriate locking mechanisms
6. Consider using existing frameworks for complex concurrent operations
7. Test thoroughly in production-like environments
8. Document concurrent code clearly
9. Handle edge cases and failures gracefully
10. Consider scalability implications

This guide covers the main aspects of concurrency in PHP. Each approach has its own use cases and trade-offs. Choose the one that best fits your specific requirements.
