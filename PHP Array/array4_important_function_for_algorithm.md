When implementing **graph algorithms in PHP**, arrays play a central role, since PHP doesn't have built-in graph structures like some other languages. Here's a list of **important PHP array functions** you’ll likely use when building or working with graphs (especially adjacency matrices or adjacency lists):

---

### 🔹 **1. `in_array()`**

Checks if a value exists in an array.

```php
if (in_array("A", $nodes)) {
    // Node exists
}
```

### 🔹 **2. `array_search()`**

Returns the index/key of a value in an array.

```php
$index = array_search("A", $nodes);  // Gets the index of node "A"
```

### 🔹 **3. `array_fill()`**

Creates a new array filled with a given value — helpful for initializing rows in an adjacency matrix.

```php
$row = array_fill(0, $nodes_count, 0);
```

### 🔹 **4. `array_push()`**

Adds one or more elements to the end of an array — alternative to `$array[] = $value`.

```php
array_push($nodes, "B");
```

### 🔹 **5. `array_keys()`**

Gets all keys from an associative array — useful when dealing with an adjacency list.

```php
$keys = array_keys($adjacencyList);
```

### 🔹 **6. `array_values()`**

Returns all the values from an array.

```php
$values = array_values($adjacencyList["A"]);
```

### 🔹 **7. `count()`**

Gets the number of elements in an array — often used to loop through nodes or neighbors.

```php
$size = count($nodes);
```

### 🔹 **8. `foreach` (language construct)**

Crucial for iterating over arrays — used in nearly every graph algorithm (e.g., BFS, DFS).

```php
foreach ($graph[$nodeIndex] as $neighborIndex => $isConnected) {
    if ($isConnected) {
        // process neighbor
    }
}
```

### 🔹 **9. `array_merge()`**

Merges two or more arrays — may help when combining neighbor lists or graphs.

```php
$combined = array_merge($graph1[$i], $graph2[$i]);
```

### 🔹 **10. `array_map()` / `array_walk()`**

Used for applying functions to array elements (e.g., resetting visitation states).

```php
$visited = array_map(fn() => false, $nodes);
```

---

### Bonus (Associative arrays for Adjacency Lists):

PHP's associative arrays are perfect for adjacency lists:

```php
$adjacencyList = [
    "A" => ["B", "C"],
    "B" => ["A", "D"],
];
```

---

### Example Use Case in BFS:

```php
$visited = [];
$queue = [];

$start = "A";
$visited[$start] = true;
$queue[] = $start;

while (!empty($queue)) {
    $node = array_shift($queue); // dequeue

    foreach ($adjacencyList[$node] as $neighbor) {
        if (!isset($visited[$neighbor])) {
            $visited[$neighbor] = true;
            $queue[] = $neighbor;
        }
    }
}
```

---

Let me know if you want a working example of BFS, DFS, or Dijkstra’s algorithm in PHP!
