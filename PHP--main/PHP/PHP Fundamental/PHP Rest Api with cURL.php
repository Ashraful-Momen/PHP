<?php
class ProductAPI {
    private $baseUrl = 'http://your-api-domain.com/api';
    private $apiKey = 'your_api_key_here';

    // Generic cURL request handler
    private function makeRequest($endpoint, $method = 'GET', $data = null, $files = null) {
        $url = $this->baseUrl . $endpoint;
        $curl = curl_init();

        // Basic cURL options
        $options = [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_HTTPHEADER => [
                'Authorization: Bearer ' . $this->apiKey,
                'Accept: application/json'
            ]
        ];

        // Handle different HTTP methods and data
        if ($method === 'POST' || $method === 'PUT' || $method === 'PATCH') {
            if ($files) {
                // Handle multipart form data for files
                $formData = [];
                
                // Add file data
                foreach ($files as $key => $filePath) {
                    $formData[$key] = new CURLFile(
                        $filePath,
                        mime_content_type($filePath),
                        basename($filePath)
                    );
                }

                // Add regular data
                if ($data) {
                    foreach ($data as $key => $value) {
                        $formData[$key] = $value;
                    }
                }

                $options[CURLOPT_POSTFIELDS] = $formData;
                $options[CURLOPT_HTTPHEADER][] = 'Content-Type: multipart/form-data';
            } else {
                // Regular JSON data
                $options[CURLOPT_POSTFIELDS] = json_encode($data);
                $options[CURLOPT_HTTPHEADER][] = 'Content-Type: application/json';
            }
        } elseif ($method === 'GET' && $data) {
            // Append query parameters for GET requests
            $url .= '?' . http_build_query($data);
            $options[CURLOPT_URL] = $url;
        }

        curl_setopt_array($curl, $options);

        // Execute request
        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $error = curl_error($curl);

        curl_close($curl);

        if ($error) {
            return [
                'status' => 'error',
                'message' => $error,
                'http_code' => $httpCode
            ];
        }

        return [
            'status' => 'success',
            'data' => json_decode($response, true),
            'http_code' => $httpCode
        ];
    }

    // Create - Add new product with image
    public function createProduct($data, $imagePath = null) {
        $endpoint = '/products';
        $files = $imagePath ? ['image' => $imagePath] : null;
        return $this->makeRequest($endpoint, 'POST', $data, $files);
    }

    // Read - Get products with pagination, sorting, and filtering
    public function getProducts($page = 1, $limit = 10, $sort = 'created_at', $order = 'DESC', $filters = []) {
        $endpoint = '/products';
        $queryParams = array_merge([
            'page' => $page,
            'limit' => $limit,
            'sort' => $sort,
            'order' => $order
        ], $filters);

        return $this->makeRequest($endpoint, 'GET', $queryParams);
    }

    // Search products
    public function searchProducts($query) {
        $endpoint = '/products/search';
        return $this->makeRequest($endpoint, 'GET', ['q' => $query]);
    }

    // Get single product
    public function getProduct($id) {
        $endpoint = "/products/{$id}";
        return $this->makeRequest($endpoint, 'GET');
    }

    // Update product
    public function updateProduct($id, $data, $imagePath = null) {
        $endpoint = "/products/{$id}";
        $files = $imagePath ? ['image' => $imagePath] : null;
        return $this->makeRequest($endpoint, 'PUT', $data, $files);
    }

    // Delete product
    public function deleteProduct($id) {
        $endpoint = "/products/{$id}";
        return $this->makeRequest($endpoint, 'DELETE');
    }

    // Batch operations
    public function batchCreateProducts($products) {
        $endpoint = '/products/batch';
        return $this->makeRequest($endpoint, 'POST', ['products' => $products]);
    }

    // Export products
    public function exportProducts($format = 'csv', $filters = []) {
        $endpoint = '/products/export';
        $queryParams = array_merge(['format' => $format], $filters);
        return $this->makeRequest($endpoint, 'GET', $queryParams);
    }
}

// Usage Examples
try {
    $api = new ProductAPI();

    // Create a new product with image
    $productData = [
        'name' => 'Test Product',
        'description' => 'Product description',
        'price' => 99.99,
        'category' => 'Electronics'
    ];
    $imagePath = '/path/to/image.jpg';
    $createResult = $api->createProduct($productData, $imagePath);
    echo "Create Result:\n";
    print_r($createResult);

    // Get products with pagination, sorting, and filtering
    $filters = [
        'category' => 'Electronics',
        'min_price' => 50,
        'max_price' => 200
    ];
    $productsResult = $api->getProducts(
        page: 1,
        limit: 10,
        sort: 'price',
        order: 'DESC',
        filters: $filters
    );
    echo "\nProducts Result:\n";
    print_r($productsResult);

    // Search products
    $searchResult = $api->searchProducts('test');
    echo "\nSearch Result:\n";
    print_r($searchResult);

    // Get single product
    $productResult = $api->getProduct(1);
    echo "\nSingle Product Result:\n";
    print_r($productResult);

    // Update product
    $updateData = [
        'name' => 'Updated Product Name',
        'price' => 149.99
    ];
    $updateResult = $api->updateProduct(1, $updateData);
    echo "\nUpdate Result:\n";
    print_r($updateResult);

    // Delete product
    $deleteResult = $api->deleteProduct(1);
    echo "\nDelete Result:\n";
    print_r($deleteResult);

    // Batch create products
    $batchProducts = [
        [
            'name' => 'Product 1',
            'price' => 99.99
        ],
        [
            'name' => 'Product 2',
            'price' => 149.99
        ]
    ];
    $batchResult = $api->batchCreateProducts($batchProducts);
    echo "\nBatch Create Result:\n";
    print_r($batchResult);

    // Export products
    $exportResult = $api->exportProducts('csv', ['category' => 'Electronics']);
    echo "\nExport Result:\n";
    print_r($exportResult);

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}

// Error handling function example
function handleApiError($response) {
    if ($response['status'] === 'error') {
        // Log error
        error_log("API Error: " . $response['message']);
        
        // Handle different HTTP status codes
        switch ($response['http_code']) {
            case 400:
                throw new Exception('Bad request: ' . $response['message']);
            case 401:
                throw new Exception('Unauthorized: Please check your API key');
            case 403:
                throw new Exception('Forbidden: You don\'t have permission');
            case 404:
                throw new Exception('Resource not found');
            case 429:
                throw new Exception('Too many requests: Please try again later');
            case 500:
                throw new Exception('Server error: Please try again later');
            default:
                throw new Exception('Unknown error: ' . $response['message']);
        }
    }
    return $response['data'];
}
