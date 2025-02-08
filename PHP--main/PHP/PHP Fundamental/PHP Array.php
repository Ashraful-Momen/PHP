# Complete PHP Array Guide with Line-by-Line Instructions

## Table of Contents
1. [Array Creation and Basic Operations](#basics)
2. [Array Types and Initialization](#types)
3. [Array Functions](#functions)
4. [Array Manipulation](#manipulation)
5. [Array Iteration](#iteration)
6. [Array Sorting](#sorting)
7. [Array Search and Filters](#search)
8. [Multidimensional Arrays](#multidimensional)
9. [Array Best Practices](#best-practices)

## 1. Array Creation and Basic Operations {#basics}

### Array Declaration
```php
// Method 1: Using array() constructor
$fruits = array("apple", "banana", "orange");  
// Traditional way to create array, works in all PHP versions

// Method 2: Using short array syntax [] (PHP 5.4+)
$fruits = ["apple", "banana", "orange"];       
// Modern, preferred way to create arrays

// Creating array with explicit keys
$age = [
    "John" => 25,    // String key => value pair
    "Jane" => 24,    // Each key must be unique
    "Bob" => 30      // Last item can have a trailing comma (PHP 7.3+)
];

// Mixed keys array
$mixed = [
    "name" => "John",    // String key
    42 => "answer",      // Integer key
    "greeting"           // Implicit numeric key (will be 43)
];

// Creating array with range
$numbers = range(1, 5);          // Creates [1, 2, 3, 4, 5]
$letters = range('a', 'e');      // Creates ['a', 'b', 'c', 'd', 'e']
$steps = range(0, 10, 2);        // Creates [0, 2, 4, 6, 8, 10]
```

### Array Access and Modification
```php
// Accessing elements
$fruits = ["apple", "banana", "orange"];
echo $fruits[0];             // Outputs: apple (zero-based indexing)
echo $fruits[count($fruits)-1];  // Outputs: orange (last element)

// Adding elements
$fruits[] = "grape";         // Adds to end of array
array_push($fruits, "mango"); // Also adds to end
array_unshift($fruits, "lemon"); // Adds to beginning

// Modifying elements
$fruits[1] = "pear";         // Directly updating by index
$age["John"] = 26;           // Updating associative array value

// Removing elements
unset($fruits[1]);           // Removes element (leaves gap in keys)
$last = array_pop($fruits);  // Removes and returns last element
$first = array_shift($fruits); // Removes and returns first element
```

## 2. Array Types and Initialization {#types}

### Indexed Arrays
```php
// Numeric indexed array
$colors = [
    "red",      // Index 0
    "green",    // Index 1
    "blue"      // Index 2
];

// Accessing indexed arrays
echo $colors[0];     // Outputs: red
$colors[] = "yellow"; // Adds to next available index (3)

// Checking if index exists
isset($colors[2]);   // Returns true if index exists
```

### Associative Arrays
```php
// Key-value pairs
$user = [
    "name" => "John Doe",    // String keys
    "email" => "john@example.com",
    "age" => 25             // Each key must be unique
];

// Accessing associative arrays
echo $user["name"];         // Outputs: John Doe

// Checking if key exists
isset($user["email"]);      // Returns true if key exists
array_key_exists("age", $user); // Also checks for NULL values
```

### Mixed Arrays
```php
// Combining indexed and associative elements
$mixed = [
    "name" => "John",    // Associative element
    42,                  // Numeric index (0)
    "age" => 25,        // Associative element
    "Hello"             // Numeric index (1)
];

// PHP automatically manages indexes
$mixed[] = "World";     // Gets next numeric index (2)
```

## 3. Array Functions {#functions}

### Array Information Functions
```php
// Count elements
$count = count($array);         // Returns number of elements
$size = sizeof($array);         // Alias of count()

// Check if variable is array
is_array($variable);            // Returns true if variable is array

// Get array keys and values
$keys = array_keys($array);     // Returns array of all keys
$values = array_values($array); // Returns array of all values

// Get first and last elements
$first = reset($array);         // Returns first element
$last = end($array);           // Returns last element
```

### Array Transformation Functions
```php
// Merge arrays
$merged = array_merge($array1, $array2);   
// Combines arrays, reindexes numeric keys
// For associative arrays, later values overwrite earlier ones

// Combine arrays
$keys = ['name', 'age'];
$values = ['John', 25];
$combined = array_combine($keys, $values);
// Creates associative array from keys and values arrays

// Split array
$chunks = array_chunk($array, 2);    
// Splits array into smaller arrays of size 2

// Slice array
$slice = array_slice($array, 2, 3);  
// Returns portion of array (offset 2, length 3)

// Map function to array
$doubled = array_map(function($n) {
    return $n * 2;     // Applies function to each element
}, $numbers);

// Filter array
$filtered = array_filter($array, function($value) {
    return $value > 0;  // Keeps only elements that return true
});

// Reduce array
$sum = array_reduce($array, function($carry, $item) {
    return $carry + $item;  // Reduces array to single value
}, 0);
```

## 4. Array Manipulation {#manipulation}

### Adding and Removing Elements
```php
// Adding elements
$array[] = $value;              // Add to end (numeric index)
$array[$key] = $value;          // Add with specific key
array_push($array, $value1, $value2); // Add multiple to end
array_unshift($array, $value);  // Add to beginning

// Removing elements
unset($array[$key]);           // Remove specific element
$last = array_pop($array);     // Remove and return last element
$first = array_shift($array);  // Remove and return first element

// Splicing array
array_splice($array, 2, 1, ['new']);  
// Remove 1 element at index 2 and insert 'new'
```

### Array Operations
```php
// Union operator
$array3 = $array1 + $array2;    
// Adds elements from $array2 if key doesn't exist in $array1

// Difference
$diff = array_diff($array1, $array2);  
// Returns elements in $array1 that aren't in $array2

// Intersection
$common = array_intersect($array1, $array2);  
// Returns elements common to both arrays

// Unique values
$unique = array_unique($array);  
// Removes duplicate values
```

## 5. Array Iteration {#iteration}

### Loops and Iteration
```php
// foreach loop - preferred for arrays
foreach ($array as $value) {
    echo $value;    // Access each value
}

// foreach with key
foreach ($array as $key => $value) {
    echo "$key => $value";    // Access both key and value
}

// for loop - when index is needed
for ($i = 0; $i < count($array); $i++) {
    echo $array[$i];    // Access by index
}

// while loop with each()
while ($element = each($array)) {
    echo $element['key'] . ' => ' . $element['value'];
}

// Array iterator
$iterator = new ArrayIterator($array);
while ($iterator->valid()) {
    echo $iterator->current();
    $iterator->next();
}
```

## 6. Array Sorting {#sorting}

### Basic Sorting
```php
// Sort indexed array
sort($array);              // Sort values ascending, reindex
rsort($array);            // Sort values descending, reindex

// Sort associative array
asort($array);            // Sort values ascending, maintain keys
arsort($array);           // Sort values descending, maintain keys
ksort($array);            // Sort by keys ascending
krsort($array);           // Sort by keys descending

// Natural sorting
natsort($array);          // Natural order sort ("2" < "10")
natcasesort($array);      // Natural order sort, case-insensitive
```

### Custom Sorting
```php
// Using usort() for custom comparison
usort($array, function($a, $b) {
    return $a['priority'] <=> $b['priority'];  // Sort by priority
});

// Using uasort() to maintain keys
uasort($array, function($a, $b) {
    return strcmp($a['name'], $b['name']);  // Sort by name
});
```

## 7. Array Search and Filters {#search}

### Searching Arrays
```php
// Check if value exists
in_array("apple", $fruits);              // Returns true/false
in_array("apple", $fruits, true);        // Strict type checking

// Find key for value
$key = array_search("apple", $fruits);   // Returns key or false

// Find all matching keys
$keys = array_keys($array, "value");     // Returns array of keys

// Filter array
$filtered = array_filter($array, function($value) {
    return $value > 10;                  // Keep values > 10
});

// Search recursive arrays
array_walk_recursive($array, function($value, $key) {
    // Process each value in nested arrays
});
```

## 8. Multidimensional Arrays {#multidimensional}

### Creating and Accessing
```php
// Two-dimensional array
$matrix = [
    [1, 2, 3],           // Row 0
    [4, 5, 6],           // Row 1
    [7, 8, 9]            // Row 2
];

// Accessing elements
echo $matrix[1][2];      // Outputs: 6 (row 1, column 2)

// Associative multidimensional array
$users = [
    "john" => [
        "name" => "John Doe",
        "age" => 25,
        "email" => "john@example.com"
    ],
    "jane" => [
        "name" => "Jane Smith",
        "age" => 24,
        "email" => "jane@example.com"
    ]
];

// Accessing nested elements
echo $users["john"]["email"];  // Outputs: john@example.com
```

### Processing Nested Arrays
```php
// Recursive array processing
function processArray($array, $level = 0) {
    foreach ($array as $key => $value) {
        if (is_array($value)) {
            processArray($value, $level + 1);  // Recurse
        } else {
            echo str_repeat("  ", $level) . "$key => $value\n";
        }
    }
}

// Flattening nested arrays
function flattenArray($array) {
    $result = [];
    array_walk_recursive($array, function($value) use (&$result) {
        $result[] = $value;
    });
    return $result;
}
```

## 9. Array Best Practices {#best-practices}

### Performance Optimization
```php
// Pre-allocate array size for large arrays
$array = array_fill(0, 1000, null);

// Use references for large arrays in loops
foreach ($largeArray as &$value) {
    $value *= 2;    // Modify in place
}
unset($value);      // Unset reference after loop

// Use array_column for extracting data
$names = array_column($users, 'name');  // Get all names

// Use array_replace instead of loop
$defaults = ['color' => 'red', 'size' => 'medium'];
$options = array_replace($defaults, $userOptions);
```

### Security Considerations
```php
// Always validate array inputs
if (!is_array($input)) {
    throw new InvalidArgumentException('Array expected');
}

// Check array depth for nested arrays
function getArrayDepth($array) {
    $maxDepth = 1;
    foreach ($array as $value) {
        if (is_array($value)) {
            $depth = getArrayDepth($value) + 1;
            $maxDepth = max($maxDepth, $depth);
        }
    }
    return $maxDepth;
}

// Sanitize array values
$sanitized = array_map('htmlspecialchars', $userInput);
```

### Memory Management
```php
// Clear large arrays when done
$largeArray = null;      // Mark for garbage collection

// Unset individual elements
unset($array[$key]);     // Free memory for specific element

// Use generators for large datasets
function getRows($file) {
    $handle = fopen($file, 'r');
    while (($row = fgetcsv($handle)) !== false) {
        yield $row;      // Memory efficient iteration
    }
    fclose($handle);
}
```

Remember:
1. Choose appropriate array type (indexed vs associative)
2. Use modern array syntax []
3. Consider memory usage for large arrays
4. Use built-in functions when available
5. Validate array inputs
6. Consider using generators for large datasets
7. Document complex array structures
8. Use type hints when possible
9. Handle edge cases and errors
10. Keep security in mind when working with user input

This guide covers comprehensive aspects of PHP array manipulation with detailed explanations and best practices.
