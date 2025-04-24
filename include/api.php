<?php
require_once 'auth.php';

class APIResponse {
    private $status;
    private $message;
    private $data;
    private $errors;

    public function __construct() {
        $this->status = 'success';
        $this->message = '';
        $this->data = [];
        $this->errors = [];
    }

    public function setStatus($status) {
        $this->status = $status;
        return $this;
    }

    public function setMessage($message) {
        $this->message = $message;
        return $this;
    }

    public function setData($data) {
        $this->data = $data;
        return $this;
    }

    public function addError($error) {
        $this->errors[] = $error;
        return $this;
    }

    public function send() {
        header('Content-Type: application/json');
        echo json_encode([
            'status' => $this->status,
            'message' => $this->message,
            'data' => $this->data,
            'errors' => $this->errors
        ]);
        exit;
    }

    public static function success($data = [], $message = 'Operation successful') {
        $response = new self();
        $response->setData($data)->setMessage($message)->send();
    }

    public static function error($message = 'An error occurred', $errors = []) {
        $response = new self();
        $response->setStatus('error')
                ->setMessage($message)
                ->setData([]);
        
        if (!empty($errors)) {
            foreach ($errors as $error) {
                $response->addError($error);
            }
        }
        
        $response->send();
    }

    public static function notFound($message = 'Resource not found') {
        http_response_code(404);
        self::error($message);
    }

    public static function unauthorized($message = 'Unauthorized access') {
        http_response_code(401);
        self::error($message);
    }

    public static function forbidden($message = 'Access forbidden') {
        http_response_code(403);
        self::error($message);
    }

    public static function badRequest($message = 'Invalid request', $errors = []) {
        http_response_code(400);
        self::error($message, $errors);
    }

    public static function serverError($message = 'Internal server error') {
        http_response_code(500);
        self::error($message);
    }
}

class APIHandler {
    private $method;
    private $endpoint;
    private $params;
    private $headers;

    public function __construct() {
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->endpoint = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $this->params = $this->getParams();
        $this->headers = getallheaders();
    }

    private function getParams() {
        switch ($this->method) {
            case 'GET':
                return $_GET;
            case 'POST':
                return $_POST;
            case 'PUT':
            case 'DELETE':
                parse_str(file_get_contents('php://input'), $params);
                return $params;
            default:
                return [];
        }
    }

    public function validateRequest() {
        // Check for required headers
        if (!isset($this->headers['Content-Type']) || $this->headers['Content-Type'] !== 'application/json') {
            APIResponse::badRequest('Invalid content type');
        }

        // Validate CSRF token for non-GET requests
        if ($this->method !== 'GET') {
            if (!isset($this->headers['X-CSRF-Token']) || !validateCSRFToken($this->headers['X-CSRF-Token'])) {
                APIResponse::forbidden('Invalid CSRF token');
            }
        }

        // Check for required authentication
        if (strpos($this->endpoint, '/api/') === 0 && !isLoggedIn()) {
            APIResponse::unauthorized('Authentication required');
        }

        return true;
    }

    public function handleRequest() {
        try {
            $this->validateRequest();

            // Route the request
            $route = str_replace('/api/', '', $this->endpoint);
            $parts = explode('/', $route);
            $controller = $parts[0] ?? 'index';
            $action = $parts[1] ?? 'index';

            // Include the controller file
            $controllerFile = 'controllers/' . $controller . '.php';
            if (!file_exists($controllerFile)) {
                APIResponse::notFound('Controller not found');
            }

            require_once $controllerFile;
            $controllerClass = ucfirst($controller) . 'Controller';
            if (!class_exists($controllerClass)) {
                APIResponse::notFound('Controller class not found');
            }

            $controllerInstance = new $controllerClass();
            if (!method_exists($controllerInstance, $action)) {
                APIResponse::notFound('Action not found');
            }

            // Call the action method
            $result = $controllerInstance->$action($this->params);
            APIResponse::success($result);

        } catch (Exception $e) {
            APIResponse::serverError($e->getMessage());
        }
    }
}

// Example usage:
/*
$api = new APIHandler();
$api->handleRequest();
*/
?> 